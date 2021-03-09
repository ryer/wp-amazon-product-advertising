<?php

require_once __DIR__ . '/Amazon_Product_Advertising_Options.php';
require_once __DIR__ . '/Amazon_Product_Advertising_PostMeta.php';
require_once __DIR__ . '/Amazon_Product_Advertising_CachedPAAPI.php';

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_Frontend
{
    /**
     * init
     */
    public static function init()
    {
        add_filter('amazon_pa_render', array(__CLASS__, 'amazon_pa_render'));
        add_shortcode('amazon_pa', array(__CLASS__, 'amazon_product_advertising'));
    }

    public static function amazon_product_advertising($values)
    {
        $theDefaultParams = Amazon_Product_Advertising_PostMeta::getTheAmazonSearchParams();
        if (preg_match('/^[_a-z]+=/', $theDefaultParams)) {
            $defaults = shortcode_parse_atts($theDefaultParams);
        } else {
            $defaults = ['keywords' => $theDefaultParams];
        }

        $params = array_merge($defaults, $values);
        $params = apply_filters('amazon_pa_params', $params);
        return '<pre>' . print_r($params, 1);

        $params['access_key'] = Amazon_Product_Advertising_Options::getAwsAccessKeyId();
        $params['secret_key'] = Amazon_Product_Advertising_Options::getAwsSecretAccessKeyId();
        $params['associate_tag'] = Amazon_Product_Advertising_Options::getAmazonAssociateTag();

        $searchResult = Amazon_Product_Advertising_CachedPAAPI::searchItems($params);
        $items = array_slice($searchResult['Items'], 0, Amazon_Product_Advertising_AdvancedOptions::getDisplayLimit());
        $items = apply_filters('amazon_pa_items', $items);

        return apply_filters('amazon_pa_render', $items);
    }

    /**
     * @param array $items
     * @return string
     * @noinspection PhpUnused
     */
    public static function amazon_pa_render($items)
    {
        $content = '<ul class="amazon-pa">';

        foreach ($items as $it) {
            $escTitle = htmlspecialchars($it['ItemInfo']['Title']['DisplayValue'], ENT_QUOTES);
            $content .= <<<____________EOL
            <li>
                <a href="{$it['DetailPageURL']}">
                    <img src="{$it['Images']['Primary']['Large']['URL']}" alt="amazon product image">
                    <p>{$escTitle}</p>
                </a>
            </li>
____________EOL;
        }

        $content .= '</ul>';
        return $content;
    }
}

/*
    [0] => Array
        (
            [ASIN] => 4062784467
            [DetailPageURL] => https://www.amazon.co.jp/dp/4062784467?tag=xxxxxx&linkCode=osi&th=1&psc=1
            [Images] => Array
                (
                    [Primary] => Array
                        (
                            [Large] => Array
                                (
                                    [Height] => 500
                                    [URL] => https://m.media-amazon.com/images/I/51M-Ghq0XML.jpg
                                    [Width] => 365
                                )

                            [Medium] => Array
                                (
                                    [Height] => 160
                                    [URL] => https://m.media-amazon.com/images/I/51M-Ghq0XML._SL160_.jpg
                                    [Width] => 117
                                )

                            [Small] => Array
                                (
                                    [Height] => 75
                                    [URL] => https://m.media-amazon.com/images/I/51M-Ghq0XML._SL75_.jpg
                                    [Width] => 55
                                )

                        )

                )

            [ItemInfo] => Array
                (
                    [ByLineInfo] => Array
                        (
                            [Brand] => Array
                                (
                                    [DisplayValue] => 講談社
                                    [Label] => Brand
                                    [Locale] => ja_JP
                                )

                            [Contributors] => Array
                                (
                                    [0] => Array
                                        (
                                            [Locale] => ja_JP
                                            [Name] => 福森 道歩
                                            [Role] => 著
                                            [RoleType] => author
                                        )

                                )

                            [Manufacturer] => Array
                                (
                                    [DisplayValue] => 講談社
                                    [Label] => Manufacturer
                                    [Locale] => ja_JP
                                )

                        )

                    [ProductInfo] => Array
                        (
                            [IsAdultProduct] => Array
                                (
                                    [DisplayValue] =>
                                    [Label] => IsAdultProduct
                                    [Locale] => en_US
                                )

                            [ItemDimensions] => Array
                                (
                                    [Height] => Array
                                        (
                                            [DisplayValue] => 10.2362
                                            [Label] => Height
                                            [Locale] => ja_JP
                                            [Unit] => インチ
                                        )

                                    [Length] => Array
                                        (
                                            [DisplayValue] => 7.4803
                                            [Label] => Length
                                            [Locale] => ja_JP
                                            [Unit] => インチ
                                        )

                                    [Width] => Array
                                        (
                                            [DisplayValue] => 0.31496
                                            [Label] => Width
                                            [Locale] => ja_JP
                                            [Unit] => インチ
                                        )

                                )

                            [UnitCount] => Array
                                (
                                    [DisplayValue] => 1
                                    [Label] => NumberOfItems
                                    [Locale] => en_US
                                )

                        )

                    [Title] => Array
                        (
                            [DisplayValue] => 一年中使える!ご飯炊きからローストビーフまで スゴイぞ!土鍋 (講談社のお料理BOOK)
                            [Label] => Title
                            [Locale] => ja_JP
                        )

                )

            [Offers] => Array
                (
                    [Summaries] => Array
                        (
                            [0] => Array
                                (
                                    [Condition] => Array
                                        (
                                            [Value] => Used
                                        )

                                    [LowestPrice] => Array
                                        (
                                            [Amount] => 797
                                            [Currency] => JPY
                                            [DisplayAmount] => ￥797
                                        )

                                )

                            [1] => Array
                                (
                                    [Condition] => Array
                                        (
                                            [Value] => New
                                        )

                                    [LowestPrice] => Array
                                        (
                                            [Amount] => 1650
                                            [Currency] => JPY
                                            [DisplayAmount] => ￥1,650
                                        )

                                )

                        )

                )

        )
 */