<?php

/**
 * This file contains the LunrCliParserValidShortTest class.
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
 * This class contains test methods for is_valid_short() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserValidShortTest extends LunrCliParserTest
{

    /**
     * Test that is_valid_short() returns FALSE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::is_valid_short
     */
    public function testIsValidShortReturnsFalseForInvalidParameter($param)
    {
        $method = $this->reflection->getMethod('is_valid_short');
        $method->setAccessible(TRUE);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

        $value = $method->invokeArgs($this->class, array($param, 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_valid_short() sets error to TRUE for an invalid parameter.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::is_valid_short
     */
    public function testIsValidShortSetsErrorTrueForInvalidParameter($param)
    {
        $method = $this->reflection->getMethod('is_valid_short');
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
     * Test that is_valid_short() adds a valid parameter to the ast array.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_short
     */
    public function testIsValidShortAddsValidParameterToAst()
    {
        $method = $this->reflection->getMethod('is_valid_short');
        $method->setAccessible(TRUE);

        $property = $this->reflection->getProperty('ast');
        $property->setAccessible(TRUE);

        $short = $this->reflection->getProperty('short');
        $short->setAccessible(TRUE);
        $short->setValue($this->class, 'a');

        $method->invokeArgs($this->class, array('a', 1));

        $value = $property->getValue($this->class);

        $this->assertArrayHasKey('a', $value);
        $this->assertEquals($value['a'], array());
    }

    /**
     * Test that is_valid_short() returns FALSE for a valid parameter without arguments.
     *
     * @depends Lunr\Shadow\Tests\LunrCliParserCheckArgumentTest::testCheckArgumentReturnsFalseForValidParameterWithoutArgs
     * @covers Lunr\Shadow\LunrCliParser::is_valid_short
     */
    public function testIsValidShortReturnsFalseForValidParameterWithoutArguments()
    {
        $method = $this->reflection->getMethod('is_valid_short');
        $method->setAccessible(TRUE);

        $property = $this->reflection->getProperty('short');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, 'a');

        $value = $method->invokeArgs($this->class, array('a', 1));

        $this->assertFalse($value);
    }

    /**
     * Test that is_valid_short() returns TRUE for a valid parameter with arguments.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_valid_short
     */
    public function testIsValidShortReturnsTrueForValidParameterWithArguments()
    {
        $method = $this->reflection->getMethod('is_valid_short');
        $method->setAccessible(TRUE);

        $args = $this->reflection->getProperty('args');
        $args->setAccessible(TRUE);
        $args->setValue($this->class, array('test.php', '-b', 'arg'));

        $property = $this->reflection->getProperty('short');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, 'b:');

        $value = $method->invokeArgs($this->class, array('b', 1));

        $this->assertTrue($value);
    }

}

?>
