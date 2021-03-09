<?php

/**
 * @package Amazon_Product_Advertising
 */
class Amazon_Product_Advertising_AdvancedOptions
{
    private static $options = [];

    const DISPLAY_LIMIT = 'display_limit';
    const CACHE_EXPIRES_SECONDS = 'cache_expires_seconds';

    public static function setDisplayLimit($value)
    {
        self::$options[self::DISPLAY_LIMIT] = $value;
    }

    public static function getDisplayLimit()
    {
        return isset(self::$options[self::DISPLAY_LIMIT]) ? self::$options[self::DISPLAY_LIMIT] : 1;
    }

    public static function setCacheExpiresSeconds($value)
    {
        self::$options[self::CACHE_EXPIRES_SECONDS] = $value;
    }

    public static function getCacheExpiresSeconds()
    {
        return isset(self::$options[self::CACHE_EXPIRES_SECONDS]) ? self::$options[self::CACHE_EXPIRES_SECONDS] : 86400; // 1day
    }
}
