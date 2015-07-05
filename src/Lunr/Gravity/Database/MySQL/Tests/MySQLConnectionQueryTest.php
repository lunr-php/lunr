<?php

/**
 * This file contains the MySQLConnectionQueryTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;

/**
 * This class contains query related unit tests for MySQLConnection.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
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

        $this->set_reflection_property_value('mysqli', $mysqli);

        $query = $this->class->query('query');

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

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $mysqli->expects($this->once())
               ->method('query')
               ->will($this->returnValue(TRUE));

        $query = $this->class->query('query');

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

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('query_hint', '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $query = $this->class->query('query');

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

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $hint = $this->get_accessible_reflection_property('query_hint');
        $hint->setValue($this->class, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $this->class->query('query');

        $this->assertSame('', $hint->getValue($this->class));
    }

    /**
     * Test that async_query() returns an AsyncQueryResult that indicates a failed query when not connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $this->set_reflection_property_value('mysqli', $mysqli);

        $query = $this->class->async_query('query');

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

        $this->set_reflection_property_value('mysqli', $mysqli);

        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $mysqli->expects($this->once())
               ->method('query');

        $mysqli->expects($this->once())
               ->method('reap_async_query')
               ->will($this->returnValue(TRUE));

        $query = $this->class->async_query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult', $query);
        $this->assertFalse($query->has_failed());

        $property->setValue($this->class, FALSE);
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

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('query_hint', '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $query = $this->class->async_query('query');

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

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $hint = $this->get_accessible_reflection_property('query_hint');
        $hint->setValue($this->class, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $this->class->async_query('query');

        $this->assertSame('', $hint->getValue($this->class));
    }

}

?>
