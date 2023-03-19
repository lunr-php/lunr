<?php

/**
 * This file contains the WebRequestParserParseCommandLineArgumentsTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
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
