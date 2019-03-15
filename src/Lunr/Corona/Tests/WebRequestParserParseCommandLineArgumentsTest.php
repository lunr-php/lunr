<?php

/**
 * This file contains the WebRequestParserParseCommandLineArgumentsTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseCommandLineArgumentsTest extends WebRequestParserTest
{

    /**
     * Test storing no command line arguments.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_command_line_arguments
     */
    public function testParsingNoCommandLineArguments(): void
    {
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

}

?>
