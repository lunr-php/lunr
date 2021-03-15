<?php

/**
 * This file contains the CliRequestParserParseRawDataTest class.
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseRawDataTest extends CliRequestParserTest
{

    /**
     * Test storing raw request data.
     *
     * @covers   Lunr\Shadow\CliRequestParser::parse_raw_data
     */
    public function testParseRawData(): void
    {
        $this->mock_function('file_get_contents', function (){return 'raw';});

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmock_function('file_get_contents');
    }

}

?>
