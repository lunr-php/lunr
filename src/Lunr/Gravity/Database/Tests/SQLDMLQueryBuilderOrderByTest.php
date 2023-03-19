<?php

/**
 * This file contains the SQLDMLQueryBuilderOrderByTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * order by statements.
 *
 * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderOrderByTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the order by part of a query.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithDefaultOrder(): void
    {
        $this->class->order_by('col');
        $value = $this->get_reflection_property_value('order_by');

        $this->assertEquals('ORDER BY col ASC', $value);
    }

    /**
     * Test specifying the order by part of a query.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByWithCustomOrder(): void
    {
        $this->class->order_by('col', FALSE);
        $value = $this->get_reflection_property_value('order_by');

        $this->assertEquals('ORDER BY col DESC', $value);
    }

    /**
     * Test fluid interface of the order_by method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::order_by
     */
    public function testOrderByReturnsSelfReference(): void
    {
        $return = $this->class->order_by( 'col' );

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
