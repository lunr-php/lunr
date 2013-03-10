<?php

/**
 * This file contains the MySQLDMLQueryBuilderSelectTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * select queries.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderSelectTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test specifying the SELECT part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testInitialSelect
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testIncrementalSelect
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select
     */
    public function testSelect()
    {
        $property = $this->builder_reflection->getProperty('select');
        $property->setAccessible(TRUE);

        $this->builder->select('col');

        $this->assertEquals('col', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the select method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select
     */
    public function testSelectReturnsSelfReference()
    {
        $return = $this->builder->select('col');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the FROM part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithoutIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::from
     */
    public function testFromWithoutIndexHints()
    {
        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $this->builder->from('table');

        $this->assertEquals('FROM table', $property->getValue($this->builder));
    }

    /**
     * Test specifying the FROM part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testFromWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::from
     */
    public function testFromWithIndexHints()
    {
        $property = $this->builder_reflection->getProperty('from');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $this->builder->from('table', $hints);

        $this->assertEquals('FROM table index_hint', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the from method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::from
     */
    public function testFromReturnsSelfReference()
    {
        $return = $this->builder->from('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::join
     */
    public function testJoinWithDefaultJoinType()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->join('table');

        $this->assertEquals('INNER JOIN table', $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::join
     */
    public function testJoinWithNonDefaultJoinType()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->join('table', 'STRAIGHT');

        $this->assertEquals('STRAIGHT_JOIN table', $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithoutIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::join
     */
    public function testJoinWithoutIndexHints()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $this->builder->join('table', 'STRAIGHT');

        $this->assertEquals('STRAIGHT_JOIN table', $property->getValue($this->builder));
    }

    /**
     * Test specifying the JOIN part of a query.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithSingleIndexHint
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderQueryPartsTest::testJoinWithMultipleIndexHints
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::join
     */
    public function testJoinWithIndexHints()
    {
        $property = $this->builder_reflection->getProperty('join');
        $property->setAccessible(TRUE);

        $hints = array('index_hint');

        $this->builder->join('table', 'STRAIGHT', $hints);

        $this->assertEquals('STRAIGHT_JOIN table index_hint', $property->getValue($this->builder));
    }

    /**
     * Test fluid interface of the join method.
     *
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::join
     */
    public function testJoinReturnsSelfReference()
    {
        $return = $this->builder->join('table');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test that select modes for handling duplicate result entries are handled correctly.
     *
     * @param String $mode valid select mode for handling duplicate entries.
     *
     * @dataProvider selectModesDuplicatesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsDuplicatesCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode($mode);

        $modes = $property->getValue($this->builder);

        $this->assertEquals($mode, $modes['duplicates']);
    }

    /**
     * Test that select modes for handling the result cache are handled correctly.
     *
     * @param String $mode valid select mode for handling the cache.
     *
     * @dataProvider selectModesCacheProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsCacheCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode($mode);

        $modes = $property->getValue($this->builder);

        $this->assertEquals($mode, $modes['cache']);
    }

    /**
     * Test that standard select modes are handled correctly.
     *
     * @param String $mode valid select modes.
     *
     * @dataProvider selectModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that standard lock modes are handled correctly.
     *
     * @param String $mode valid select modes.
     *
     * @dataProvider lockModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::lock_mode
     */
    public function testLockModeSetsStandardCorrectly($mode)
    {
        $property = $this->builder_reflection->getProperty('lock_mode');
        $property->setAccessible(TRUE);

        $this->builder->lock_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown lock modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::lock_mode
     */
    public function testLockModeSetsIgnoresUnknownValues()
    {
        $property = $this->builder_reflection->getProperty('lock_mode');
        $property->setAccessible(TRUE);

        $this->builder->lock_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertEmpty($value);
    }

    /**
     * Test that there can be only one duplicate handling select mode set.
     *
     * @depends testSelectModeSetsDuplicatesCorrectly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeAllowsOnlyOneDuplicateStatement()
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode('ALL');
        $this->builder->select_mode('DISTINCT');

        $modes = $property->getValue($this->builder);

        $this->assertEquals('DISTINCT', $modes['duplicates']);
        $this->assertNotContains('ALL', $modes);
    }

    /**
     * Test that there can be only one cache handling select mode set.
     *
     * @depends testSelectModeSetsCacheCorrectly
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeAllowsOnlyOneCacheStatement()
    {
        $property = $this->builder_reflection->getProperty('select_mode');
        $property->setAccessible(TRUE);

        $this->builder->select_mode('SQL_NO_CACHE');
        $this->builder->select_mode('SQL_CACHE');

        $modes = $property->getValue($this->builder);

        $this->assertEquals('SQL_CACHE', $modes['cache']);
        $this->assertNotContains('SQL_NO_CACHE', $modes);
    }

    /**
     * Test fluid interface of the select_mode method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::select_mode
     */
    public function testSelectModeReturnsSelfReference()
    {
        $return = $this->builder->select_mode('DISTINCT');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

}

?>
