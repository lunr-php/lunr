<?php

/**
 * This file contains the CacheHandlerDataTest class.
 *
 * @package    Lunr\Cache
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Cache\Tests;

/**
 * This class contains test methods for the Cache class.
 *
 * @covers Lunr\Cache\Cache
 */
class CacheHandlerDataTest extends CacheHandlerTest
{

    /**
     * Test calling get without a key.
     *
     * @covers Lunr\Cache\Cache::get
     */
    public function testGetCallWithoutKey()
    {
        $method = $this->get_accessible_reflection_method('get');
        $this->assertEquals(FALSE, $method->invoke($this->class, NULL));
    }

    /**
     * Test calling get with a miss cache.
     *
     * @covers Lunr\Cache\Cache::get
     */
    public function testGetCallWithMissData()
    {
        $key = 3;

        $item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                      ->disableOriginalConstructor()
                      ->getMock();

        $item->expects($this->once())
             ->method('isHit')
             ->will($this->returnValue(FALSE));

        $this->cache_pool->expects($this->once())
              ->method('getItem')
              ->with($key)
              ->will($this->returnValue($item));

        $method = $this->get_accessible_reflection_method('get');
        $this->assertEquals(FALSE, $method->invoke($this->class, $key));
    }

    /**
     * Test calling get with a hit cache..
     *
     * @covers Lunr\Cache\Cache::get
     */
    public function testGetCallWithHitData()
    {
        $key  = 3;
        $data = 42;

        $item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                      ->disableOriginalConstructor()
                      ->getMock();

        $item->expects($this->once())
             ->method('get')
             ->will($this->returnValue($data));

        $item->expects($this->once())
             ->method('isHit')
             ->will($this->returnValue(TRUE));

        $this->cache_pool->expects($this->once())
              ->method('getItem')
              ->with($key)
              ->will($this->returnValue($item));

        $method = $this->get_accessible_reflection_method('get');
        $this->assertEquals($data, $method->invoke($this->class, $key));
    }

    /**
     * Test calling get without a key.
     *
     * @covers Lunr\Cache\Cache::set
     */
    public function testSetCallWithoutKey()
    {
        $method = $this->get_accessible_reflection_method('set');
        $this->assertEquals(FALSE, $method->invoke($this->class, NULL, 3));
    }

    /**
     * Test calling get without a key.
     *
     * @covers Lunr\Cache\Cache::set
     */
    public function testSetCallWithoutValue()
    {
        $method = $this->get_accessible_reflection_method('set');
        $this->assertEquals(FALSE, $method->invoke($this->class, 42, NULL));
    }

    /**
     * Test calling set cache.
     *
     * @covers Lunr\Cache\Cache::set
     */
    public function testSetCall()
    {
        $key  = 3;
        $data = 42;

        $item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                     ->disableOriginalConstructor()
                     ->getMock();

        $item->expects($this->once())
             ->method('expiresAfter')
             ->with(600);

        $item->expects($this->once())
             ->method('set')
             ->with($data);

        $this->cache_pool->expects($this->once())
                         ->method('getItem')
                         ->with($key)
                         ->will($this->returnValue($item));

        $this->cache_pool->expects($this->once())
                         ->method('save')
                         ->with($item);

        $method = $this->get_accessible_reflection_method('set');
        $this->assertEquals(TRUE, $method->invoke($this->class, $key, $data));
    }

    /**
     * Test calling set cache with custom TTL.
     *
     * @covers Lunr\Cache\Cache::set
     */
    public function testSetCallWithCustomTTL()
    {
        $key  = 3;
        $data = 42;
        $ttl  = 777;

        $item = $this->getMockBuilder('\Psr\Cache\CacheItemInterface')
                     ->disableOriginalConstructor()
                     ->getMock();

        $item->expects($this->once())
             ->method('expiresAfter')
             ->with($ttl);

        $item->expects($this->once())
             ->method('set')
             ->with($data);

        $this->cache_pool->expects($this->once())
                         ->method('getItem')
                         ->with($key)
                         ->will($this->returnValue($item));

        $this->cache_pool->expects($this->once())
                         ->method('save')
                         ->with($item);

        $method = $this->get_accessible_reflection_method('set');
        $this->assertEquals(TRUE, $method->invoke($this->class, $key, $data, $ttl));
    }

}

?>
