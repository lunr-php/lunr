<?php

/**
 * This file contains the MySQLConnectionBaseTest class.
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
 * This class contains basic tests for the MySQLConnection class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLConnection
 */
class MySQLConnectionBaseTest extends MySQLConnectionTest
{

    /**
     * Test that the mysqli class was passed correctly.
     */
    public function testMysqliPassed()
    {
        $property = $this->db_reflection->getProperty('mysqli');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->db);

        $this->assertInstanceOf('\mysqli', $value);
    }

    /**
     * Test that rw_host is set correctly.
     */
    public function testRWHostIsSetCorrectly()
    {
        $property = $this->db_reflection->getProperty('rw_host');
        $property->setAccessible(TRUE);

        $this->assertEquals('rw_host', $property->getValue($this->db));
    }

    /**
     * Test that ro_host is set to rw_host.
     */
    public function testROHostIsSetToRWHost()
    {
        $property = $this->db_reflection->getProperty('ro_host');
        $property->setAccessible(TRUE);

        $this->assertEquals('rw_host', $property->getValue($this->db));
    }

    /**
     * Test that username is set correctly.
     */
    public function testUsernameIsSetCorrectly()
    {
        $property = $this->db_reflection->getProperty('user');
        $property->setAccessible(TRUE);

        $this->assertEquals('username', $property->getValue($this->db));
    }

    /**
     * Test that password is set correctly.
     */
    public function testPasswordIsSetCorrectly()
    {
        $property = $this->db_reflection->getProperty('pwd');
        $property->setAccessible(TRUE);

        $this->assertEquals('password', $property->getValue($this->db));
    }

    /**
     * Test that database is set correctly.
     */
    public function testDatabaseIsSetCorrectly()
    {
        $property = $this->db_reflection->getProperty('db');
        $property->setAccessible(TRUE);

        $this->assertEquals('database', $property->getValue($this->db));
    }

    /**
     * Test that the value for port is taken from the php ini.
     */
    public function testPortMatchesValueInPHPIni()
    {
        $property = $this->db_reflection->getProperty('port');
        $property->setAccessible(TRUE);

        $this->assertEquals(ini_get('mysqli.default_port'), $property->getValue($this->db));
    }

    /**
     * Test that the value for socket is taken from the php ini.
     */
    public function testSocketMatchesValueInPHPIni()
    {
        $property = $this->db_reflection->getProperty('socket');
        $property->setAccessible(TRUE);

        $this->assertEquals(ini_get('mysqli.default_socket'), $property->getValue($this->db));
    }

    /**
     * Test that get_new_dml_query_builder_object() returns a new object.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLConnection::get_new_dml_query_builder_object
     */
    public function testGetNewDMLQueryBuilderObjectReturnsObject()
    {
        $value = $this->db->get_new_dml_query_builder_object();

        $this->assertInstanceOf('Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder', $value);
        $this->assertInstanceOf('Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder', $value);
    }

}

?>
