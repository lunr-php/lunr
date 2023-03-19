<?php

/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsDeleteTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This class contains the tests for the query parts methods that are used when building DELETE statements
 *
 * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder
 */
class DatabaseDMLQueryBuilderQueryPartsDeleteTest extends DatabaseDMLQueryBuilderTest
{

    /**
     * Test specifying the delete part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testInitialDelete(): void
    {
        $method = $this->get_accessible_reflection_method('sql_delete');

        $method->invokeArgs($this->class, [ 'table' ]);

        $string = 'table';

        $this->assertPropertyEquals('delete', $string);
    }

    /**
     * Test specifying the select part of a query.
     *
     * @covers Lunr\Gravity\Database\DatabaseDMLQueryBuilder::sql_delete
     */
    public function testIncrementalDelete(): void
    {
        $method = $this->get_accessible_reflection_method('sql_delete');

        $method->invokeArgs($this->class, [ 'table' ]);
        $method->invokeArgs($this->class, [ 'table.*' ]);

        $string = 'table, table.*';

        $this->assertPropertyEquals('delete', $string);
    }

}

?>
