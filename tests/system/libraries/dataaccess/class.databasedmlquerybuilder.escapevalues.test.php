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
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for escaping column names.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderEscapeValuesTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test collate() with a value only.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::collate
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
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::collate
     */
    public function testCollateWithCollation()
    {
        $method = $this->builder_reflection->getMethod('collate');
        $method->setAccessible(TRUE);

        $this->assertEquals('value COLLATE utf8_general_ci', $method->invokeArgs($this->builder, array('value', 'utf8_general_ci')));
    }

    /**
     * Test column() with only a name value.
     *
     * @param String $col     Raw column name
     * @param String $escaped Expected escaped column name
     *
     * @dataProvider columnNameProvider
     * @depends      testCollateWithValueOnly
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::result_column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::result_column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::hex_result_column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::hex_result_column
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::table
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
     * @depends      Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilderEscapeTest::testEscapeColumnName
     * @covers       Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::table
     */
    public function testTableWithAlias($table, $escaped)
    {
        $alias = 'alias';
        $value = $this->builder->table($table, $alias);

        $this->assertEquals($escaped . ' AS `alias`', $value);
    }


}

?>
