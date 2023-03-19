<?php

/**
 * This file contains the MySQLDMLQueryBuilderInsertTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * insert/replace queries.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderInsertTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test fluid interface of the insert_mode method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeReturnsSelfReference(): void
    {
        $return = $this->builder->insert_mode('LOW_PRIORITY');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test fluid interface of the replace_mode method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::replace_mode
     */
    public function testReplaceModeReturnsSelfReference(): void
    {
        $return = $this->builder->replace_mode('LOW_PRIORITY');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test that standard insert modes are handled correctly.
     *
     * @param string $mode Valid insert mode.
     *
     * @dataProvider insertModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsStandardCorrectly($mode): void
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown insert modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeSetsIgnoresUnknownValues(): void
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test insert modes get uppercased properly.
     *
     * @param string $value    Insert mode to set
     * @param string $expected Expected built query part
     *
     * @dataProvider expectedInsertModesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::insert_mode
     */
    public function testInsertModeCase($value, $expected): void
    {
        $property = $this->builder_reflection->getProperty('insert_mode');
        $property->setAccessible(TRUE);

        $this->builder->insert_mode($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }

    /**
     * Test specifying an ON DUPLICATE KEY UPDATE clause.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::on_duplicate_key_update
     */
    public function testOnDuplicateKeyUpdate()
    {
        $property = $this->builder_reflection->getProperty('upsert');
        $property->setAccessible(TRUE);

        $return = $this->builder->on_duplicate_key_update('col=col+1');

        $value = $property->getValue($this->builder);

        $this->assertEquals('ON DUPLICATE KEY UPDATE col=col+1', $value);
        $this->assertSame($this->builder, $return);
    }

}

?>
