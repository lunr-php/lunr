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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::lock_mode
     */
    public function testLockModeReturnsSelfReference()
    {
        $return = $this->class->lock_mode('');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

}
