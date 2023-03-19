<?php

/**
 * This file contains the MySQLDMLQueryBuilderDeleteTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains the tests for the query parts necessary to build
 * delete queries.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder
 */
class MySQLDMLQueryBuilderDeleteTest extends MySQLDMLQueryBuilderTest
{

    /**
     * Test that standard delete modes are handled correctly.
     *
     * @param string $mode Valid delete mode.
     *
     * @dataProvider deleteModesStandardProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsStandardCorrectly($mode): void
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($mode);

        $this->assertContains($mode, $property->getValue($this->builder));
    }

    /**
     * Test that unknown delete modes are ignored.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeSetsIgnoresUnknownValues(): void
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode('UNSUPPORTED');

        $value = $property->getValue($this->builder);

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test fluid interface of the delete_mode method.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeReturnsSelfReference(): void
    {
        $return = $this->builder->delete_mode('IGNORE');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder', $return);
        $this->assertSame($this->builder, $return);
    }

    /**
     * Test delete modes get uppercased properly.
     *
     * @param string $value    Delete mode to set
     * @param string $expected Expected built query part
     *
     * @dataProvider expectedDeleteModesProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder::delete_mode
     */
    public function testDeleteModeCase($value, $expected): void
    {
        $property = $this->builder_reflection->getProperty('delete_mode');
        $property->setAccessible(TRUE);

        $this->builder->delete_mode($value);

        $this->assertContains($expected, $property->getValue($this->builder));
    }

}

?>
