<?php

/**
 * This file contains the MySQLDMLQueryBuilderUpdateTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * update queries.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderUpdateTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test that standard update modes are handled correctly.
     *
     * @param string $mode Valid update modes.
     *
     * @dataProvider updateModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update_mode
     */
    public function testUpdateModeSetsStandardCorrectly($mode): void
    {
        $property = $this->builder_reflection->getProperty('update_mode');
        $property->setAccessible(TRUE);

        $this->builder->update_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown select modes are ignored.
     *
     * @depends Lunr\Gravity\Database\Tests\DatabaseDMLQueryBuilderBaseTest::testUpdateModeEmptyByDefault
     * @covers  Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::update_mode
     */
    public function testUpdateModeIgnoresUnknownValues(): void
    {
        $property = $this->builder_reflection->getProperty('update_mode');
        $property->setAccessible(TRUE);

        $this->builder->update_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

}

?>
