<?php

/**
 * This file contains the MySQLConnectionSetTest class.
 *
 * PHP Version 5.4
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
     * Sample configuration values.
     * @var Array
     */
    protected $values_map;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->emptySetUp();

        $this->values_map = [
            [ 'rw_host', 'rw_host' ],
            [ 'username', 'username' ],
            [ 'password', 'password' ],
            [ 'database', 'database' ],
            [ 'driver', 'mysql' ],
            [ 'ssl_key', 'ssl_key' ],
            [ 'ssl_cert', 'ssl_cert' ],
            [ 'ca_cert', 'ca_cert' ],
            [ 'ca_path', 'ca_path' ],
            [ 'cipher', 'cipher' ]
        ];
    }

    /**
     * Test that set_configuration sets rw_host correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsRWHostCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                                ->method('offsetGet')
                                ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->values_map[] = [ 'ro_host', '' ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->values_map[] = [ 'ro_host', 'ro_host' ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->values_map[] = [ 'port', 'port' ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

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
        $this->values_map[] = [ 'socket', 'socket' ];

        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('socket');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('socket', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ssl_key correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSSLKeyCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('ssl_key');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('ssl_key', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ssl_cert correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsSSLCertCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('ssl_cert');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('ssl_cert', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ca_cert correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsCACertCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('ca_cert');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('ca_cert', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets ca_path correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsCAPathCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('ca_path');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('ca_path', $property->getValue($this->class));
    }

    /**
     * Test that set_configuration sets cipher correctly.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::set_configuration
     */
    public function testSetConfigurationSetsCipherCorrectly()
    {
        $this->sub_configuration->expects($this->any())
                      ->method('offsetGet')
                      ->will($this->returnValueMap($this->values_map));

        $property = $this->get_accessible_reflection_property('cipher');
        $property->setValue($this->class, '');

        $method = $this->get_accessible_reflection_method('set_configuration');
        $method->invoke($this->class);

        $this->assertEquals('cipher', $property->getValue($this->class));
    }

}

?>
