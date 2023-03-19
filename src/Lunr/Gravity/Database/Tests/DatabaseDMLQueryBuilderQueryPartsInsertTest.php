<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsInsertTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building INSERT and REPLACE statements
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsInsertTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the SET part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testInitialSet(): void
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [ [ 'column1' => 'value1' ] ]);

        $string = 'SET column1 = value1';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test specifying the SET part of a query incrementally.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testIncrementalSet(): void
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [ [ 'column1' => 'value1' ] ]);
        $method->invokeArgs($this->class, [ [ 'column2' => 'value2' ] ]);

        $string = 'SET column1 = value1, column2 = value2';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test the sql_set() function when a value is NULL.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_set
     */
    public function testSetWithNullValue(): void
    {
        $method = $this->get_accessible_reflection_method('sql_set');

        $method->invokeArgs($this->class, [ [ 'column1' => 'value1' ] ]);
        $method->invokeArgs($this->class, [ [ 'column2' => NULL ] ]);

        $string = 'SET column1 = value1, column2 = NULL';

        $this->assertPropertyEquals('set', $string);
    }

    /**
     * Test specifying empty Values for a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testUndefinedValuesQueryPart(): void
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ [] ]);

        $string = '';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the Values part of a query.
     *
     * @param array $values Array of insert values
     *
     * @dataProvider insertValuesProvider
     * @covers       Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testInitialValuesQueryPart($values): void
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ $values ]);

        $string = 'VALUES (value1, value2, value3)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the Values part of a query incrementally.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testIncrementalValues(): void
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ [ 'value1', 'value2', 'value3' ] ]);

        $values   = [];
        $values[] = [ 'value4', 'value5', 'value6' ];
        $values[] = [ 'value7', 'value8', 'value9' ];

        $method->invokeArgs($this->class, [ $values ]);

        $string = 'VALUES (value1, value2, value3), (value4, value5, value6), (value7, value8, value9)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying NULL values in the Values part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_values
     */
    public function testNullValues(): void
    {
        $method = $this->get_accessible_reflection_method('sql_values');

        $method->invokeArgs($this->class, [ [ 'value1', NULL, 'value3' ] ]);

        $string = 'VALUES (value1, NULL, value3)';

        $this->assertPropertyEquals('values', $string);
    }

    /**
     * Test specifying the column_names part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_column_names
     */
    public function testInitialColumnNames(): void
    {
        $method = $this->get_accessible_reflection_method('sql_column_names');

        $method->invokeArgs($this->class, [ [ 'column1', 'column2', 'column3' ] ]);

        $string = '(column1, column2, column3)';

        $this->assertPropertyEquals('column_names', $string);
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInitialSelectStatement(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select_statement');

        $method->invokeArgs($this->class, [ 'SELECT * FROM table1' ]);

        $string = 'SELECT * FROM table1';

        $this->assertPropertyEquals('select_statement', $string);
    }

    /**
     * Test specifying the select_statement part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select_statement
     */
    public function testInvalidSelectStatement(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select_statement');

        $method->invokeArgs($this->class, [ 'INSERT INTO table1' ]);

        $string = '';

        $this->assertPropertyEquals('select_statement', $string);
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_into
     */
    public function testInitialInto(): void
    {
        $method = $this->get_accessible_reflection_method('sql_into');

        $method->invokeArgs($this->class, [ 'table1' ]);

        $string = 'INTO table1';

        $this->assertPropertyEquals('into', $string);
    }

    /**
     * Test specifying the INTO part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_into
     */
    public function testIncrementalInto(): void
    {
        $method = $this->get_accessible_reflection_method('sql_into');

        $method->invokeArgs($this->class, [ 'table1' ]);
        $method->invokeArgs($this->class, [ 'table2' ]);

        $string = 'INTO table2';

        $this->assertPropertyEquals('into', $string);
    }

    /**
     * Test specifying the UPSERT part of a query without target.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_upsert
     */
    public function testUpsertWithoutTarget()
    {
        $method = $this->get_accessible_reflection_method('sql_upsert');

        $method->invokeArgs($this->class, [ 'ON CONFLICT', 'DO NOTHING' ]);

        $string = 'ON CONFLICT DO NOTHING';

        $this->assertPropertyEquals('upsert', $string);
    }

    /**
     * Test specifying the UPSERT part of a query without target.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_upsert
     */
    public function testUpsertWithTarget()
    {
        $method = $this->get_accessible_reflection_method('sql_upsert');

        $method->invokeArgs($this->class, [ 'ON CONFLICT', 'DO NOTHING', '(column)' ]);

        $string = 'ON CONFLICT (column) DO NOTHING';

        $this->assertPropertyEquals('upsert', $string);
    }

}

?>
