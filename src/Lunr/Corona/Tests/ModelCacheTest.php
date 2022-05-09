<?php

/**
 * This file contains the ModelCacheTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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

}

?>
