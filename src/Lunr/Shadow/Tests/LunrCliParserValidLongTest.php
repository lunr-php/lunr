<?php

/**
 * This file contains the LunrCliParserValidLongTest class.
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
 * This class contains test methods for is_valid_long() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
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
        $method = $this->reflection->getMethod('is_valid_long');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

        $value = $method->invokeArgs($this->class, array($param, 1));

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
        $method = $this->reflection->getMethod('is_valid_long');
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
     * Test that is_valid_long() adds a valid parameter to the ast array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongAddsValidParameterToAst()
    {
        $method = $this->reflection->getMethod('is_valid_long');
        $method->setAccessible(TRUE);

        $property = $this->reflection->getProperty('ast');
        $property->setAccessible(TRUE);

        $short = $this->reflection->getProperty('long');
        $short->setAccessible(TRUE);
        $short->setValue($this->class, array('first'));

        $method->invokeArgs($this->class, array('first', 1));

        $value = $property->getValue($this->class);

        $this->assertArrayHasKey('first', $value);
        $this->assertEquals($value['first'], array());
    }

    /**
     * Test that is_valid_long() returns FALSE for a valid parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserCheckArgumentTest::testCheckArgumentReturnsFalseForValidParameterWithoutArgs
     * @covers  Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongReturnsFalseForValidParameterWithoutArguments()
    {
        $method = $this->reflection->getMethod('is_valid_long');
        $method->setAccessible(TRUE);

        $property = $this->reflection->getProperty('long');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, array('first'));

        $value = $method->invokeArgs($this->class, array('first', 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_valid_long() returns TRUE for a valid parameter with arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_long
     */
    public function testIsValidLongReturnsTrueForValidParameterWithArguments()
    {
        $method = $this->reflection->getMethod('is_valid_long');
        $method->setAccessible(TRUE);

        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '--second', 'arg'));

        $property = $this->reflection->getProperty('long');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, array('second:'));

        $value = $method->invokeArgs($this->class, array('second', 1));

        $this->assertTrue($value);
    }

}
