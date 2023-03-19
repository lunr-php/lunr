<?php

/**
 * This file contains the LunrCliParserCheckOptionalArgumentTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for check_arguments() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserCheckOptionalArgumentTest extends LunrCliParserTest
{

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-c', 'arg' ]);

        $this->set_reflection_property_value('ast', [ 'c' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, [ 'c', 1, 0, 'c;' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-f', 'arg1', 'arg2' ]);

        $this->set_reflection_property_value('ast', [ 'f' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, [ 'f', 1, 0, 'f;;' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-c', 'arg' ]);

        $this->set_reflection_property_value('ast', [ 'c' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, [ 'c', 1, 0, 'c;' ]);

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(1, $value['c']);
        $this->assertEquals([ 'arg' ], $value['c']);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-f', 'arg1', 'arg2' ]);

        $this->set_reflection_property_value('ast', [ 'f' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, [ 'f', 1, 0, 'f;;' ]);

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(2, $value['f']);
        $this->assertEquals([ 'arg1', 'arg2' ], $value['f']);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-b' ]);

        $this->set_reflection_property_value('ast', [ 'b' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->never())
                      ->method('cli_println');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b;' ]);

        $this->assertFalse($value);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissingWithAnotherParameterAfter(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-b', '-c' ]);

        $this->set_reflection_property_value('ast', [ 'b' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->never())
                      ->method('cli_println');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b;' ]);

        $this->assertFalse($value);
    }

}

?>
