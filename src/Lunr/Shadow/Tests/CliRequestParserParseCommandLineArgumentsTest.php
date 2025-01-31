<?php

/**
 * This file contains the CliRequestParserParseCommandLineArgumentsTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseCommandLineArgumentsTest extends CliRequestParserTestCase
{

    /**
     * Test storing no command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParsingNoCommandLineArguments(): void
    {
        $this->setReflectionPropertyValue('ast', []);
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test storing no non-request command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParsingNoNonRequestCommandLineArguments(): void
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

        $this->setReflectionPropertyValue('ast', $ast);
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test storing parsed command line arguments.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_command_line_arguments
     */
    public function testParseEmptySuperGlobalValues(): void
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

        $this->setReflectionPropertyValue('ast', $ast);

        $result = $this->class->parse_command_line_arguments();

        $this->assertEquals([ 'f' => [ 'value1' ], 'g' => [ 'value2' ] ], $result);
    }

}

?>
