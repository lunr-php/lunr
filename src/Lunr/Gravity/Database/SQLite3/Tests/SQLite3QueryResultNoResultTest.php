<?php

/**
 * Contains SQLite3QueryResultNoResultTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

/**
 * This class contains the tests for testing a successful connection with no result.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultNoResultTest extends SQLite3QueryResultTest
{

    /**
     * Override the default setUp with a setup with no result.
     */
    public function setUp(): void
    {
        $this->setUpWithNoResult();
    }

    /**
     * Test that the success flag is TRUE.
     */
    public function testSuccessIsTrue(): void
    {
        $this->get_accessible_reflection_property('success');
        $this->assertTrue($this->get_reflection_property_value('success'));
    }

    /**
     * Test that the result value is FALSE.
     *
     * In the setUp the result is set to TRUE when there is an empty result.
     */
    public function testResultIsEmpty(): void
    {
        $this->get_accessible_reflection_property('result');
        $this->assertTrue($this->get_reflection_property_value('result'));
    }

    /**
     * Test that the freed flag is TRUE.d
     */
    public function testFreedIsTrue(): void
    {
        $this->get_accessible_reflection_property('freed');
        $this->assertTrue($this->get_reflection_property_value('freed'));
    }

    /**
     * Test that the has_failed() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_failed
     */
    public function testHasFailedReturnsFalse(): void
    {
        $this->assertFalse($this->class->has_failed());
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayReturnsEmptyArray(): void
    {
        $value = $this->class->result_array();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_row() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowReturnsEmptyArray(): void
    {
        $value = $this->class->result_row();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_column() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnReturnsEmptyArray(): void
    {
        $value = $this->class->result_column('column');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_cell() returns NULL.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellReturnsNull(): void
    {
        $this->assertNull($this->class->result_cell('cell'));
    }

}

?>
