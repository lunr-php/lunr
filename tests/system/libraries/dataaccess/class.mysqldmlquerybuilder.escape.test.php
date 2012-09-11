<?php

/**
 * This file contains the MySQLDMLQueryBuilderEscapeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for escaping values in queries.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderEscapeTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test escaping a simple value.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::value
     */
    public function testEscapingValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value\'', $this->builder->value('value'));
    }

    /**
     * Test escaping a value with a collation specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::value
     */
    public function testEscapingValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value\' COLLATE utf8_general_ci', $this->builder->value('value', 'utf8_general_ci'));
    }

    /**
     * Test escaping a value with charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::value
     */
    public function testEscapingValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'value\'', $this->builder->value('value', '', 'ascii'));
    }

    /**
     * Test escaping a value with a collation and charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::value
     */
    public function testEscapingValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'value\' COLLATE utf8_general_ci', $this->builder->value('value', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a hex value.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('UNHEX(\'value\')', $this->builder->hexvalue('value'));
    }

    /**
     * Test escaping a hex value with a collation specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('UNHEX(\'value\') COLLATE utf8_general_ci', $this->builder->hexvalue('value', 'utf8_general_ci'));
    }

    /**
     * Test escaping a hex value with charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii UNHEX(\'value\')', $this->builder->hexvalue('value', '', 'ascii'));
    }

    /**
     * Test escaping a hex value with a collation and charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::hexvalue
     */
    public function testEscapingHexValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii UNHEX(\'value\') COLLATE utf8_general_ci', $this->builder->hexvalue('value', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a default like value.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValue()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\'', $this->builder->likevalue('value'));
    }

    /**
     * Test escaping a default like value with a collation specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCollation()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value%\' COLLATE utf8_general_ci', $this->builder->likevalue('value', 'both', 'utf8_general_ci'));
    }

    /**
     * Test escaping a default like value with charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'%value%\'', $this->builder->likevalue('value', 'both', '', 'ascii'));
    }

    /**
     * Test escaping a default like value with a collation and charset specified.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithCollation
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueWithCollationAndCharset()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('ascii \'%value%\' COLLATE utf8_general_ci', $this->builder->likevalue('value', 'both', 'utf8_general_ci', 'ascii'));
    }

    /**
     * Test escaping a forward like value.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueForward()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'value%\'', $this->builder->likevalue('value', 'forward'));
    }

    /**
     * Test escaping a backward like value.
     *
     * @depends Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeValuesTest::testCollateWithValueOnly
     * @covers  Lunr\Libraries\DataAccess\MysqlDMLQueryBuilder::likevalue
     */
    public function testEscapingLikeValueBackward()
    {
        $this->db->expects($this->once())
                 ->method('escape_string')
                 ->will($this->returnValue('value'));

        $this->assertEquals('\'%value\'', $this->builder->likevalue('value', 'backward'));
    }

}

?>
