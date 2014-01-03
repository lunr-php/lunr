<?php

/**
 * This file contains the MySQLConnectionQueryTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;

/**
 * This class contains query related unit tests for MySQLConnection.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionQueryTest extends MySQLConnectionTest
{

    /**
     * Test that query() returns a QueryResult that indicates a failed query when not connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $query = $this->db->query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryResult', $query);
        $this->assertTrue($query->has_failed());
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryReturnsQueryResultWhenConnected()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $mysqli->expects($this->once())
               ->method('query')
               ->will($this->returnValue(TRUE));

        $query = $this->db->query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryResult', $query);
        $this->assertFalse($query->has_failed());
    }

    /**
     * Test that query() prepends the SQL query with a query hint if one is set.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryPrependsQueryHintIfPresent()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $hint = $this->db_reflection->getProperty('query_hint');
        $hint->setAccessible(TRUE);
        $hint->setValue($this->db, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $query = $this->db->query('query');

        $this->assertEquals('/*hint*/query', $query->query());
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryResetsQueryHint()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $hint = $this->db_reflection->getProperty('query_hint');
        $hint->setAccessible(TRUE);
        $hint->setValue($this->db, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $this->db->query('query');

        $this->assertSame('', $hint->getValue($this->db));
    }

    /**
     * Test that async_query() returns an AsyncQueryResult that indicates a failed query when not connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $query = $this->db->async_query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryResult', $query);
        $this->assertTrue($query->has_failed());
    }

    /**
     * Test that async_query() returns a AsyncQueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsQueryResultWhenConnected()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $mysqli->expects($this->once())
               ->method('query');

        $mysqli->expects($this->once())
               ->method('reap_async_query')
               ->will($this->returnValue(TRUE));

        $query = $this->db->async_query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult', $query);
        $this->assertFalse($query->has_failed());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test that async_query() prepends the SQL query with a query hint if one is set.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryPrependsQueryHintIfPresent()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $hint = $this->db_reflection->getProperty('query_hint');
        $hint->setAccessible(TRUE);
        $hint->setValue($this->db, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $query = $this->db->async_query('query');

        $this->assertEquals('/*hint*/query', $query->query());
    }

    /**
     * Test that async_query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryResetsQueryHint()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $hint = $this->db_reflection->getProperty('query_hint');
        $hint->setAccessible(TRUE);
        $hint->setValue($this->db, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $this->db->async_query('query');

        $this->assertSame('', $hint->getValue($this->db));
    }

}

?>
