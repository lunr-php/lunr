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
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
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
