<?php

/**
 * This file contains the LunrCliParserValidLongTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for is_valid_long() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserValidLongTest extends LunrCliParserTest
{

    /**
     * Test that is_valid_long() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongReturnsFalseForInvalidParameter($param)
    {
        $method = $this->get_accessible_reflection_method('is_valid_long');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Invalid parameter given: ' . $param));

        $value = $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that is_valid_long() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongSetsErrorTrueForInvalidParameter($param)
    {
        $method = $this->get_accessible_reflection_method('is_valid_long');

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Invalid parameter given: ' . $param));

        $method->invokeArgs($this->class, [ $param, 1 ]);

        $this->assertTrue($this->get_reflection_property_value('error'));
    }

    /**
     * Test that is_valid_long() adds a valid parameter to the ast array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongAddsValidParameterToAst()
    {
        $method = $this->get_accessible_reflection_method('is_valid_long');

        $this->set_reflection_property_value('long', [ 'first' ]);

        $method->invokeArgs($this->class, [ 'first', 1 ]);

        $value = $this->get_reflection_property_value('ast');

        $this->assertArrayHasKey('first', $value);
        $this->assertEquals($value['first'], []);
    }

    /**
     * Test that is_valid_long() returns FALSE for a valid parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserCheckArgumentTest::testCheckArgumentReturnsFalseForValidParameterWithoutArgs
     * @covers  Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongReturnsFalseForValidParameterWithoutArguments()
    {
        $method = $this->get_accessible_reflection_method('is_valid_long');

        $this->set_reflection_property_value('long', [ 'first' ]);

        $value = $method->invokeArgs($this->class, [ 'first', 1 ]);

        $this->assertFalse($value);
    }

    /**
     * Test that is_valid_long() returns TRUE for a valid parameter with arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongReturnsTrueForValidParameterWithArguments()
    {
        $method = $this->get_accessible_reflection_method('is_valid_long');

        $this->set_reflection_property_value('args', [ 'test.php', '--second', 'arg' ]);

        $this->set_reflection_property_value('long', [ 'second:' ]);

        $value = $method->invokeArgs($this->class, [ 'second', 1 ]);

        $this->assertTrue($value);
    }

}
