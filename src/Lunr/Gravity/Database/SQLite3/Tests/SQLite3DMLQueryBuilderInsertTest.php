<?php

/**
 * This file contains the SQLite3DMLQueryBuilderInsertTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * insert/replace queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderInsertTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test fluid interface of the select_statement method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_statement
     */
    public function testSelectStatementReturnsSelfReference()
    {
        $return = $this->class->select_statement('SELECT * FROM table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the into method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::into
     */
    public function testIntoReturnsSelfReference()
    {
        $return = $this->class->into('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the column_names method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::column_names
     */
    public function testColumnNamesReturnsSelfReference()
    {
        $return = $this->class->column_names(array('column1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the values method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::values
     */
    public function testValuesReturnsSelfReference()
    {
        $return = $this->class->values(array('value1'));

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the insert_mode method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeReturnsSelfReference()
    {
        $return = $this->class->insert_mode('ROLLBACK');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the replace_mode method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::replace_mode
     */
    public function testReplaceModeReturnsSelfReference()
    {
        $return = $this->class->replace_mode('ROLLBACK');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test that standard insert modes are handled correctly.
     *
     * @param String $mode valid insert mode.
     *
     * @dataProvider modesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsStandardCorrectly($mode)
    {
        $this->class->insert_mode($mode);
        $value = $this->get_reflection_property_value('insert_mode');

        $this->assertContains($mode, $value);
    }

    /**
     * Test that unknown insert modes are ignored.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsIgnoresUnknownValues()
    {
        $this->class->insert_mode('UNSUPPORTED');
        $value = $this->get_reflection_property_value('insert_mode');

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test insert modes get uppercased properly.
     *
     * @param String $value    Insert mode to set
     * @param String $expected Expected built query part
     *
     * @dataProvider expectedModesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeCase($value, $expected)
    {
        $this->class->insert_mode($value);
        $modes = $this->get_reflection_property_value('insert_mode');

        $this->assertContains($expected, $modes);
    }

}
