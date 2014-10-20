<?php

/**
 * This file contains the CliRequestParserParseCommandLineArgumentsTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Shadow
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseCommandLineArgumentsTest extends CliRequestParserTest
{

    /**
     * Test storing no command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParsingNoCommandLineArguments()
    {
        $this->set_reflection_property_value('ast', []);
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test storing no non-request command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParsingNoNonRequestCommandLineArguments()
    {
        $ast = [
            'controller'      => [ 'thecontroller' ],
            'c'               => [ 'thecontroller' ],
            'method'          => [ 'themethod' ],
            'm'               => [ 'themethod' ],
            'params'          => [ 'param' ],
            'param'           => [ 'param' ],
            'p'               => [ 'param' ],
            'post'            => [ 'data' ],
            'get'             => [ 'data' ],
            'files'           => [ 'file' ],
            'cookie'          => [ 'data' ],
            'accept-format'   => [ 'format' ],
            'accept-language' => [ 'language' ],
            'accept-charset'  => [ 'charset' ],
        ];

        $this->set_reflection_property_value('ast', $ast);
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test storing parsed command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParseEmptySuperGlobalValues()
    {
        $ast = [
            'controller'      => [ 'thecontroller' ],
            'c'               => [ 'thecontroller' ],
            'method'          => [ 'themethod' ],
            'm'               => [ 'themethod' ],
            'params'          => [ 'param' ],
            'param'           => [ 'param' ],
            'p'               => [ 'param' ],
            'post'            => [ 'data' ],
            'get'             => [ 'data' ],
            'files'           => [ 'file' ],
            'cookie'          => [ 'data' ],
            'accept-format'   => [ 'format' ],
            'accept-language' => [ 'language' ],
            'accept-charset'  => [ 'charset' ],
            'f'               => [ 'value1' ],
            'g'               => [ 'value2' ],
        ];

        $this->set_reflection_property_value('ast', $ast);

        $result = $this->class->parse_command_line_arguments();

        $this->assertEquals([ 'f' => [ 'value1' ], 'g' => [ 'value2' ] ], $result);
    }

}

?>
