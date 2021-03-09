<?php

require_once __DIR__ . '/Amazon_Product_Advertising_AdvancedOptions.php';
require_once __DIR__ . '/Amazon_Product_Advertising_PAAPI.php';

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_CachedPAAPI
{
    /**
     * @param array $params
     * @return array
     */
    public static function searchItems(array $params)
    {
        $cacheKey = self::generateCacheName($params);

        $res = self::getTheCache($cacheKey);
        if (!$res) {
            $res = Amazon_Product_Advertising_PAAPI::searchItems($params);
            self::updateTheCache($cacheKey, $res);
        }

        return $res;
    }

    public static function getTheCache($cacheKey)
    {
        $serializedValue = get_post_meta(get_the_ID(), $cacheKey, true);
        if (!$serializedValue) {
            return null;
        }

        $value = unserialize($serializedValue);
        $storedTime = $value[1];
        if (time() > ($storedTime + Amazon_Product_Advertising_AdvancedOptions::getCacheExpiresSeconds())) {
            delete_post_meta(get_the_ID(), $cacheKey);
            return null;
        }

        return $value[0];
    }

    public static function updateTheCache($cacheKey, $value)
    {
        $serializedValue = serialize([$value, time()]);
        update_post_meta(get_the_ID(), $cacheKey, $serializedValue);
    }

    private static function generateCacheName(array $params)
    {
        return 'amazon_product_advertising_cache_' . sha1(serialize($params));
    }
}
