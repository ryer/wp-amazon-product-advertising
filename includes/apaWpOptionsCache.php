<?php

class apaWpOptionsCache
{
    private $expiresSeconds;

    public function __construct($expiresSeconds)
    {
        $this->expiresSeconds = $expiresSeconds;
    }

    public function get($cacheKey)
    {
        $frozen = get_option($this->makeCacheName($cacheKey));
        if (!$frozen) {
            return null;
        }

        $storage = unserialize(str_replace('{@@@SLASH@@@}', '\\', $frozen));
        if (!isset($storage['timestamp'])) {
            return null;
        }

        if (($storage['timestamp'] + $this->expiresSeconds) < time()) {
            delete_option($this->makeCacheName($cacheKey));
            return null;
        }

        return $storage['value'];
    }

    public function set($cacheKey, $value)
    {
        $storage = ['timestamp' => time(), 'value' => $value];
        $frozen = str_replace('\\', '{@@@SLASH@@@}', serialize($storage));
        update_option($this->makeCacheName($cacheKey), $frozen, 'no');
    }

    private function makeCacheName($cacheKey)
    {
        return "apa_cache_$cacheKey";
    }
}
