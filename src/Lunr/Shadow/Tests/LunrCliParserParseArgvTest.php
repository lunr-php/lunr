<?php

/**
 * This file contains the LunrCliParserParseArgvTest class.
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
 * This class contains test methods for parse_argv() in the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserParseArgvTest extends LunrCliParserTest
{

    /**
     * Test that parsing no arguments returns an empty array.
     *
     * @covers Lunr\Shadow\LunrCliParser::parse_argv
     */
    public function testParseArgvWithNoArgumentsReturnsEmptyArray()
    {
        $args = array('script.php');

        $value = $this->class->parse_argv($args);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that parsing with incomplete arguments returns an empty array.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserIsOptTest::testIsOptReturnsFalseForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::parse_argv
     */
    public function testParseArgvWithIncompleteArguments($param)
    {
        $args = array('script.php', $param);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

        $value = $this->class->parse_argv($args);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that parsing with incomplete arguments returns an empty array.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserIsOptTest::testIsOptSetsErrorTrueForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::parse_argv
     */
    public function testParseArgvWithIncompleteArgumentsSetsErrorTrue($param)
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $args = array('script.php', $param);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('Invalid parameter given: {parameter}', array('parameter' => $param));

        $this->class->parse_argv($args);

        $this->assertTrue($property->getValue($this->class));
    }

    /**
     * Test parsing valid short parameters.
     *
     * @param String $shortopt Short options string
     * @param array  $params   Array of passed arguments
     * @param array  $ast      Array of expected parsed ast
     *
     * @dataProvider validShortParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::parse_argv
     */
    public function testParseValidShortParameters($shortopt, $params, $ast)
    {
        $property = $this->reflection->getProperty('short');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, $shortopt);

        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->parse_argv($params);

        $this->assertInternalType('array', $value);
        $this->assertEquals($ast, $value);
    }

    /**
     * Test parsing valid short parameters.
     *
     * @param String $shortopt Short options string
     * @param array  $params   Array of passed arguments
     * @param array  $ast      Array of expected parsed ast
     *
     * @dataProvider validLongParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::parse_argv
     */
    public function testParseValidLongParameters($longopt, $params, $ast)
    {
        $property = $this->reflection->getProperty('long');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, $longopt);

        $this->logger->expects($this->never())
                     ->method('error');

        $value = $this->class->parse_argv($params);

        $this->assertInternalType('array', $value);
        $this->assertEquals($ast, $value);
    }

}

?>
