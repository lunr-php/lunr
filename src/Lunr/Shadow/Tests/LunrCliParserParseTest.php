<?php

/**
 * This file contains the LunrCliParserParseTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for parse() in the LunrCliParser class.
 *
 * @covers Lunr\Shadow\LunrCliParser
 */
class LunrCliParserParseTest extends LunrCliParserTest
{

    /**
     * Test that parsing no arguments returns an empty array.
     *
     * @covers Lunr\Shadow\LunrCliParser::parse
     */
    public function testParseArgvWithNoArgumentsReturnsEmptyArray(): void
    {
        $_SERVER['argv'] = [ 'script.php' ];

        $value = $this->class->parse();

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that parsing with incomplete arguments returns an empty array and sets the Error property.
     *
     * @param mixed $param Invalid Parameter
     *
     * @dataProvider invalidParameterProvider
     * @depends      Lunr\Shadow\Tests\LunrCliParserIsOptTest::testIsOptReturnsFalseForInvalidParameter
     * @covers       Lunr\Shadow\LunrCliParser::parse
     */
    public function testParseArgvWithIncompleteArguments($param): void
    {
        $_SERVER['argv'] = [ 'script.php', $param ];

        $this->console->expects($this->once())
                      ->method('cli_println')
                      ->with($this->equalTo('Invalid parameter given: ' . $param));

        $value = $this->class->parse();

        $this->assertArrayEmpty($value);
        $this->assertTrue($this->get_reflection_property_value('error'));
    }

    /**
     * Test parsing valid short parameters.
     *
     * @param string $shortopt Short options string
     * @param array  $params   Array of passed arguments
     * @param array  $ast      Array of expected parsed ast
     *
     * @dataProvider validShortParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::parse
     */
    public function testParseValidShortParameters($shortopt, $params, $ast): void
    {
        $this->set_reflection_property_value('short', $shortopt);

        $this->console->expects($this->never())
                      ->method('cli_println');

        $_SERVER['argv'] = $params;

        $value = $this->class->parse();

        $this->assertSame($ast, $value);
    }

    /**
     * Test parsing valid short parameters.
     *
     * @param string $longopt Long options string
     * @param array  $params  Array of passed arguments
     * @param array  $ast     Array of expected parsed ast
     *
     * @dataProvider validLongParameterProvider
     * @covers       Lunr\Shadow\LunrCliParser::parse
     */
    public function testParseValidLongParameters($longopt, $params, $ast): void
    {
        $this->set_reflection_property_value('long', $longopt);

        $this->console->expects($this->never())
                      ->method('cli_println');

        $_SERVER['argv'] = $params;

        $value = $this->class->parse();

        $this->assertSame($ast, $value);
    }

}

?>
