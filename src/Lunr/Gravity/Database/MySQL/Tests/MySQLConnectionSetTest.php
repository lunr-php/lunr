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
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('rw_host');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertPropertyEquals('rw_host', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets username correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsUsernameCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('user');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('username', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets password correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPasswordCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('pwd');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('password', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets database correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsDatabaseCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('db');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('database', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ro_host to rw_host if it is not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostToRWHostIfItIsNotSet()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('ro_host');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('rw_host', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ro_host to rw_host if it is empty.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostToRWHostIfItIsEmpty()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'ro_host', '' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('ro_host');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('rw_host', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ro_host correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsROHostCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'ro_host', 'ro_host' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $this->sub_configuration->expects($this->any())
                      ->method('offsetExists')
                      ->will($this->returnValue(TRUE));

        $property = $this->get_accessible_reflection_property('ro_host');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('ro_host', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets port to ini-value if not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPortToIniValueIfNotSet()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('port');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals(ini_get('mysqli.default_port'), $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets port correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsPortCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'port', 'port' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('port');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('port', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets socket to ini-value if not set.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSocketToIniValueIfNotSet()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('socket');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals(ini_get('mysqli.default_socket'), $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets socket correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSocketCorrectly()
    {
        $map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'socket', 'socket' ],
            [ 'driver', 'mysql' ]
        ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($map));

        $property = $this->get_accessible_reflection_property('socket');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('socket', $property->getValue($this->class));
    }

}

?>
