<?php

/**
 * This file contains the MySQLSimpleDMLQueryBuilderBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This class contains basic tests for the MySQLSimpleDMLQueryBuilder class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder
 */
class MySQLSimpleDMLQueryBuilderBaseTest extends MySQLSimpleDMLQueryBuilderTest
{

    /**
     * Test the QueryEscaper class is passed correctly.
     */
    public function testEscaperIsPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MySQL\MySQLQueryEscaper';
        $this->assertInstanceOf($instance, $this->get_reflection_property_value('escaper'));
    }

    /**
     * Test if the query builder has been passed correctly.
     */
    public function testQuerybuilderPassedCorrectly(): void
    {
        $instance = 'Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder';
        $this->assertInstanceOf($instance, $this->get_reflection_property_value('builder'));
    }

    /**
     * Test escape_alias() with aliased references.
     *
     * @param string $input    Location reference
     * @param bool   $type     Whether to escape a Table or a Result column
     * @param string $name     Reference name
     * @param string $alias    Alias
     * @param string $expected Expected escaped string
     *
     * @dataProvider locationReferenceAliasProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasWithAlias($input, $type, $name, $alias, $expected): void
    {
        $method = $type ? 'table' : 'result_column';

        $this->escaper->expects($this->once())
                      ->method($method)
                      ->with($this->equalTo($name), $this->equalTo($alias))
                      ->will($this->returnValue($expected));

        $method = $this->get_accessible_reflection_method('escape_alias');

        $result = $method->invokeArgs($this->class, [ $input, $type ]);

        $this->assertEquals($result, $expected);
    }

    /**
     * Test escape_alias() with plain references.
     *
     * @param string $input    Location reference
     * @param bool   $type     Whether to escape a Table or a Result column
     * @param string $expected Expected escaped string
     *
     * @dataProvider locationReferenceProvider
     * @covers       Lunr\Gravity\Database\MySQL\MySQLSimpleDMLQueryBuilder::escape_alias
     */
    public function testEscapeAliasPlain($input, $type, $expected): void
    {
        $method = $type ? 'table' : 'result_column';

        $this->escaper->expects($this->once())
                      ->method($method)
                      ->with($this->equalTo($input))
                      ->will($this->returnValue($expected));

        $method = $this->get_accessible_reflection_method('escape_alias');

        $result = $method->invokeArgs($this->class, [ $input, $type ]);

        $this->assertEquals($result, $expected);
    }

}

?>
