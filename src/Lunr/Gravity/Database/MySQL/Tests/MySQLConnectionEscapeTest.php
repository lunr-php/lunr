<?php

/**
 * This file contains the MySQLConnectionEscapeTest class.
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
 * This class contains string escape unit tests for MySQLConnection.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionEscapeTest extends MySQLConnectionTest
{

    /**
     * Test that escape_string() returns FALSE when there is no active connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::escape_string
     */
    public function testEscapeStringReturnsFalseWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->escape_string('string'));
    }

    /**
     * Test that escape_string() properly escapes the given string.
     *
     * @param String $string       String to escape
     * @param String $part_escaped Partially escaped string (as returned by mysqli_escape_string)
     * @param String $escaped      Expected escaped string
     *
     * @dataProvider escapeStringProvider
     * @requires     extension mysqli
     * @covers       Lunr\Gravity\Database\MySQL\MySQLConnection::escape_string
     */
    public function testEscapeString($string, $part_escaped, $escaped)
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('escape_string')
                     ->will($this->returnValue($part_escaped));

        $value = $this->db->escape_string($string);

        $this->assertEquals($escaped, $value);

        $property->setValue($this->db, FALSE);
    }

}

?>
