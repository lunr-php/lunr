<?php

/**
 * This file contains the DatabaseDMLQueryBuilderEscapeValuesTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for escaping column names.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderEscapeValuesTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test collate() with a value only.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::collate
     */
    public function testCollateWithValueOnly()
    {
        $method = $this->builder_reflection->getMethod('collate');
        $method->setAccessible(TRUE);

        $this->assertEquals('value', $method->invokeArgs($this->builder, array('value', '')));
    }

    /**
     * Test collate() with value and collation specified.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::collate
     */
    public function testCollateWithCollation()
    {
        $method = $this->builder_reflection->getMethod('collate');
        $method->setAccessible(TRUE);

        $string = 'value COLLATE utf8_general_ci';

        $this->assertEquals($string, $method->invokeArgs($this->builder, array('value', 'utf8_general_ci')));
    }

    /**
     * Test column() with only a name value.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithValueOnly
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::column
     */
    public function testColumnWithoutCollation($col, $escaped)
    {
        $value = $this->builder->column($col);

        $this->assertEquals($escaped, $value);
    }

    /**
     * Test column() with name and collation value.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithCollation
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::column
     */
    public function testColumnWithCollation($col, $escaped)
    {
        $value = $this->builder->column($col, 'utf8_general_ci');

        $this->assertEquals($escaped . ' COLLATE utf8_general_ci', $value);
    }

    /**
     * Test result_column() without alias.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::result_column
     */
    public function testResultColumnWithoutAlias($col, $escaped)
    {
        $value = $this->builder->result_column($col);

        $this->assertEquals($escaped, $value);
    }

    /**
     * Test result_column() with alias.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::result_column
     */
    public function testResultColumnWithAlias($col, $escaped)
    {
        $alias = 'alias';
        $value = $this->builder->result_column($col, $alias);

        if ($col === '*')
        {
            $this->assertEquals($escaped, $value);
        }
        else
        {
            $this->assertEquals($escaped . ' AS `alias`', $value);
        }
    }

    /**
     * Test hex_result_column() without alias.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::hex_result_column
     */
    public function testHexResultColumnWithoutAlias($col, $escaped)
    {
        $value = $this->builder->hex_result_column($col);

        $this->assertEquals('HEX(' . $escaped . ') AS `' . $col . '`', $value);
    }

    /**
     * Test hex_result_column() with alias.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::hex_result_column
     */
    public function testHexResultColumnWithAlias($col, $escaped)
    {
        $alias = 'alias';
        $value = $this->builder->hex_result_column($col, $alias);

        $this->assertEquals('HEX(' . $escaped . ') AS `' . $alias . '`', $value);
    }

    /**
     * Test table() without alias.
     *
     * @param String $table   Raw table name
     * @param String $escaped Expected escaped table name
     *
     * @dataProvider tableNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::table
     */
    public function testTableWithoutAlias($table, $escaped)
    {
        $value = $this->builder->table($table);

        $this->assertEquals($escaped, $value);
    }

    /**
     * Test table() with alias.
     *
     * @param String $table   Raw table name
     * @param String $escaped Expected escaped table name
     *
     * @dataProvider tableNameProvider
     * @depends      Lunr\DataAccess\Tests\DatabaseDMLQueryBuilderEscapeTest::testEscapeLocationReference
     * @covers       Lunr\DataAccess\DatabaseDMLQueryBuilder::table
     */
    public function testTableWithAlias($table, $escaped)
    {
        $alias = 'alias';
        $value = $this->builder->table($table, $alias);

        $this->assertEquals($escaped . ' AS `alias`', $value);
    }

    /**
     * Test escaping an integer.
     *
     * @param mixed   $value    The input value to be escaped
     * @param Integer $expected The expected escaped integer
     *
     * @dataProvider expectedIntegerProvider
     * @covers       Lunr\DataAccess\MysqlDMLQueryBuilder::intvalue
     */
    public function testEscapeIntValue($value, $expected)
    {
        $this->assertEquals($expected, $this->builder->intvalue($value));
    }

    /**
     * Test escaping an object as integer.
     *
     * @expectedException PHPUnit_Framework_Error_Notice
     * @covers            Lunr\DataAccess\MysqlDMLQueryBuilder::intvalue
     */
    public function testEscapeObjectAsIntValue()
    {
        $this->builder->intvalue($this->builder);
    }

    /**
     * Test escaping illegal value as integer.
     *
     * @param mixed   $value   The input value to be escaped
     * @param integer $illegal The illegal escaped integer
     *
     * @dataProvider illegalIntegerProvider
     * @covers       Lunr\DataAccess\MysqlDMLQueryBuilder::intvalue
     */
    public function testEscapeIllegalAsIntValue($value, $illegal)
    {
        $this->assertEquals($illegal, $this->builder->intvalue($value));
    }

}

?>
