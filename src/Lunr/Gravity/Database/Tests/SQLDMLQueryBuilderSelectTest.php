<?php

/**
 * This file contains the SQLDMLQueryBuilderSelectTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

/**
 * This class contains the tests for the query parts necessary to build
 * select queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLDMLQueryBuilder
 */
class SQLDMLQueryBuilderSelectTest extends SQLDMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testInitialSelect
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testIncrementalSelect
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::select
     */
    public function testSelect()
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
    public function testSelectReturnsSelfReference()
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
    public function testFromWithoutIndexHints()
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
    public function testFromWithIndexHints()
    {
        $hints = array('index_hint');
        $this->class->from('table', $hints);
        $value = $this->get_reflection_property_value('from');

        $this->assertEquals('FROM table index_hint', $value);
    }

    /**
     * Test fluid interface of the from method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::from
     */
    public function testFromReturnsSelfReference()
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
    public function testJoinWithDefaultJoinType()
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
    public function testJoinWithNonDefaultJoinType()
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
    public function testJoinWithoutIndexHints()
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
    public function testJoinWithIndexHints()
    {
        $hints = array('index_hint');
        $this->class->join('table', 'STRAIGHT', $hints);
        $value = $this->get_reflection_property_value('join');

        $this->assertEquals('STRAIGHT_JOIN table index_hint', $value);
    }

    /**
     * Test fluid interface of the join method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::join
     */
    public function testJoinReturnsSelfReference()
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
    public function testUnion()
    {
        $return = $this->class->union('QUERY');

        $this->assertPropertyEquals('compound', 'UNION QUERY');
    }

    /**
     * Test specifying a UNION ALL statement.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testCompoundQuery
     * @covers  Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnionAll()
    {
        $return = $this->class->union('QUERY', TRUE);

        $this->assertPropertyEquals('compound', 'UNION ALL QUERY');
    }

    /**
     * Test fluid interface of the union method.
     *
     * @covers Lunr\Gravity\Database\SQLDMLQueryBuilder::union
     */
    public function testUnionReturnsSelfReference()
    {
        $return = $this->class->union('QUERY');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLDMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
