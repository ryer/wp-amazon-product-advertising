<?php

require_once __DIR__ . '/apaPAAPI.php';
require_once __DIR__ . '/apaWpMetaCache.php';

/**
 * @package Amazon_Product_Advertising
 */
class apaCachedPAAPI
{
    public function searchItems(array $params)
    {
        $cache = new apaWpMetaCache('amazon_pa_cache', apaOptions::getCacheExpiresSeconds());
        if (!$cache->isCacheAvailable()) {
            return null;
        }

        $cacheKey = sha1(serialize($params));
        $response = $cache->get($cacheKey);
        if (!$response) {
            $response = (new apaPAAPI())->searchItems($params);
            if (!$response) {
                return null;
            }
            $cache->set($cacheKey, $response);
        }

        return $response;
    }
}
