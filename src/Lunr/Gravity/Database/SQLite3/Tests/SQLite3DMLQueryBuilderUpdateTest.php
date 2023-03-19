<?php

/**
 * This file contains the SQLite3DMLQueryBuilderUpdateTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * update queries.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder
 */
class SQLite3DMLQueryBuilderUpdateTest extends SQLite3DMLQueryBuilderTest
{

    /**
     * Test that standard update modes are handled correctly.
     *
     * @param string $mode Valid update modes.
     *
     * @dataProvider modesProvider
     * @covers       Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update_mode
     */
    public function testUpdateModeSetsStandardCorrectly($mode): void
    {
        $this->class->update_mode($mode);
        $value = $this->get_reflection_property_value('update_mode');

        $this->assertContains($mode, $value);
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateModeEmptyByDefault
     * @covers  Lunr\Gravity\Database\SQLite3\SQLite3DMLQueryBuilder::update_mode
     */
    public function testUpdateModeIgnoresUnknownValues(): void
    {
        $this->class->update_mode('UNSUPPORTED');
        $value = $this->get_reflection_property_value('update_mode');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

}

?>
