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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the setup and the final query creation.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseDMLQueryBuilder
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
     * Test that update is an empty string by default.
     */
    public function testUpdateEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('update');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that update_mode is an empty array by default.
     */
    public function testUpdateModeEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('update_mode');
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
     * Test that insert_mode is an empty array by default.
     */
    public function testInsertModeEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that into is an empty string by default.
     */
    public function testIntoEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('into');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that set is an empty string by default.
     */
    public function testSetEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('set');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that column_names is an empty string by default.
     */
    public function testColumnNamesEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('column_names');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that values is an empty string by default.
     */
    public function testValuesEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('values');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
    }

    /**
     * Test that select_statement is an empty string by default.
     */
    public function testSelectStatementEmptyByDefault()
    {
        $property = $this->builder_reflection->getProperty('select_statement');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->builder));
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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
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
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithExistingEmptyComponents()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $components = array(
            'select_mode',
            'select',
            'from'
        );

        $this->assertEquals('', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with existing but empty select components specified.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithEmptySelectComponent()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $components = array(
            'select',
            'from'
        );

        $this->assertEquals('* FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte select_mode values.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
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
        $select_mode->setValue($this->builder, array(
            'DISTINCT',
            'DISTINCT',
            'SQL_CACHE'
        ));

        $components = array(
            'select_mode',
            'select',
            'from'
        );

        $this->assertEquals('DISTINCT SQL_CACHE * FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte update_mode values.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateUpdateModes()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('update');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'table1');

        $mode = $this->builder_reflection->getProperty('update_mode');
        $mode->setAccessible(TRUE);
        $mode->setValue($this->builder, array(
            'LOW_PRIORITY',
            'IGNORE',
            'LOW_PRIORITY'
        ));

        $components = array(
            'update_mode',
            'update'
        );

        $this->assertEquals('LOW_PRIORITY IGNORE table1', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte delete_mode values.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
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
        $select_mode->setValue($this->builder, array(
            'QUICK',
            'IGNORE',
            'QUICK'
        ));

        $components = array(
            'delete_mode',
            'from'
        );

        $this->assertEquals('QUICK IGNORE FROM table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test imploding a query with dupliacte insert_mode values.
     *
     * @covers Lunr\DataAccess\DatabaseDMLQueryBuilder::implode_query
     */
    public function testImplodeQueryWithDuplicateInsertModes()
    {
        $method = $this->builder_reflection->getMethod('implode_query');
        $method->setAccessible(TRUE);

        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $select_mode = $this->builder_reflection->getProperty('insert_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'DELAYED',
            'IGNORE',
            'DELAYED'
        ));

        $components = array(
            'insert_mode',
            'into'
        );

        $this->assertEquals('DELAYED IGNORE INTO table', $method->invokeArgs($this->builder, array($components)));
    }

    /**
     * Test getting a select query.
     *
     * @depends testImplodeQueryWithEmptySelectComponent
     * @depends testImplodeQueryWithDuplicateSelectModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_select_query
     */
    public function testGetSelectQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('select_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'DISTINCT',
            'SQL_CACHE'
        ));

        $select = $this->builder_reflection->getProperty('select');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'col');

        $string = 'SELECT DISTINCT SQL_CACHE col FROM table';
        $this->assertEquals($string, $this->builder->get_select_query());
    }

    /**
     * Test getting an update query without specifying a table.
     *
     * @depends testImplodeQueryWithDuplicateUpdateModes
     * @depends testUpdateEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryWithNoTable()
    {
        $update_mode = $this->builder_reflection->getProperty('update_mode');
        $update_mode->setAccessible(TRUE);
        $update_mode->setValue($this->builder, array(
            'LOW_PRIORITY',
            'IGNORE'
        ));

        $set = $this->builder_reflection->getProperty('set');
        $set->setAccessible(TRUE);
        $set->setValue($this->builder, 'SET col1 = val1, col2 = val2');

        $where = $this->builder_reflection->getProperty('where');
        $where->setAccessible(TRUE);
        $where->setValue($this->builder, 'WHERE 1 = 1');

        $order = $this->builder_reflection->getProperty('order_by');
        $order->setAccessible(TRUE);
        $order->setValue($this->builder, 'ORDER BY col1');

        $limit = $this->builder_reflection->getProperty('limit');
        $limit->setAccessible(TRUE);
        $limit->setValue($this->builder, 'LIMIT 10');

        $string = '';
        $this->assertEquals($string, $this->builder->get_update_query());
    }

    /**
     * Test getting an update query for single table.
     *
     * @depends testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForSingleTable()
    {
        $update = $this->builder_reflection->getProperty('update');
        $update->setAccessible(TRUE);
        $update->setValue($this->builder, 'table1');

        $update_mode = $this->builder_reflection->getProperty('update_mode');
        $update_mode->setAccessible(TRUE);
        $update_mode->setValue($this->builder, array(
            'LOW_PRIORITY',
            'IGNORE'
        ));

        $set = $this->builder_reflection->getProperty('set');
        $set->setAccessible(TRUE);
        $set->setValue($this->builder, 'SET col1 = val1, col2 = val2');

        $where = $this->builder_reflection->getProperty('where');
        $where->setAccessible(TRUE);
        $where->setValue($this->builder, 'WHERE 1 = 1');

        $order = $this->builder_reflection->getProperty('order_by');
        $order->setAccessible(TRUE);
        $order->setValue($this->builder, 'ORDER BY col1');

        $limit = $this->builder_reflection->getProperty('limit');
        $limit->setAccessible(TRUE);
        $limit->setValue($this->builder, 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1 SET col1 = val1, col2 = val2 WHERE 1 = 1 ORDER BY col1 LIMIT 10';
        $this->assertEquals($string, $this->builder->get_update_query());
    }

    /**
     * Test getting an update query for multiple tables.
     *
     * @depends testImplodeQueryWithDuplicateUpdateModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_update_query
     */
    public function testGetUpdateQueryForMultipleTables()
    {
        $update = $this->builder_reflection->getProperty('update');
        $update->setAccessible(TRUE);
        $update->setValue($this->builder, 'table1, table2');

        $update_mode = $this->builder_reflection->getProperty('update_mode');
        $update_mode->setAccessible(TRUE);
        $update_mode->setValue($this->builder, array(
            'LOW_PRIORITY',
            'IGNORE'
        ));

        $set = $this->builder_reflection->getProperty('set');
        $set->setAccessible(TRUE);
        $set->setValue($this->builder, 'SET col1 = val1, col2 = val2');

        $where = $this->builder_reflection->getProperty('where');
        $where->setAccessible(TRUE);
        $where->setValue($this->builder, 'WHERE 1 = 1');

        $order = $this->builder_reflection->getProperty('order_by');
        $order->setAccessible(TRUE);
        $order->setValue($this->builder, 'ORDER BY col1');

        $limit = $this->builder_reflection->getProperty('limit');
        $limit->setAccessible(TRUE);
        $limit->setValue($this->builder, 'LIMIT 10');

        $string = 'UPDATE LOW_PRIORITY IGNORE table1, table2 SET col1 = val1, col2 = val2 WHERE 1 = 1';
        $this->assertEquals($string, $this->builder->get_update_query());
    }

    /**
     * Test getting a delete query.
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'QUICK',
            'IGNORE'
        ));

        $select = $this->builder_reflection->getProperty('delete');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'table.*');

        $string = 'DELETE QUICK IGNORE table.* FROM table';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a delete query with undefined FROM.
     *
     * @depends testFromEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetDeleteQueryWithUndefinedFrom()
    {
        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'QUICK',
            'IGNORE'
        ));

        $select = $this->builder_reflection->getProperty('delete');
        $select->setAccessible(TRUE);
        $select->setValue($this->builder, 'table.*');

        $string = '';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a delete query with empty selection.
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
     */
    public function testGetEmptyDeleteQuery()
    {
        $from = $this->builder_reflection->getProperty('from');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'FROM table');

        $select_mode = $this->builder_reflection->getProperty('delete_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'QUICK',
            'IGNORE'
        ));

        $string = 'DELETE QUICK IGNORE FROM table';
        $this->assertEquals($string, $this->builder->get_delete_query());
    }

    /**
     * Test getting a delete query with limit and orderBy.
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
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
     * Test it is not possible to get a delete query with limit and orderBy when delete is not ''.
     *
     * @depends testImplodeQueryWithDuplicateDeleteModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_delete_query
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
     * Test get insert query with undefined INTO clause.
     *
     * @depends testIntoEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertQueryWithUndefinedInto()
    {

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('values');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'VALUES (1,2), (3,4)');

        $string = '';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get insert query using column names and values.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertValuesQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('values');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'VALUES (1,2), (3,4)');

        $string = 'INSERT INTO table (column1, column2) VALUES (1,2), (3,4)';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get insert query using SET.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSetQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('set');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SET column1 = 1');

        $string = 'INSERT INTO table SET column1 = 1';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get insert query using SELECT.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get insert query using SELECT with ColumnNames.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectColumnsQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get replace query with undefined INTO clause.
     *
     * @depends testIntoEmptyByDefault
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceQueryWithUndefinedInto()
    {
        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('values');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'VALUES (1,2), (3,4)');

        $string = '';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

    /**
     * Test get replace query using column names and values.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceValuesQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('values');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'VALUES (1,2), (3,4)');

        $string = 'REPLACE INTO table (column1, column2) VALUES (1,2), (3,4)';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

    /**
     * Test get replace query using SET.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSetQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('set');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SET column1 = 1');

        $string = 'REPLACE INTO table SET column1 = 1';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

    /**
     * Test get replace query using SELECT.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

    /**
     * Test get replace query using SELECT with ColumnNames.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectColumnsQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

    /**
     * Test getting a select query with undefined from clause.
     *
     * @depends testImplodeQueryWithEmptySelectComponent
     * @depends testImplodeQueryWithDuplicateSelectModes
     * @covers  Lunr\DataAccess\DatabaseDMLQueryBuilder::get_select_query
     */
    public function testGetSelectQueryWithUndefinedFromClause()
    {
        $select_mode = $this->builder_reflection->getProperty('select_mode');
        $select_mode->setAccessible(TRUE);
        $select_mode->setValue($this->builder, array(
            'DISTINCT',
            'SQL_CACHE'
        ));

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

    /**
     * Test get insert query using SELECT with an invalid insert mode.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectInvalidInsertModeQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $from = $this->builder_reflection->getProperty('insert_mode');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, array(
            'DELAYED',
            'IGNORE'
        ));

        $string = 'INSERT IGNORE INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_insert_query());
    }

    /**
     * Test get replace query using SELECT with an invalid replace mode.
     *
     * @depends testImplodeQueryWithDuplicateInsertModes
     * @covers  Lunr\DataAccess\MySQLDMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectInvalidInsertModeQuery()
    {
        $from = $this->builder_reflection->getProperty('into');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'INTO table');

        $from = $this->builder_reflection->getProperty('column_names');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, '(column1, column2)');

        $from = $this->builder_reflection->getProperty('select_statement');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, 'SELECT column1, column2 FROM table');

        $from = $this->builder_reflection->getProperty('insert_mode');
        $from->setAccessible(TRUE);
        $from->setValue($this->builder, array(
            'DELAYED',
            'IGNORE'
        ));

        $string = 'REPLACE DELAYED INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->builder->get_replace_query());
    }

}
?>
