<?php

/**
 * This file contains the MySQLConnectionEscapeTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;

/**
 * This class contains string escape unit tests for MySQLConnection.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionEscapeTest extends MySQLConnectionTest
{

    /**
     * Test that escape_string() throws an exception when there is no active connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::escape_string
     */
    public function testEscapeStringThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->class->escape_string('string');
    }

    /**
     * Test that escape_string() properly escapes the given string.
     *
     * @param string $string       String to escape
     * @param string $part_escaped Partially escaped string (as returned by mysqli_escape_string)
     * @param string $escaped      Expected escaped string
     *
     * @dataProvider escapeStringProvider
     * @requires     extension mysqli
     * @covers       Lunr\Gravity\Database\MySQL\MySQLConnection::escape_string
     */
    public function testEscapeString($string, $part_escaped, $escaped): void
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('escape_string')
                     ->will($this->returnValue($part_escaped));

        $value = $this->class->escape_string($string);

        $this->assertEquals($escaped, $value);

        $property->setValue($this->class, FALSE);
    }

}

?>
