<?php

/**
 * This file contains the DatabaseDMLQueryBuilderBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderBaseTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test that select is an empty string by default.
     */
    public function testSelectEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that select_mode is an empty array by default.
     */
    public function testSelectModeEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that delete is an empty string by default.
     */
    public function testDeleteEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('delete');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that delete_mode is an empty array by default.
     */
    public function testDeleteModeEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that from is an empty string by default.
     */
    public function testFromEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test imploding a query with no components specified.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithNoComponents()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $components = array();

        $this->assertEquals('', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with non existing components specified.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithNonExistingComponent()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $components = array('whatever');

        $this->assertEquals('', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with existing but empty components specified.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithExistingEmptyComponents()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $components = array('select_mode', 'select', 'from');

        $this->assertEquals('', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with existing but empty select components specified.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithEmptySelectComponent()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $components = array('select', 'from');

        $this->assertEquals('* FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte select_mode values.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateSelectModes()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('select_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('DISTINCT', 'DISTINCT', 'SQL_CACHE'));

        $components = array('select_mode', 'select', 'from');

        $this->assertEquals('DISTINCT SQL_CACHE * FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte delete_mode values.
     *
     * @covers Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateDeleteModes()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('QUICK', 'IGNORE', 'QUICK'));

        $components = array('delete_mode', 'from');

        $this->assertEquals('QUICK IGNORE FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test getting a select query.
     *
     * @depends testImplodeQueryWithEmptySelectComponent
     * @depends testImplodeQueryWithDuplicateSelectModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_select_query
     */
    public function testGetSelectQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('select_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('DISTINCT', 'SQL_CACHE'));

        $select = $this->builder_reflection->getProperty('select');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'col');

        $string = 'SELECT DISTINCT SQL_CACHE col FROM table';
        $this->assertEquals($string, $this->builder->get_select_query());
    }

    /**
     * Test getting a delete query.
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('QUICK', 'IGNORE'));

        $select = $this->builder_reflection->getProperty('delete');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'table.*');

        $string = 'DELETE QUICK IGNORE table.* FROM table';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a delete query with empty selection
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetEmptyDeleteQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('QUICK', 'IGNORE'));

        $string = 'DELETE QUICK IGNORE FROM table';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a delete query with limit and orderBy
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetEmptyDeleteLimitOrderQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $from = $this->builder_reflection->getProperty('limit');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'LIMIT 10 OFFSET 0');

        $from = $this->builder_reflection->getProperty('order_by');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'ORDER BY col ASC');

        $string = 'DELETE FROM table ORDER BY col ASC LIMIT 10 OFFSET 0';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test it is not possible to get a delete query with limit and orderBy when delete is not ''
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteLimitOrderQuery()
    {
        $from = $this->builder_reflection->getProperty('delete');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'table.*');

        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $from = $this->builder_reflection->getProperty('limit');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'LIMIT 10 OFFSET 0');

        $from = $this->builder_reflection->getProperty('order_by');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'ORDER BY col ASC');

        $string = 'DELETE table.* FROM table';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a select query with undefined from clause.
     *
     * @depends testImplodeQueryWithEmptySelectComponent
     * @depends testImplodeQueryWithDuplicateSelectModes
     * @covers  Lunr\Libraries\DataAccess\DatabaseDMLQueryBuilder::get_select_query
     */
    public function testGetSelectQueryWithUndefinedFromClause()
    {
        $select_mode = $this->builder_reflection->getProperty('select_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array('DISTINCT', 'SQL_CACHE'));

        $select = $this->builder_reflection->getProperty('select');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'col');

        $this->assertEquals('', $this->builder->get_select_query());
    }

    /**
     * Test that order_by is an empty string by default.
     */
    public function testOrderByEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('order_by');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that group_by is an empty string by default.
     */
    public function testGroupByEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('group_by');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that limit is an empty string by default.
     */
    public function testLimitEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('limit');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

}

?>
