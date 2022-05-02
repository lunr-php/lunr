<?php

/**
 * This file contains the SQLDMLQueryBuilderSelectTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * select queries.
 *
 * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderSelectTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsSelectTest::testInitialSelect
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsSelectTest::testIncrementalSelect
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::select
     */
    public function testSelect(): void
    {
        $this->class->select('col');
        $value = $this->get_reflection_property_value('select');

        $this->assertEquals('col', $value);
    }

    /**
     * Test fluid interface of the select method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::select
     */
    public function testSelectReturnsSelfReference(): void
    {
        $return = $this->class->select('col');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the FROM part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsFromTest::testFromWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::from
     */
    public function testFromWithoutIndexHints(): void
    {
        $this->class->from('table');
        $value = $this->get_reflection_property_value('from');

        $this->assertEquals('FROM table', $value);
    }

    /**
     * Test specifying the FROM part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsFromTest::testFromWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsFromTest::testFromWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::from
     */
    public function testFromWithIndexHints(): void
    {
        $hints = [ 'index_hint' ];
        $this->class->from('table', $hints);
        $value = $this->get_reflection_property_value('from');

        $this->assertEquals('FROM table index_hint', $value);
    }

    /**
     * Test fluid interface of the from method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::from
     */
    public function testFromReturnsSelfReference(): void
    {
        $return = $this->class->from('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsJoinTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinWithDefaultJoinType(): void
    {
        $this->class->join('table');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('INNER JOIN table', $value);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsJoinTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinWithNonDefaultJoinType(): void
    {
        $this->class->join('table', 'STRAIGHT');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('STRAIGHT_JOIN table', $value);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsJoinTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinWithoutIndexHints(): void
    {
        $this->class->join('table', 'STRAIGHT');
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('STRAIGHT_JOIN table', $value);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsJoinTest::testJoinWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsJoinTest::testJoinWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinWithIndexHints(): void
    {
        $hints = [ 'index_hint' ];
        $this->class->join('table', 'STRAIGHT', $hints);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('STRAIGHT_JOIN table index_hint', $value);
    }

    /**
     * Test fluid interface of the join method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinReturnsSelfReference(): void
    {
        $return = $this->class->join('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying a UNION statement.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testCompoundQuery
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnion(): void
    {
        $return = $this->class->union('QUERY');

        $this->assertPropertyEquals('compound', 'UNION QUERY');
    }

    /**
     * Test specifying a UNION DISTINCT statement.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testCompoundQuery
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnionDistinct(): void
    {
        $return = $this->class->union('QUERY', 'DISTINCT');

        $this->assertPropertyEquals('compound', 'UNION DISTINCT QUERY');
    }

    /**
     * Test specifying a UNION ALL statement.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testCompoundQuery
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnionAll(): void
    {
        $return = $this->class->union('QUERY', 'ALL');

        $this->assertPropertyEquals('compound', 'UNION ALL QUERY');
    }

    /**
     * Test fluid interface of the union method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnionReturnsSelfReference(): void
    {
        $return = $this->class->union('QUERY');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
