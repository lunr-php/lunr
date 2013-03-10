<?php

/**
 * This file contains the DatabaseConnectionPoolSupportedTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;
use ReflectionClass;

/**
 * This class contains tests for the DatabaseConnectionPool class.
 * Specifically for the case when there is a supported database configuration present.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseConnectionPool
 */
class DatabaseConnectionPoolSupportedTest extends DatabaseConnectionPoolTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->supportedSetup();
    }

    /**
     * Test that get_connection() returns a new MySQLConnection.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadonlyConnectionReturnsMysqlConnection()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $dbr = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');

        $property = $dbr->getProperty('readonly');
        $property->setAccessible(TRUE);

        $value = $method->invokeArgs($this->pool, array(TRUE, TRUE));

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLConnection', $value);
        $this->assertTrue($property->getValue($value));
   }

    /**
     * Test that get_connection() returns a new MySQLConnection.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadWriteConnectionReturnsMysqlConnection()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $dbr = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLConnection');

        $property = $dbr->getProperty('readonly');
        $property->setAccessible(TRUE);

        $value = $method->invokeArgs($this->pool, array(TRUE, FALSE));

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLConnection', $value);
        $this->assertFalse($property->getValue($value));
    }

    /**
     * Test that get_connection() populates pool with new connections.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadonlyConnectionIncreasesPoolByOne()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $method->invokeArgs($this->pool, array(TRUE, TRUE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_connection() populates pool with new connections.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetNewAndReadWriteConnectionIncreasesPoolByOne()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $method->invokeArgs($this->pool, array(TRUE, FALSE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_connection() populates the pool if it is empty.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadonlyConnectionReturnsNewConnectionIfPoolEmpty()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $method->invokeArgs($this->pool, array(FALSE, TRUE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_connection() populates the pool if it is empty.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadWriteConnectionReturnsNewConnectionIfPoolEmpty()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $value = $method->invokeArgs($this->pool, array(FALSE, FALSE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_connection() returns pooled connetion if requested.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadonlyConnectionReturnsPooledConnection()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $method->invokeArgs($this->pool, array(FALSE, TRUE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);

        $value = $method->invokeArgs($this->pool, array(FALSE, TRUE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

    /**
     * Test that get_connection() returns pooled connetion if requested.
     *
     * @covers Lunr\Gravity\Database\DatabaseConnectionPool::get_connection
     */
    public function testGetReadWriteConnectionReturnsPooledConnection()
    {
        $method = $this->pool_reflection->getMethod('get_connection');
        $method->setAccessible(TRUE);

        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $this->assertEmpty($property->getValue($this->pool));

        $method->invokeArgs($this->pool, array(FALSE, FALSE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);

        $value = $method->invokeArgs($this->pool, array(FALSE, FALSE));

        $stored = $property->getValue($this->pool);

        $this->assertCount(1, $stored);
        $this->assertSame($value, $stored[0]);
    }

}

?>
