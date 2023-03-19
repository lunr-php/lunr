<?php

/**
 * This file contains the DatabaseConnectionPoolPublicTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;
use ReflectionClass;

/**
 * This class contains tests for the DatabaseConnectionPool class.
 * Specifically for the case when there is a supported database configuration present.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnectionPool
 */
class DatabaseConnectionPoolPublicTest extends DatabaseConnectionPoolTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->supportedSetup();
    }

    /**
     * Test that get_new_ro_connection() returns a new MySQLConnection.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_new_ro_connection
     */
    public function testGetNewRoConnectionReturnsMysqlConnection(): void
    {
        $dbr = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');

        $property = $dbr->getProperty('readonly');
        $property->setAccessible(TRUE);

        $value = $this->pool->get_new_ro_connection();

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLConnection', $value);
        $this->assertTrue($property->getValue($value));
    }

    /**
     * Test that get_new_rw_connection() returns a new MySQLConnection.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_new_rw_connection
     */
    public function testGetNewRwConnectionReturnsMysqlConnection(): void
    {
        $dbr = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');

        $property = $dbr->getProperty('readonly');
        $property->setAccessible(TRUE);

        $value = $this->pool->get_new_rw_connection();

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLConnection', $value);
        $this->assertFalse($property->getValue($value));
    }

    /**
     * Test that get_new_ro_connection() populates pool with new connections.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_new_ro_connection
     */
    public function testGetNewRoConnectionIncreasesPoolByOne(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $this->pool->get_new_ro_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_new_rw_connection() populates pool with new connections.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_new_rw_connection
     */
    public function testGetNewRwConnectionIncreasesPoolByOne(): void
    {
        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $this->pool->get_new_rw_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_ro_connection() populates the pool if it is empty.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_ro_connection
     */
    public function testGetRoConnectionReturnsNewConnectionIfPoolEmpty(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $this->pool->get_ro_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_rw_connection() populates the pool if it is empty.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_rw_connection
     */
    public function testGetRwConnectionReturnsNewConnectionIfPoolEmpty(): void
    {
        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $this->pool->get_rw_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_ro_connection() returns pooled connetion if requested.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_ro_connection
     */
    public function testGetRoConnectionReturnsPooledConnection(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $this->pool->get_ro_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);

        $value = $this->pool->get_ro_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_rw_connection() returns pooled connetion if requested.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_rw_connection
     */
    public function testGetRwConnectionReturnsPooledConnection(): void
    {
        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $this->pool->get_rw_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);

        $value = $this->pool->get_rw_connection();

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

}

?>
