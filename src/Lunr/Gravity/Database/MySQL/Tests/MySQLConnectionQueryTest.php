<?php

/**
 * This file contains the MySQLConnectionQueryTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
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
     * Test that query() throws an exception when not connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->logger->expects($this->never())
                     ->method('debug');

        $this->class->query('query');
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryReturnsQueryResultWhenConnected(): void
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $mysqli->expects($this->once())
               ->method('query')
               ->will($this->returnValue(TRUE));

        $this->mock_function('mysqli_affected_rows', fn() => 0);
        $this->mock_function('microtime', function () {return 1; });

        $this->logger->expects($this->exactly(2))
                     ->method('debug')
                     ->withConsecutive([ 'query: {query}', [ 'query' => 'query' ] ], [ 'Query executed in 0 seconds' ]);

        $query = $this->class->query('query');

        $this->unmock_function('mysqli_affected_rows');
        $this->unmock_function('microtime');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLQueryResult', $query);
        $this->assertFalse($query->has_failed());
    }

    /**
     * Test that query() prepends the SQL query with a query hint if one is set.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryPrependsQueryHintIfPresent(): void
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('query_hint', '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $this->mock_function('mysqli_affected_rows', fn() => 0);
        $this->mock_function('microtime', function () {return 1; });

        $this->logger->expects($this->exactly(2))
                     ->method('debug')
                     ->withConsecutive([ 'query: {query}', [ 'query' => '/*hint*/query' ] ], [ 'Query executed in 0 seconds' ]);

        $query = $this->class->query('query');

        $this->unmock_function('mysqli_affected_rows');
        $this->unmock_function('microtime');

        $this->assertEquals('/*hint*/query', $query->query());
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::query
     */
    public function testQueryResetsQueryHint(): void
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $hint = $this->get_accessible_reflection_property('query_hint');
        $hint->setValue($this->class, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'))
               ->will($this->returnValue(TRUE));

        $this->mock_function('mysqli_affected_rows', fn() => 0);
        $this->mock_function('microtime', function () {return 1; });

        $this->logger->expects($this->exactly(2))
                     ->method('debug')
                     ->withConsecutive([ 'query: {query}', [ 'query' => '/*hint*/query' ] ], [ 'Query executed in 0 seconds' ]);

        $this->class->query('query');

        $this->unmock_function('mysqli_affected_rows');
        $this->unmock_function('microtime');

        $this->assertSame('', $hint->getValue($this->class));
    }

    /**
     * Test that async_query() throws an exception when not connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->logger->expects($this->never())
                     ->method('debug');

        $this->class->async_query('query');
    }

    /**
     * Test that async_query() returns a AsyncQueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsQueryResultWhenConnected(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 0);

        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $mysqli->expects($this->once())
               ->method('query');

        $mysqli->expects($this->once())
               ->method('reap_async_query')
               ->will($this->returnValue(TRUE));

        $this->logger->expects($this->once())
                     ->method('debug')
                     ->with('query: {query}', [ 'query' => 'query' ]);

        $query = $this->class->async_query('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult', $query);
        $this->assertFalse($query->has_failed());

        $property->setValue($this->class, FALSE);

        $this->unmock_function('mysqli_affected_rows');
    }

    /**
     * Test that async_query() prepends the SQL query with a query hint if one is set.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryPrependsQueryHintIfPresent(): void
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);
        $this->set_reflection_property_value('query_hint', '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $this->logger->expects($this->once())
                     ->method('debug')
                     ->with('query: {query}', [ 'query' => '/*hint*/query' ]);

        $query = $this->class->async_query('query');

        $this->assertEquals('/*hint*/query', $query->query());
    }

    /**
     * Test that async_query() returns a QueryResult when connected.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::async_query
     */
    public function testAsyncQueryResetsQueryHint(): void
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('connected', TRUE);

        $hint = $this->get_accessible_reflection_property('query_hint');
        $hint->setValue($this->class, '/*hint*/');

        $mysqli->expects($this->once())
               ->method('query')
               ->with($this->equalTo('/*hint*/query'), $this->equalTo(MYSQLI_ASYNC));

        $this->logger->expects($this->once())
                     ->method('debug')
                     ->with('query: {query}', [ 'query' => '/*hint*/query' ]);

        $this->class->async_query('query');

        $this->assertSame('', $hint->getValue($this->class));
    }

}

?>
