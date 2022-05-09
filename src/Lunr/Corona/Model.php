<?php

/**
 * This file contains the Model interface.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Base Model class
 */
class Model
{

    /**
     * Shared instance of the cache Pool class.
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $cache;

    /**
     * Constructor.
     *
     * @param \Psr\Cache\CacheItemPoolInterface $cache Shared instance of the PSR-6 cache Pool class.
     */
    public function __construct($cache)
    {
        $this->cache = $cache;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cache);
    }

    /**
     * Get cache item.
     *
     * @param string $key Unique identifier for the data.
     *
     * @return mixed Cached data
     */
    protected function get_from_cache(string $key)
    {
        return $this->cache->getItem($key)->get();
    }

    /**
     * Set cache item.
     *
     * @param string $key   Unique identifier for the data.
     * @param mixed  $value Data to cache.
     * @param int    $ttl   Time To Live for cache item in seconds.
     *
     * @return boolean True if successful, FALSE when value is NULL.
     */
    protected function set_in_cache(string $key, $value, int $ttl = 600): bool
    {
        if ($value === NULL)
        {
            return FALSE;
        }

        $item = $this->cache->getItem($key);

        $item->expiresAfter($ttl);
        $item->set($value);

        $this->cache->save($item);

        return TRUE;
    }

}

?>
