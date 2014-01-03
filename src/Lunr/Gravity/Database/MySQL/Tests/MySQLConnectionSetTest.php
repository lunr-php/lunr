<?php

/**
 * This file contains the MySQLConnectionSetTest class.
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
 * This class contains test for the setters of the MySQLConnection class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionSetTest extends MySQLConnectionTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->emptySetUp();
    }

    /**
     * Test that set_configuration sets rw_host correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsRWHostCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('rw_host');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('rw_host', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets username correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsUsernameCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('user');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('username', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets password correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPasswordCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('pwd');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('password', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets database correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsDatabaseCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('db');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('database', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets ro_host to rw_host if it is not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostToRWHostIfItIsNotSet()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('ro_host');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('rw_host', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets ro_host to rw_host if it is empty.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostToRWHostIfItIsEmpty()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('ro_host', ''),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('ro_host');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('rw_host', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets ro_host correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('ro_host', 'ro_host'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->sub_configuration->expects($this->any())
                      ->method('offsetExists')
                      ->will($this->returnValue(TRUE));

        $property = $this->db_reflection->getProperty('ro_host');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('ro_host', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets port to ini-value if not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPortToIniValueIfNotSet()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('port');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals(ini_get('mysqli.default_port'), $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets port correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPortCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('port', 'port'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('port');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('port', $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets socket to ini-value if not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSocketToIniValueIfNotSet()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('socket');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals(ini_get('mysqli.default_socket'), $property->getValue($this->db));
    }

    /**
     * Test that set_configuration sets socket correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSocketCorrectly()
    {
        $map = array(
            array('rw_host', 'rw_host'),
            array('username', 'username'),
            array('password', 'password'),
            array('database', 'database'),
            array('socket', 'socket'),
            array('driver', 'mysql')
        );

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->db_reflection->getProperty('socket');
        $property->setAccessible(TRUE);

        $property->setValue($this->db, '');

        $method = $this->db_reflection->getMethod('set_configuration');
        $method->setAccessible(TRUE);

        $method->invoke($this->db);

        $this->assertEquals('socket', $property->getValue($this->db));
    }

}

?>
