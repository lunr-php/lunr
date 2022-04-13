<?php

/**
 * This file contains an Cache class.
 *
 * @package    Lunr\Cache
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Cache;

/**
 * Cache class
 */
class Cache
{

    /**
     * Shared instance of the cache Pool class.
     * @var \Psr\Cache\CacheItemPoolInterface
     */
    protected $cache_pool;

    /**
     * Constructor.
     *
     * @param \Psr\Cache\CacheItemPoolInterface $cache_pool Shared instance of the PSR-6 cache Pool class.
     */
    public function __construct($cache_pool)
    {
        $this->cache_pool = $cache_pool;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->cache_pool);
    }

    /**
     * Get cache item.
     *
     * @param string $key Unique identifier for the data.
     *
     * @return mixed NULL if error, mixed data if successful.
     */
    public function get($key)
    {
        if (empty($key))
        {
            return NULL;
        }

        $item = $this->cache_pool->getItem($key);

        if ($item->isHit() === TRUE)
        {
            return $item->get();
        }

        return NULL;
    }

    /**
     * Set cache item.
     *
     * @param string $key   Unique identifier for the data.
     * @param mixed  $value Data to cache.
     * @param int    $ttl   Time To Live for cache item in seconds.
     *
     * @return boolean True if successful.
     */
    public function set($key, $value, $ttl = 600)
    {
        if (empty($key) || empty($value))
        {
            return FALSE;
        }

        $item = $this->cache_pool->getItem($key);

        $item->expiresAfter($ttl);

        $item->set($value);

        $this->cache_pool->save($item);

        return TRUE;
    }

}

?>
