<?php

/**
 * This file contains the SQLite3ConnectionConnectTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;
use ReflectionClass;

/**
 * This class contains connection related unit tests for SQLite3Connection.
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionConnectTest extends SQLite3ConnectionTest
{

    /**
     * Test a successful readonly connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::connect
     */
    public function testSuccessfulConnectReadonly()
    {
        $this->set_reflection_property_value('readonly', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('open')
                      ->with('/tmp/test.db', SQLITE3_OPEN_READONLY | SQLITE3_OPEN_CREATE, '');

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(0));

        $this->class->connect();

        $this->assertTrue($this->get_reflection_property_value('connected'));
    }

    /**
     * Test a successful readwrite connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::connect
     */
    public function testSuccessfulConnectReadwrite()
    {
        $this->sqlite3->expects($this->once())
                      ->method('open')
                      ->with('/tmp/test.db', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, '');

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(0));

        $this->class->connect();

        $this->assertTrue($this->get_reflection_property_value('connected'));
    }

    /**
     * Test a failed connection attempt.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::connect
     */
    public function testFailedConnect()
    {
        $this->set_reflection_property_value('readonly', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('open')
                      ->with('/tmp/test.db', SQLITE3_OPEN_READONLY | SQLITE3_OPEN_CREATE, '');

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $this->class->connect();

        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that connect() does not reconnect when we are already connected.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::connect
     */
    public function testConnectDoesNotReconnectWhenAlreadyConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->never())
                      ->method('open');

        $this->class->connect();

        $this->assertTrue($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that connect() fails when the driver specified is not sqlite3.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::connect
     */
    public function testConnectFailsWhenDriverIsNotMysql()
    {
        $sub_configuration = $this->getMock('Lunr\Core\Configuration');

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $map = array(
            array('db', $sub_configuration),
        );

        $configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = array(
            array('file', '/tmp/test.db'),
            array('driver', 'not_sqlite3')
        );

        $sub_configuration->expects($this->any())
                          ->method('offsetGet')
                          ->will($this->returnValueMap($map));

        $this->set_reflection_property_value('configuration', $configuration);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($this->equalTo('Cannot connect to a non-sqlite3 database connection!'));

        $this->class->connect();
    }

    /**
     * Test that disconnect() does not try to disconnect when we are not connected yet.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::disconnect
     */
    public function testDisconnectDoesNotTryToDisconnectWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', FALSE);

        $this->sqlite3->expects($this->never())
                      ->method('close');

        $this->class->disconnect();

        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that disconnect() works correctly.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::disconnect
     */
    public function testDisconnect()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('close');

        $this->class->disconnect();

        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that change_database() returns TRUE when connected.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::change_database
     */
    public function testChangeDatabaseReturnsTrueWhenConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('open')
                      ->with('new_db', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, '');

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(0));

        $return = $this->class->change_database('new_db');

        $this->assertEquals('new_db', $this->get_reflection_property_value('db'));

        $this->assertTrue($return);
    }

    /**
     * Test that change_database() returns FALSE when we couldn't connect.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::change_database
     */
    public function testChangeDatabaseReturnsFalseWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('open')
                      ->with('new_db', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE, '');

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $return = $this->class->change_database('new_db');

        $this->assertEquals('new_db', $this->get_reflection_property_value('db'));

        $this->assertFalse($return);
    }

}

?>
