<?php

/**
 * This file contains the LunrCliParserCheckObligatoryArgumentTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
    public function testCheckArgumentReturnsTrueForValidParameterWithOneArg()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b', 'arg'));

        $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() returns TRUE for a valid parameter with one argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsTrueForValidParameterWithTwoArgs()
    {
        $args = $this->set_reflection_property_value('args', array('test.php', '-e', 'arg1', 'arg2'));

        $ast = $this->set_reflection_property_value('ast', array('e' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $value = $method->invokeArgs($this->class, array('e', 1, 0, 'e::'));

        $this->assertTrue($value);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsFirstArgumentToAst()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b', 'arg'));

        $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(1, $value['b']);
        $this->assertEquals(array('arg'), $value['b']);
    }

    /**
     * Test that check_argument() appends first argument to ast.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentAppendsSecondArgumentToAst()
    {
        $this->set_reflection_property_value('args', array('test.php', '-e', 'arg1', 'arg2'));

        $this->set_reflection_property_value('ast', array('e' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $method->invokeArgs($this->class, array('e', 1, 0, 'e::'));

        $value = $this->get_reflection_property_value('ast');

        $this->assertCount(2, $value['e']);
        $this->assertEquals(array('arg1', 'arg2'), $value['e']);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissing()
    {
        $args = $this->set_reflection_property_value('args', array('test.php', '-b'));

        $ast = $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Missing argument for -b'));

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertFalse($value);
    }

    /**
     * Test that check_argument() returns FALSE when the argument is missing.
     *
     * @covers Lunr\Shadow\LunrCliParser::check_argument
     */
    public function testCheckArgumentReturnsFalseForArgumentMissingWithAnotherParameterAfter()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b', '-c'));

        $this->set_reflection_property_value('ast', array('b' => array()));

        $method = $this->get_accessible_reflection_method('check_argument');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Missing argument for -b'));

        $value = $method->invokeArgs($this->class, array('b', 1, 0, 'b:'));

        $this->assertFalse($value);
    }

}

?>
