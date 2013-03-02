<?php

/**
 * This file contains the LunrCliParserIsOptTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for is_opt() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
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
        $property = $this->reflection->getProperty('checked');
        $property->setAccessible(TRUE);

        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('1', 2));

        $this->assertEquals(array('1'), $property->getValue($this->class));
    }

    /**
     * Test that is_opt() pushes non-initial arguments at the end of the checked array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptPushesNonInitialArgumentAtTheEndOfChecked()
    {
        $property = $this->reflection->getProperty('checked');
        $property->setAccessible(TRUE);

        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $method->invokeArgs($this->class, array('1', 2));
        $method->invokeArgs($this->class, array('2', 2));

        $this->assertEquals(array('1', '2'), $property->getValue($this->class));
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
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

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
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

        $method->invokeArgs($this->class, array($param, 1));

        $this->assertTrue($property->getValue($this->class));
    }

    /**
     * Test is_opt() with a superfluous toplevel argument.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_opt
     */
    public function testIsOptWithSuperfluousToplevelArgument()
    {
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('notice')
                     ->with('Superfluous argument: {parameter}', array('parameter' => 'first'));

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
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

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
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

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
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b', 'arg'));

        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

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
        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '--second', 'arg'));

        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

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
        $method = $this->reflection->getMethod('is_opt');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array('arg', 2));

        $this->assertFalse($value);
    }

}

?>
