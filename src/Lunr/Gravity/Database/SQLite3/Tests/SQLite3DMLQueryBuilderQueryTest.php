<?php

/**
 * This file contains the SQLite3DMLQueryBuilderQueryTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for getting insert/replace queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderQueryTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test get insert query with undefined INTO clause.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_insert_query
     */
    public function testGetInsertQueryWithUndefinedInto(): void
    {
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = '';
        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using column names and values.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_insert_query
     */
    public function testGetInsertValuesQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = 'INSERT INTO table (column1, column2) VALUES (1,2), (3,4)';
        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SELECT.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get insert query using SELECT with ColumnNames.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_insert_query
     */
    public function testGetInsertSelectColumnsQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'INSERT INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->class->get_insert_query());
    }

    /**
     * Test get replace query with undefined INTO clause.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceQueryWithUndefinedInto(): void
    {
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = '';
        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using column names and values.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceValuesQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('values', 'VALUES (1,2), (3,4)');

        $string = 'REPLACE INTO table (column1, column2) VALUES (1,2), (3,4)';
        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SELECT.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->class->get_replace_query());
    }

    /**
     * Test get replace query using SELECT with ColumnNames.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::get_replace_query
     */
    public function testGetReplaceSelectColumnsQuery(): void
    {
        $this->set_reflection_property_value('into', 'INTO table');
        $this->set_reflection_property_value('column_names', '(column1, column2)');
        $this->set_reflection_property_value('select_statement', 'SELECT column1, column2 FROM table');

        $string = 'REPLACE INTO table (column1, column2) SELECT column1, column2 FROM table';
        $this->assertEquals($string, $this->class->get_replace_query());
    }

}

?>
