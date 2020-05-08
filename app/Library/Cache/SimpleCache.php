<?php

namespace App\Library\Cache;

use App\Library\Cache\Contracts\CacheInterface;
use Illuminate\Cache\CacheManager;

class SimpleCache implements CacheInterface
{
    /* @var Illuminate\Cache\CacheManager */
    protected $cache;

    /* @var int */
    protected $minutes;

    public function __construct(CacheManager $cache, $minutes = 60)
    {
        $this->cache = $cache;
        $this->minutes = $minutes;
    }

    /**
     * Get
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->cache->get($key);
    }

    /**
     * Put
     *
     * @param string $key
     * @param mixed $value
     * @param integer $minutes
     * @return mixed
     */
    public function put($key, $value, $minutes = null)
    {
        if (is_null($minutes)) {
            $minutes = $this->minutes;
        }

        return $this->cache->put($key, $value, $minutes);
    }

    /**
     * Has
     *
     * @param string $key
     * @return bool
    */
    public function has($key)
    {
        return $this->cache->has($key);
    }
}