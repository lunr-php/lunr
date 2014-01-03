<?php

/**
 * This file contains the DatabaseDMLQueryBuilderBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderBaseTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test that select is an empty string by default.
     */
    public function testSelectEmptyByDefault()
    {
        $this->assertPropertyEquals('select', '');
    }

    /**
     * Test that select_mode is an empty array by default.
     */
    public function testSelectModeEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('select_mode'));
    }

    /**
     * Test that update is an empty string by default.
     */
    public function testUpdateEmptyByDefault()
    {
        $this->assertPropertyEquals('update', '');
    }

    /**
     * Test that update_mode is an empty array by default.
     */
    public function testUpdateModeEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('update_mode'));
    }

    /**
     * Test that delete is an empty string by default.
     */
    public function testDeleteEmptyByDefault()
    {
        $this->assertPropertyEquals('delete', '');
    }

    /**
     * Test that delete_mode is an empty array by default.
     */
    public function testDeleteModeEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('delete_mode'));
    }

    /**
     * Test that insert_mode is an empty array by default.
     */
    public function testInsertModeEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('insert_mode'));
    }

    /**
     * Test that into is an empty string by default.
     */
    public function testIntoEmptyByDefault()
    {
        $this->assertPropertyEquals('into', '');
    }

    /**
     * Test that set is an empty string by default.
     */
    public function testSetEmptyByDefault()
    {
        $this->assertPropertyEquals('set', '');
    }

    /**
     * Test that column_names is an empty string by default.
     */
    public function testColumnNamesEmptyByDefault()
    {
        $this->assertPropertyEquals('column_names', '');
    }

    /**
     * Test that values is an empty string by default.
     */
    public function testValuesEmptyByDefault()
    {
        $this->assertPropertyEquals('values', '');
    }

    /**
     * Test that select_statement is an empty string by default.
     */
    public function testSelectStatementEmptyByDefault()
    {
        $this->assertPropertyEquals('select_statement', '');
    }

    /**
     * Test that from is an empty string by default.
     */
    public function testFromEmptyByDefault()
    {
        $this->assertPropertyEquals('from', '');
    }

    /**
     * Test that order_by is an empty string by default.
     */
    public function testOrderByEmptyByDefault()
    {
        $this->assertPropertyEquals('order_by', '');
    }

    /**
     * Test that group_by is an empty string by default.
     */
    public function testGroupByEmptyByDefault()
    {
        $this->assertPropertyEquals('group_by', '');
    }

    /**
     * Test that limit is an empty string by default.
     */
    public function testLimitEmptyByDefault()
    {
        $this->assertPropertyEquals('limit', '');
    }

    /**
     * Test that prepare_index_hints prepares valid index hints correctly.
     *
     * @param Array  $hints    Array of index hints
     * @param String $expected Expected escaped string
     *
     * @dataProvider validIndexHintProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::prepare_index_hints
     */
    public function testPrepareValidIndexHints($hints, $expected)
    {
        $method = $this->get_accessible_reflection_method('prepare_index_hints');

        $this->assertEquals($expected, $method->invokeArgs($this->class, [ $hints ]));
    }

    /**
     * Test that prepare_index_hints returns an empty string for invalid input.
     *
     * @param mixed $hints Invalid value
     *
     * @dataProvider invalidIndexHintProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::prepare_index_hints
     */
    public function testPrepareInvalidIndexHintsReturnsEmptyString($hints)
    {
        $method = $this->get_accessible_reflection_method('prepare_index_hints');

        $this->assertEquals('', $method->invokeArgs($this->class, [ $hints ]));
    }

}
?>
