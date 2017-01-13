<?php

/**
 * This file contains the LunrCliParserIsOptTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for is_opt() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserIsOptTest extends LunrCliParserTest
{

    /**
     * Test that is_opt() pushes the initial argument into the checked array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptPushesInitialArgumentIntoChecked()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $method->invokeArgs($this->class, array('1', 2));

        $this->assertPropertyEquals('checked', array('1'));
    }

    /**
     * Test that is_opt() pushes non-initial arguments at the end of the checked array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptPushesNonInitialArgumentAtTheEndOfChecked()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $method->invokeArgs($this->class, array('1', 2));
        $method->invokeArgs($this->class, array('2', 2));

        $this->assertPropertyEquals('checked', array('1', '2'));
    }

    /**
     * Test that is_opt() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsFalseForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsFalseForInvalidParameter($param)
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Invalid parameter given: ' . $param));

        $value = $method->invokeArgs($this->class, array($param, 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_opt() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortSetsErrorTrueForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptSetsErrorTrueForInvalidParameter($param)
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Invalid parameter given: ' . $param));

        $method->invokeArgs($this->class, array($param, 1));

        $this->assertTrue($this->get_reflection_property_value('error'));
    }

    /**
     * Test is_opt() with a superfluous toplevel argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptWithSuperfluousToplevelArgument()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Superfluous argument: first'));

        $value = $method->invokeArgs($this->class, array('first', 1, TRUE));

        $this->assertFalse($value);
    }

    /**
     * Test that is_opt() returns FALSE for a valid short parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsFalseForValidParameterWithoutArguments
     * @covers  Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsFalseForValidShortParameterWithoutArguments()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $value = $method->invokeArgs($this->class, array('-a', 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_opt() returns FALSE for a valid long parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidLongTest::testIsValidLongReturnsFalseForValidParameterWithoutArguments
     * @covers  Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsFalseForValidLongParameterWithoutArguments()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $value = $method->invokeArgs($this->class, array('--first', 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_opt() returns TRUE for a valid short parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidShortTest::testIsValidShortReturnsTrueForValidParameterWithArguments
     * @covers  Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsTrueForValidShortParameterWithArguments()
    {
        $this->set_reflection_property_value('args', array('test.php', '-b', 'arg'));

        $method = $this->get_accessible_reflection_method('is_opt');

        $value = $method->invokeArgs($this->class, array('-b', 1));

        $this->assertTrue($value);
    }

    /**
     * Test that is_opt() returns TRUE for a valid long parameter with arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserValidLongTest::testIsValidLongReturnsTrueForValidParameterWithArguments
     * @covers  Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsTrueForValidLongParameterWithArguments()
    {
        $this->set_reflection_property_value('args', array('test.php', '--second', 'arg'));

        $method = $this->get_accessible_reflection_method('is_opt');

        $value = $method->invokeArgs($this->class, array('--second', 1));

        $this->assertTrue($value);
    }

    /**
     * Test that is_opt() returns FALSE if the parameter given is an argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptReturnsFalseForArgument()
    {
        $method = $this->get_accessible_reflection_method('is_opt');

        $value = $method->invokeArgs($this->class, array('arg', 2));

        $this->assertFalse($value);
    }

}

?>
