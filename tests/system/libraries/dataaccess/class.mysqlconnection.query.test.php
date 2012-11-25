<?php

/**
 * This file contains the MySQLConnectionQueryTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains query related unit tests for MySQLConnection.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLConnection
 */
class MySQLConnectionQueryTest extends MySQLConnectionTest
{

    /**
     * Test that query() returns a QueryResult that indicates a failed query when not connected.
     *
     * @covers  Lunr\Libraries\DataAccess\MySQLConnection::query
     */
    public function testQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection();

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $query = $this->db->query('query');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLQueryResult', $query);
        $this->assertTrue($query->has_failed());
    }

    /**
     * Test that query() returns a QueryResult when connected.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLConnection::query
     */
    public function testQueryReturnsQueryResultWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('query')
                     ->will($this->returnValue(TRUE));

        $query = $this->db->query('query');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLQueryResult', $query);
        $this->assertFalse($query->has_failed());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test that async_query() returns an AsyncQueryResult that indicates a failed query when not connected.
     *
     * @covers  Lunr\Libraries\DataAccess\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsFailedQueryResultWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection();

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $query = $this->db->async_query('query');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLQueryResult', $query);
        $this->assertTrue($query->has_failed());
    }

    /**
     * Test that async_query() returns a AsyncQueryResult when connected.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLConnection::async_query
     */
    public function testAsyncQueryReturnsQueryResultWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('query');

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $query = $this->db->async_query('query');

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLAsyncQueryResult', $query);
        $this->assertFalse($query->has_failed());

        $property->setValue($this->db, FALSE);
    }

}

?>
