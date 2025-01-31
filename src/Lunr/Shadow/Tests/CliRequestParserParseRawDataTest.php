<?php

/**
 * This file contains the CliRequestParserParseRawDataTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
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
class CliRequestParserParseRawDataTest extends CliRequestParserTestCase
{

    /**
     * Test storing raw request data.
     *
     * @covers   Lunr\Shadow\CliRequestParser::parse_raw_data
     */
    public function testParseRawData(): void
    {
        $this->mockFunction('file_get_contents', fn() => 'raw');

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmockFunction('file_get_contents');
    }

}

?>
