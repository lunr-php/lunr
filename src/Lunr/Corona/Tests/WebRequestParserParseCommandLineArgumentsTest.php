<?php

/**
 * This file contains the WebRequestParserParseCommandLineArgumentsTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
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
    public function testParsingNoCommandLineArguments()
    {
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

}

?>
