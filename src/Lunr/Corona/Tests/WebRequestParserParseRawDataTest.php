<?php

/**
 * This file contains the WebRequestParserParseRawDataTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
     * @covers   Lunr\Corona\WebRequestParser::parse_raw_data
     */
    public function testParseRawData(): void
    {
        $this->mock_function('file_get_contents', fn() => 'raw');

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmock_function('file_get_contents');
    }

}

?>
