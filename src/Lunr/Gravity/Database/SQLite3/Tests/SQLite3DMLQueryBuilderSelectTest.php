<?php

/**
 * This file contains the SQLite3DMLQueryBuilderSelectTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * select queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderSelectTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test that select modes for handling duplicate result entries are handled correctly.
     *
     * @param string $mode Valid select mode for handling duplicate entries.
     *
     * @dataProvider selectModesDuplicatesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeSetsDuplicatesCorrectly($mode): void
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
    public function testSelectModeSetsIgnoresUnknownValues(): void
    {
        $this->class->select_mode('UNSUPPORTED');

        $modes = $this->get_reflection_property_value('select_mode');

        $this->assertIsArray($modes);
        $this->assertEmpty($modes);
    }

    /**
     * Test that there can be only one duplicate handling select mode set.
     *
     * @depends testSelectModeSetsDuplicatesCorrectly
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::select_mode
     */
    public function testSelectModeAllowsOnlyOneDuplicateStatement(): void
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
    public function testSelectModeReturnsSelfReference(): void
    {
        $return = $this->class->select_mode('DISTINCT');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the lock_mode method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::lock_mode
     */
    public function testLockModeReturnsSelfReference(): void
    {
        $return = $this->class->lock_mode('');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
