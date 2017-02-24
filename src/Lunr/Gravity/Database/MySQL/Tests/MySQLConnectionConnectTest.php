<?php

/**
 * This file contains the MySQLConnectionConnectTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;
use ReflectionClass;

/**
 * This class contains connection related unit tests for MySQLConnection.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionConnectTest extends MySQLConnectionTest
{

    /**
     * Test a successful readonly connection.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testSuccessfulConnectReadonly()
    {
        $mysqli = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\Tests\MockMySQLi')
                       ->setMethods([ 'connect', 'ssl_set', 'set_charset' ])
                       ->getMock();

        $this->set_reflection_property_value('mysqli', $mysqli);
        $this->set_reflection_property_value('readonly', TRUE);
        $this->set_reflection_property_value('ro_host', 'ro_host');

        $port   = ini_get('mysqli.default_port');
        $socket = ini_get('mysqli.default_socket');

        $mysqli->expects($this->once())
               ->method('connect')
               ->with('ro_host', 'username', 'password', 'database', $port, $socket);

        $mysqli->expects($this->never())
               ->method('ssl_set');

        $mysqli->expects($this->once())
               ->method('set_charset');

        $this->class->connect();

        $property = $this->get_accessible_reflection_property('connected');

        $this->assertTrue($property->getValue($this->class));

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a successful readwrite connection.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testSuccessfulConnectReadwrite()
    {
        $mysqli = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\Tests\MockMySQLi')
                       ->setMethods([ 'connect', 'ssl_set', 'set_charset' ])
                       ->getMock();

        $this->set_reflection_property_value('mysqli', $mysqli);

        $port   = ini_get('mysqli.default_port');
        $socket = ini_get('mysqli.default_socket');

        $mysqli->expects($this->once())
               ->method('connect')
               ->with('rw_host', 'username', 'password', 'database', $port, $socket);

        $mysqli->expects($this->never())
               ->method('ssl_set');

        $mysqli->expects($this->once())
               ->method('set_charset');

        $this->class->connect();

        $property = $this->get_accessible_reflection_property('connected');

        $this->assertTrue($property->getValue($this->class));

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a successful readwrite connection with ssl.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testSuccessfulConnectReadwriteWithSSL()
    {
        $mysqli = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\Tests\MockMySQLi')
                       ->setMethods([ 'connect', 'ssl_set', 'set_charset' ])
                       ->getMock();

        $this->set_reflection_property_value('mysqli', $mysqli);

        $port   = ini_get('mysqli.default_port');
        $socket = ini_get('mysqli.default_socket');

        $this->set_reflection_property_value('ssl_key', 'ssl_key');
        $this->set_reflection_property_value('ssl_cert', 'ssl_cert');
        $this->set_reflection_property_value('ca_cert', 'ca_cert');
        $this->set_reflection_property_value('ca_path', 'ca_path');
        $this->set_reflection_property_value('cipher', 'cipher');

        $mysqli->expects($this->once())
               ->method('connect')
               ->with('rw_host', 'username', 'password', 'database', $port, $socket);

        $mysqli->expects($this->once())
               ->method('ssl_set')
               ->with('ssl_key', 'ssl_cert', 'ca_cert', 'ca_path', 'cipher');

        $mysqli->expects($this->once())
               ->method('set_charset');

        $this->class->connect();

        $property = $this->get_accessible_reflection_property('connected');

        $this->assertTrue($property->getValue($this->class));

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a failed connection attempt.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testFailedConnect()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $mysqli->expects($this->never())
               ->method('ssl_set');

        $this->class->connect();

        $property = $this->reflection->getProperty('connected');
        $property->setAccessible(TRUE);

        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that connect() does not reconnect when we are already connected.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testConnectDoesNotReconnectWhenAlreadyConnected()
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->never())
                     ->method('connect');

        $this->mysqli->expects($this->never())
                     ->method('ssl_set');

        $this->class->connect();

        $property = $this->get_accessible_reflection_property('connected');

        $this->assertTrue($property->getValue($this->class));

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test that connect() fails when the driver specified is not mysql.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::connect
     */
    public function testConnectFailsWhenDriverIsNotMysql()
    {
        $sub_configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $configuration = $this->getMockBuilder('Lunr\Core\Configuration')->getMock();

        $map = [[ 'db', $sub_configuration ]];

        $configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'not_mysql' ],
        ];

        $sub_configuration->expects($this->any())
                          ->method('offsetGet')
                          ->will($this->returnValueMap($map));

        $this->mysqli->expects($this->never())
                     ->method('ssl_set');

        $this->set_reflection_property_value('configuration', $configuration);

        $this->logger->expects($this->once())
                     ->method('error');

        $this->class->connect();
    }

    /**
     * Test that disconnect() does not try to disconnect when we are not connected yet.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::disconnect
     */
    public function testDisconnectDoesNotTryToDisconnectWhenNotConnected()
    {
        $this->mysqli->expects($this->never())
                     ->method('kill');
        $this->mysqli->expects($this->never())
                     ->method('close');

        $this->class->disconnect();

        $this->assertFalse($this->get_reflection_property_value('connected'));
    }

    /**
     * Test that disconnect() works correctly.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::disconnect
     */
    public function testDisconnect()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->class->connect();

        $property = $this->get_accessible_reflection_property('connected');

        $this->assertTrue($property->getValue($this->class));

        $this->class->disconnect();

        $this->assertFalse($property->getValue($this->class));
    }

    /**
     * Test that change_database() returns FALSE when we couldn't connect.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::change_database
     */
    public function testChangeDatabaseReturnsFalseWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->change_database('new_db'));
    }

    /**
     * Test that change_database() returns FALSE when select_db() fails.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::change_database
     */
    public function testChangeDatabaseReturnsFalseWhenSelectDBFailed()
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('select_db')
                     ->will($this->returnValue(FALSE));

        $this->assertFalse($this->class->change_database('new_db'));

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test that change_database() returns TRUE when select_db() works.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::change_database
     */
    public function testChangeDatabaseReturnsTrueWhenSelectDBWorked()
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('select_db')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->change_database('new_db'));

        $property->setValue($this->class, FALSE);
    }

}

?>
