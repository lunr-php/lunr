<?php

/**
 * This file contains the ModelCacheTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Model class.
 *
 * @covers Lunr\Corona\Model
 */
class ModelCacheTest extends ModelTest
{

    /**
     * Test that get_from_cache() returns the stored value from cache.
     *
     * @covers \Lunr\Corona\Model::get_from_cache
     */
    public function testGetFromCache()
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->get_accessible_reflection_method('get_from_cache');

        $result = $method->invokeArgs($this->class, [ 'foo' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that set_in_cache() does not store NULL in cache.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testSetInCacheWithNullValue()
    {
        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->cache->expects($this->never())
                    ->method('save');

        $method = $this->get_accessible_reflection_method('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', NULL ]);

        $this->assertFalse($result);
    }

    /**
     * Test that set_in_cache() stores value in cache.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testSetInCache()
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->get_accessible_reflection_method('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar' ]);

        $this->assertTrue($result);
    }

    /**
     * Test that set_in_cache() stores value in cache with a custom expiry time.
     *
     * @covers \Lunr\Corona\Model::set_in_cache
     */
    public function testSetInCacheWithCustomExpiryTime()
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(300);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('bar');

        $method = $this->get_accessible_reflection_method('set_in_cache');

        $result = $method->invokeArgs($this->class, [ 'foo', 'bar', 300 ]);

        $this->assertTrue($result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testCacheIfNeededReturnsWithoutCache()
    {
        $this->set_reflection_property_value('cache', NULL);

        $this->cache->expects($this->never())
                    ->method('getItem');

        $this->item->expects($this->never())
                   ->method('isHit');

        $method = $this->get_accessible_reflection_method('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn ($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testCacheIfNeededReturnsFromCacheIfFound()
    {
        $this->cache->expects($this->once())
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(TRUE);

        $this->item->expects($this->once())
                   ->method('get')
                   ->willReturn('bar');

        $method = $this->get_accessible_reflection_method('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn () => 'test' ]);

        $this->assertEquals('bar', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testCacheIfNeededCachesWhenNeeded()
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->get_accessible_reflection_method('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn () => 'test' ]);

        $this->assertEquals('test', $result);
    }

    /**
     * Test that cache_if_needed() returns the cache item if one is found.
     *
     * @covers \Lunr\Corona\Model::cache_if_needed
     */
    public function testCacheIfNeededCachesWhenNeededWithArgs()
    {
        $this->cache->expects($this->exactly(2))
                    ->method('getItem')
                    ->with('foo')
                    ->willReturn($this->item);

        $this->item->expects($this->once())
                   ->method('isHit')
                   ->willReturn(FALSE);

        $this->item->expects($this->never())
                   ->method('get');

        $this->item->expects($this->once())
                   ->method('expiresAfter')
                   ->with(600);

        $this->item->expects($this->once())
                   ->method('set')
                   ->with('test param');

        $this->cache->expects($this->once())
                    ->method('save')
                    ->with($this->item);

        $method = $this->get_accessible_reflection_method('cache_if_needed');

        $result = $method->invokeArgs($this->class, [ 'foo', fn ($param) => 'test ' . $param, [ 'param' ] ]);

        $this->assertEquals('test param', $result);
    }

}

?>
