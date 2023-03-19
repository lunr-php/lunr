<?php

/**
 * This file contains the SQLite3DMLQueryBuilderInsertTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * insert/replace queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderInsertTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test fluid interface of the insert_mode method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeReturnsSelfReference(): void
    {
        $return = $this->class->insert_mode('ROLLBACK');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test fluid interface of the replace_mode method.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::replace_mode
     */
    public function testReplaceModeReturnsSelfReference(): void
    {
        $return = $this->class->replace_mode('ROLLBACK');

        $this->assertInstanceOf('Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder', $return);
        $this->assertSame($this->class, $return);
    }

    /**
     * Test that standard insert modes are handled correctly.
     *
     * @param string $mode Valid insert mode.
     *
     * @dataProvider modesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsStandardCorrectly($mode): void
    {
        $this->class->insert_mode($mode);
        $value = $this->get_reflection_property_value('insert_mode');

        $this->assertContains($mode, $value);
    }

    /**
     * Test that unknown insert modes are ignored.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsIgnoresUnknownValues(): void
    {
        $this->class->insert_mode('UNSUPPORTED');
        $value = $this->get_reflection_property_value('insert_mode');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test insert modes get uppercased properly.
     *
     * @param string $value    Insert mode to set
     * @param string $expected Expected built query part
     *
     * @dataProvider expectedModesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::insert_mode
     */
    public function testInsertModeCase($value, $expected): void
    {
        $this->class->insert_mode($value);
        $modes = $this->get_reflection_property_value('insert_mode');

        $this->assertContains($expected, $modes);
    }

}
