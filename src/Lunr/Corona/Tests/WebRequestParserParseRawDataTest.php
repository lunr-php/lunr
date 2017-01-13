<?php

/**
 * This file contains the WebRequestParserParseRawDataTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseRawDataTest extends WebRequestParserTest
{

    /**
     * Test storing raw request data.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\WebRequestParser::parse_raw_data
     */
    public function testParseRawData()
    {
        $this->mock_function('file_get_contents', 'return "raw";');

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmock_function('file_get_contents');
    }

}

?>
