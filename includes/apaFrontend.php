<?php

require_once __DIR__ . '/apaOptions.php';
require_once __DIR__ . '/apaPostMeta.php';
require_once __DIR__ . '/apaCachedPAAPI.php';

/**
 * @package Amazon_Product_Advertising
 */
class apaFrontend
{
    public static function init()
    {
        add_shortcode('amazon_pa', array(__CLASS__, 'amazon_product_advertising'));
        add_filter('amazon_pa_renderer', array(__CLASS__, 'default_amazon_pa_renderer'), 10, 2);
    }

    public static function amazon_product_advertising($shortCodeParams)
    {
        $shortCodeParams = self::configureParams($shortCodeParams);
        $postMetaParams = self::configureParams(shortcode_parse_atts(apaPostMeta::getTheAmazonSearchParams()));
        $params = apply_filters('amazon_pa_params', array_merge($postMetaParams, $shortCodeParams));
        if (!isset($params['keywords'])) {
            return '';
        }

        $apiParams = apaOptions::getAPIParams();
        $apiParams['access_key'] = apaOptions::getAwsAccessKeyId();
        $apiParams['secret_key'] = apaOptions::getAwsSecretAccessKeyId();
        $apiParams['associate_tag'] = apaOptions::getAmazonAssociateTag();
        $apiParams = array_merge($apiParams, $params);

        $api = new apaCachedPAAPI();
        $response = $api->searchItems($apiParams);
        if (!$response) {
            return '';
        }

        $renderingParams = apaOptions::getRenderingParams();
        $renderingParams = array_merge($renderingParams, $params);

        return apply_filters('amazon_pa_renderer', $response, $renderingParams);
    }

    public static function configureParams($params)
    {
        if (!$params) {
            return [];
        }

        $ret = [];
        $keywords = '';

        foreach ($params as $k => $v) {
            if (is_int($k)) {
                $keywords .= " $v";
            } else {
                $ret[$k] = $v;
            }
        }

        if ($keywords) {
            $ret['keywords'] = $keywords;
        }

        return $ret;
    }

    /**
     * @param array $response search items api response
     * @param array $params
     * @return string html contents
     */
    public static function default_amazon_pa_renderer($response, array $params)
    {
        $items = $response['SearchResult']['Items'];
        $items = array_filter($items, function ($it) {
            return isset($it['Images']['Primary']['Medium']['URL']);
        });
        $items = array_slice($items, 0, $params['display_limit']);
        $items = apply_filters('amazon_pa_items', $items);

        $content = '<ul class="amazon-pa">';

        foreach ($items as $it) {
            $escTitle = htmlspecialchars(mb_strimwidth($it['ItemInfo']['Title']['DisplayValue'], 0, $params['trim_title_width'], '…', 'utf8'), ENT_QUOTES);
            $content .= <<<____________EOL
            <li>
                <a href="{$it['DetailPageURL']}">
                    <img
                        alt="{$escTitle} image"
                        src="{$it['Images']['Primary']['Medium']['URL']}"
                        width="{$it['Images']['Primary']['Medium']['Width']}"
                        height="{$it['Images']['Primary']['Medium']['Height']}"
                        >
                    <p>{$escTitle}</p>
                </a>
            </li>
____________EOL;
        }

        $content .= '</ul>';
        return $content;
    }
}
