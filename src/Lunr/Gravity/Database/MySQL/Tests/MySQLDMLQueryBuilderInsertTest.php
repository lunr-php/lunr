<?php

/**
 * This file contains the MySQLDMLQueryBuilderInsertTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * insert/replace queries.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderInsertTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test fluid interface of the select_statement method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_statement
     */
    public function testSelectStatementReturnsSelfReference()
    {
        $return = $this->builder->select_statement('SELECT * FROM table');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the into method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::into
     */
    public function testIntoReturnsSelfReference()
    {
        $return = $this->builder->into('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the column_names method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::column_names
     */
    public function testColumnNamesReturnsSelfReference()
    {
        $return = $this->builder->column_names(array('column1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the set method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::set
     */
    public function testSetReturnsSelfReference()
    {
        $return = $this->builder->set(array('column1' => 'value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the values method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::values
     */
    public function testValuesReturnsSelfReference()
    {
        $return = $this->builder->values(array('value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the insert_mode method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeReturnsSelfReference()
    {
        $return = $this->builder->insert_mode('LOW_PRIORITY');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the replace_mode method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::replace_mode
     */
    public function testReplaceModeReturnsSelfReference()
    {
        $return = $this->builder->replace_mode('LOW_PRIORITY');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test that standard insert modes are handled correctly.
     *
     * @param String $mode valid insert mode.
     *
     * @dataProvider insertModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown insert modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test insert modes get uppercased properly.
     *
     * @param String $value    Insert mode to set
     * @param String $expected Expected built query part
     *
     * @dataProvider expectedInsertModesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeCase($value, $expected)
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }

}

?>
