<?php

class apaWpMetaCache
{
    private $cachedMemoryStorage;
    private $cacheName;
    private $expiresSeconds;

    public function __construct($cacheName, $expiresSeconds)
    {
        $this->cacheName = $cacheName;
        $this->expiresSeconds = $expiresSeconds;
    }

    public function isCacheAvailable()
    {
        return get_the_ID() or is_category() or is_tag() or is_tax();
    }

    public function get($cacheKey)
    {
        if (!$this->cachedMemoryStorage) {
            $this->cachedMemoryStorage = self::loadStorage();
        }

        if (!isset($this->cachedMemoryStorage[$cacheKey])) {
            return null;
        }

        return $this->cachedMemoryStorage[$cacheKey]['value'];
    }

    public function set($cacheKey, $value)
    {
        if (!$this->cachedMemoryStorage) {
            $this->cachedMemoryStorage = self::loadStorage();
        }

        $this->cachedMemoryStorage[$cacheKey] = ['value' => $value, 'timestamp' => time()];
        self::saveStorage($this->cachedMemoryStorage);
    }

    private function loadStorage()
    {
        $frozen = $this->getMeta();
        if (!$frozen) {
            return [];
        }

        $storage = unserialize(str_replace('{@@@SLASH@@@}', '\\', $frozen));
        if (!$storage) {
            return [];
        }

        foreach (array_keys($storage) as $key) {
            if (($storage[$key]['timestamp'] + $this->expiresSeconds) < time()) {
                unset($storage[$key]);
            }
        }

        return $storage;
    }

    private function saveStorage($storage)
    {
        $frozen = str_replace('\\', '{@@@SLASH@@@}', serialize($storage));
        $this->updateMeta($frozen);
    }

    private function getMeta()
    {
        if (get_the_ID()) {
            return get_post_meta(get_the_ID(), $this->cacheName, true);
        } elseif (is_category() or is_tag() or is_tax()) {
            return get_term_meta(get_queried_object_id(), $this->cacheName, true);
        } else {
            return null;
        }
    }

    private function updateMeta($val)
    {
        if (get_the_ID()) {
            update_post_meta(get_the_ID(), $this->cacheName, $val);
        } elseif (get_queried_object_id()) {
            update_term_meta(get_queried_object_id(), $this->cacheName, $val);
        }
    }
}
