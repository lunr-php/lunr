<?php

/**
 * This file contains the SQLite3DMLQueryBuilderSelectTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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

    /**
     * Test if except returns an instance of itself.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::except
     */
    public function testIfExceptReturnsSelfReference()
    {
        $except = $this->class->except('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $except);
        $this->assertSame($this->class, $except);
    }

    /**
     * Test if intersect returns an instance of itself.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::intersect
     */
    public function testIfIntersectReturnsSelfReference()
    {
        $intersect = $this->class->intersect('query');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $intersect);
        $this->assertSame($this->class, $intersect);
    }

    /**
     * Test if intersect() defaults to INTERSECT when a string other than DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::intersect
     */
    public function testIntersectDefaults()
    {
        $this->class->intersect('query', 'random_string');
        $returned = $this->get_reflection_property_value('compound');
        $this->assertEquals('INTERSECT query', $returned);
    }

    /**
     * Test if intersect() returns INTERSECT DISTINCT when DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::intersect
     */
    public function testIntersectDistinct()
    {
        $this->class->intersect('query', 'DISTINCT');
        $returned = $this->get_reflection_property_value('compound');
        $this->assertEquals('INTERSECT DISTINCT query', $returned);
    }

    /**
     * Test if except() defaults to EXCEPT when a string other than DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::except
     */
    public function testExceptDefaults()
    {
        $this->class->except('query', 'random_string');
        $returned = $this->get_reflection_property_value('compound');
        $this->assertEquals('EXCEPT query', $returned);
    }

    /**
     * Test if except() returns EXCEPT DISTINCT when DISTINCT is passed.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::except
     */
    public function testExceptDistinct()
    {
        $this->class->except('query', 'DISTINCT');
        $returned = $this->get_reflection_property_value('compound');
        $this->assertEquals('EXCEPT DISTINCT query', $returned);
    }

}

?>
