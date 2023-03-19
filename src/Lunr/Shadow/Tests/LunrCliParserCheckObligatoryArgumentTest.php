<?php

/**
 * This file contains the LunrCliParserCheckObligatoryArgumentTest class.
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
class LunrCliParserCheckObligatoryArgumentTest extends LunrCliParserTest
{

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-b', 'arg' ]);

        $this->set_reflection_property_value('ast', [ 'b' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs(): void
    {
        $args = $this->set_reflection_property_value('args', [ 'test.php', '-e', 'arg1', 'arg2' ]);

        $ast = $this->set_reflection_property_value('ast', [ 'e' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, [ 'e', 1, 0, 'e::' ]);

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-b', 'arg' ]);

        $this->set_reflection_property_value('ast', [ 'b' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(1, $value['b']);
        $this->assertEquals([ 'arg' ], $value['b']);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst(): void
    {
        $this->set_reflection_property_value('args', [ 'test.php', '-e', 'arg1', 'arg2' ]);

        $this->set_reflection_property_value('ast', [ 'e' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, [ 'e', 1, 0, 'e::' ]);

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(2, $value['e']);
        $this->assertEquals([ 'arg1', 'arg2' ], $value['e']);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing(): void
    {
        $args = $this->set_reflection_property_value('args', [ 'test.php', '-b' ]);

        $ast = $this->set_reflection_property_value('ast', [ 'b' => [] ]);

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Missing argument for -b'));

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

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

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Missing argument for -b'));

        $value = $method->invokeArgs($this->class, [ 'b', 1, 0, 'b:' ]);

        $this->assertFalse($value);
    }

}

?>
