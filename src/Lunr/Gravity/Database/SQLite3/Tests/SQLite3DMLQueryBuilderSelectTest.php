<?php

/**
 * This file contains the SQLite3DMLQueryBuilderSelectTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * select queries.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderSelectTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testInitialSelect
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testIncrementalSelect
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select
     */
    public function testSelectReturnsSelfReference()
    {
        $return = $this->class->select('col');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the FROM part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::from
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
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::from
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::from
     */
    public function testFromReturnsSelfReference()
    {
        $return = $this->class->from('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::join
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
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::join
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
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::join
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
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::join
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
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::join
     */
    public function testJoinReturnsSelfReference()
    {
        $return = $this->class->join('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test that select modes for handling duplicate result entries are handled correctly.
     *
     * @param String $mode valid select mode for handling duplicate entries.
     *
     * @dataProvider selectModesDuplicatesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsDuplicatesCorrectly($mode)
    {
        $this->class->select_mode($mode);
        $modes = $this->get_reflection_property_value('select_mode');

        $this->assertEquals($mode, $modes['duplicates']);
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsIgnoresUnknownValues()
    {
        $this->class->select_mode('UNSUPPORTED');

        $modes = $this->get_reflection_property_value('select_mode');

        $this->assertInternalType('array', $modes);
        $this->assertEmpty($modes);
    }

    /**
     * Test that there can be only one duplicate handling select mode set.
     *
     * @depends testSelectModeSetsDuplicatesCorrectly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeAllowsOnlyOneDuplicateStatement()
    {
        $this->class->select_mode('ALL');
        $this->class->select_mode('DISTINCT');

        $modes = $this->get_reflection_property_value('select_mode');

        $this->assertEquals('DISTINCT', $modes['duplicates']);
        $this->assertNotContains('ALL', $modes);
    }

    /**
     * Test fluid interface of the select_mode method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeReturnsSelfReference()
    {
        $return = $this->class->select_mode('DISTINCT');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the lock_mode method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::lock_mode
     */
    public function testLockModeReturnsSelfReference()
    {
        $return = $this->class->lock_mode('');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the union method.
     *
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::union
     */
    public function testUnionReturnsSelfReference()
    {
        $return = $this->class->union('QUERY');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
