<?php

/**
 * This file contains the GetoptCliParserParseTest class.
 *
 * PHP Version 5.3
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
 * This class contains test methods for parse() in the GetoptCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\GetoptCliParser
 */
class GetoptCliParserParseTest extends GetoptCliParserTest
{

    /**
     * Test that wrap_argument() replaces a FALSE value with an empty array.
     *
     * @covers Lunr\Shadow\GetoptCliParser::wrap_argument
     */
    public function testWrapArgumentReturnsEmptyArrayForFalse()
    {
        $method = $this->reflection->getMethod('wrap_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array(FALSE));

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that wrap_argument() replaces a FALSE value with an empty array.
     *
     * @param mixed $cli_value Value to wrap
     *
     * @dataProvider valueProvider
     * @covers       Lunr\Shadow\GetoptCliParser::wrap_argument
     */
    public function testWrapArgumentReturnsValueWrappedInArray($cli_value)
    {
        $method = $this->reflection->getMethod('wrap_argument');
        $method->setAccessible(TRUE);

        $value = $method->invokeArgs($this->class, array($cli_value));

        $this->assertEquals(array($cli_value), $value);
    }

    /**
     * Test that parse() returns an empty array on error.
     *
     * @requires extension runkit
     * @covers   Lunr\Shadow\GetoptCliParser::parse
     */
    public function testParseReturnsEmptyArrayOnError()
    {
        runkit_function_redefine('getopt', '', self::PARSE_FAILS);

        $value = $this->class->parse();

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that parse() sets error to TRUE on error.
     *
     * @requires extension runkit
     * @covers   Lunr\Shadow\GetoptCliParser::parse
     */
    public function testParseSetsErrorTrueOnError()
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        runkit_function_redefine('getopt', '', self::PARSE_FAILS);

        $this->class->parse();

        $value = $property->getValue($this->class);

        $this->assertTrue($value);
    }

    /**
     * Test that parse() returns an ast array on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Shadow\GetoptCliParser::parse
     */
    public function testParseReturnsAstOnSuccess()
    {
        runkit_function_redefine('getopt', '', self::PARSE_WORKS);

        $value = $this->class->parse();

        $this->assertInternalType('array', $value);
        $this->assertEquals(array('a' => array(), 'b' => array('arg')), $value);
    }

}

?>
