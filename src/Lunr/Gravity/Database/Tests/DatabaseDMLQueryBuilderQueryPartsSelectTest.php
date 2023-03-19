<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsSelectTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2021 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the sql returning methods.
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsSelectTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the select part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelect(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col' ]);

        $string = 'col';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialSelectWithNull(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ NULL ]);

        $string = 'NULL';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelect(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col' ]);
        $method->invokeArgs($this->class, [ 'col' ]);

        $string = 'col, col';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalSelectNull(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col' ]);
        $method->invokeArgs($this->class, [ NULL ]);

        $string = 'col, NULL';

        $this->assertPropertyEquals('select', $string);
    }

    /**
     * Test specifying the returning part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testInitialReturning(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col1, col2', 'RETURNING' ]);

        $string = 'RETURNING col1, col2';

        $this->assertPropertyEquals('returning', $string);
        $this->assertPropertyEquals('select', '');
    }

    /**
     * Test specifying the returning part of a query.
     *
     * @covers  Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_select
     */
    public function testIncrementalReturning(): void
    {
        $method = $this->get_accessible_reflection_method('sql_select');

        $method->invokeArgs($this->class, [ 'col1', 'RETURNING' ]);
        $method->invokeArgs($this->class, [ 'col2', 'RETURNING' ]);

        $string = 'RETURNING col1, col2';

        $this->assertPropertyEquals('returning', $string);
        $this->assertPropertyEquals('select', '');
    }

}

?>
