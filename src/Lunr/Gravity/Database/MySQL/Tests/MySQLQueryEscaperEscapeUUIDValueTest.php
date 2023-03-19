<?php

/**
 * This file contains the MySQLQueryEscaperEscapeUUIDValueTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryEscaper;

/**
 * This class contains the tests for escaping values in queries.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryEscaper
 */
class MySQLQueryEscaperEscapeUUIDValueTest extends MySQLQueryEscaperTest
{

    /**
     * Test escaping a uuid value.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLQueryEscaper::uuidvalue
     */
    public function testEscapingUUIDValue(): void
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals("UNHEX(REPLACE('value','-',''))", $this->class->uuidvalue('value'));
    }

    /**
     * Test escaping a uuid value with a collation specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLQueryEscaper::uuidvalue
     */
    public function testEscapingUUIDValueWithCollation(): void
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = "UNHEX(REPLACE('value','-','')) COLLATE utf8_general_ci";

        $this->assertEquals($string, $this->class->uuidvalue('value', 'utf8_general_ci'));
    }

    /**
     * Test escaping a uuid value with charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithValueOnly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLQueryEscaper::uuidvalue
     */
    public function testEscapingUUIDValueWithCharset(): void
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals("ascii UNHEX(REPLACE('value','-',''))", $this->class->uuidvalue('value', '', 'ascii'));
    }

    /**
     * Test escaping a uuid value with a collation and charset specified.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseQueryEscaperEscapeTest::testCollateWithCollation
     * @covers  Lunr\Gravity\Database\MySQL\MySQLQueryEscaper::uuidvalue
     */
    public function testEscapingUUIDValueWithCollationAndCharset(): void
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $string = "ascii UNHEX(REPLACE('value','-','')) COLLATE utf8_general_ci";

        $this->assertEquals($string, $this->class->uuidvalue('value', 'utf8_general_ci', 'ascii'));
    }

}

?>
