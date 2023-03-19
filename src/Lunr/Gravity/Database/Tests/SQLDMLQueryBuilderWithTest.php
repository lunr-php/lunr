<?php
/**
 * This file contains the DatabaseDMLQueryBuilderQueryPartsWithTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\SQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * with statements.
 *
 * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderWithTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the WITH part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsWithTest::testNonRecursiveWithWithoutColumnNames
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testWith(): void
    {
        $this->class->with('alias', 'query');
        $value = $this->get_reflection_property_value('with');

        $this->assertEquals('alias AS ( query )', $value);
    }

    /**
     * Test fluid interface of the with method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::with
     */
    public function testWithReturnsSelfReference(): void
    {
        $return = $this->class->with('alias', 'query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the WITH part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsWithTest::testRecursiveWithWithoutColumnNames
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::delete
     */
    public function testWithRecursive(): void
    {
        $this->class->with_recursive('alias', 'anchor_query', 'recursive_query');
        $value = $this->get_reflection_property_value('with');

        $this->assertEquals('alias AS ( anchor_query UNION recursive_query )', $value);
    }

    /**
     * Test fluid interface of the with method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::with
     */
    public function testWithRecursiveReturnsSelfReference(): void
    {
        $return = $this->class->with_recursive('alias', 'anchor_query', 'recursive_query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
