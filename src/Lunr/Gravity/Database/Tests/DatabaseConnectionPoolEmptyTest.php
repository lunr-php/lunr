<?php

/**
 * This file contains the DatabaseConnectionPoolEmptyTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;

/**
 * This class contains tests for the DatabaseConnectionPool class.
 * Specifically for the case when there is no database configuration present.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnectionPool
 */
class DatabaseConnectionPoolEmptyTest extends DatabaseConnectionPoolTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->emptySetup();
    }

    /**
     * Test that get_connection returns NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadonlyConnectionReturnsNull(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $this->assertNull($method->invokeArgs($this->pool, [ TRUE, TRUE ]));
    }

    /**
     * Test that get_connection returns NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadWriteConnectionReturnsNull(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $this->assertNull($method->invokeArgs($this->pool, [ TRUE, FALSE ]));
    }

    /**
     * Test that get_connection returns NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadonlyConnectionReturnsNull(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $this->assertNull($method->invokeArgs($this->pool, [ FALSE, TRUE ]));
    }

    /**
     * Test that get_connection returns NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadwriteConnectionReturnsNull(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $this->assertNull($method->invokeArgs($this->pool, [ FALSE, FALSE ]));
    }

    /**
     * Test that get_connection() with empty db config does not alter ro_pool.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadonlyConnectionDoesNotAlterPool(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $method->invokeArgs($this->pool, [ TRUE, TRUE ]);

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadWriteConnectionDoesNotAlterPool(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $method->invokeArgs($this->pool, [ TRUE, FALSE ]);

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter ro_pool.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadonlyConnectionDoesNotAlterPool(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $method->invokeArgs($this->pool, [ FALSE, TRUE ]);

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadWriteConnectionDoesNotAlterPool(): void
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $method->invokeArgs($this->pool, [ FALSE, FALSE ]);

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_new_ro_connection returns NULL.
     *
     * @depends testGetNewAndReadonlyConnectionReturnsNull
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_new_ro_connection
     */
    public function testGetNewRoConnectionReturnsNull(): void
    {
        $this->assertNull($this->pool->get_new_ro_connection());
    }

    /**
     * Test that get_new_rw_connection returns NULL.
     *
     * @depends testGetNewAndReadWriteConnectionReturnsNull
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_new_rw_connection
     */
    public function testGetNewRwConnectionReturnsNull(): void
    {
        $this->assertNull($this->pool->get_new_rw_connection());
    }

    /**
     * Test that get_ro_connection returns NULL.
     *
     * @depends testGetReadonlyConnectionReturnsNull
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_ro_connection
     */
    public function testGetRoConnectionReturnsNull(): void
    {
        $this->assertNull($this->pool->get_ro_connection());
    }

    /**
     * Test that get_rw_connection returns NULL.
     *
     * @depends testGetReadwriteConnectionReturnsNull
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_rw_connection
     */
    public function testGetRwConnectionReturnsNull(): void
    {
        $this->assertNull($this->pool->get_rw_connection());
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @depends testGetNewAndReadonlyConnectionDoesNotAlterPool
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewRoConnectionDoesNotAlterPool(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $this->pool->get_new_ro_connection();

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @depends testGetNewAndReadWriteConnectionDoesNotAlterPool
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewRwConnectionDoesNotAlterPool(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $this->pool->get_new_rw_connection();

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @depends testGetReadonlyConnectionDoesNotAlterPool
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetRoConnectionDoesNotAlterPool(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $this->pool->get_ro_connection();

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

    /**
     * Test that get_connection() with empty db config does not alter rw_pool.
     *
     * @depends testGetReadWriteConnectionDoesNotAlterPool
     * @covers  Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetRwConnectionDoesNotAlterPool(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->pool);

        $this->pool->get_rw_connection();

        $new = $property->getValue($this->pool);

        $this->assertEquals($old, $new);
    }

}

?>
