<?php

/**
 * This file contains the RequestParserBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\RequestParser
 * @backupGlobals enabled
 */
class RequestParserBaseTest extends RequestParserTestCase
{

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly(): void
    {
        $this->assertPropertySame('config', $this->configuration);
    }

    /**
     * Test storing no post values.
     *
     * @covers Lunr\Corona\RequestParser::parse_post
     */
    public function testParsingNoPostValues(): void
    {
        $this->assertArrayEmpty($this->class->parse_post());
    }

    /**
     * Test storing no server values.
     *
     * @covers Lunr\Corona\RequestParser::parse_server
     */
    public function testParsingNoServerValues(): void
    {
        $this->assertArrayEmpty($this->class->parse_server());
    }

    /**
     * Test storing no files values.
     *
     * @covers Lunr\Corona\RequestParser::parse_files
     */
    public function testParsingNoFiles(): void
    {
        $this->assertArrayEmpty($this->class->parse_files());
    }

    /**
     * Test storing no get values.
     *
     * @covers Lunr\Corona\RequestParser::parse_get
     */
    public function testParsingNoGet(): void
    {
        $this->assertArrayEmpty($this->class->parse_get());
    }

    /**
     * Test storing no cookie values.
     *
     * @covers Lunr\Corona\RequestParser::parse_cookie
     */
    public function testParsingNoCookie(): void
    {
        $this->assertArrayEmpty($this->class->parse_cookie());
    }

    /**
     * Test storing no command line arguments.
     *
     * @covers Lunr\Corona\RequestParser::parse_command_line_arguments
     */
    public function testParsingNoCommandLineArguments(): void
    {
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test that parse_accept_format() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_format
     */
    public function testParseAcceptFormatReturnsNull(): void
    {
        $this->assertNull($this->class->parse_accept_format());
    }

    /**
     * Test that parse_accept_language() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_language
     */
    public function testParseAcceptLanguageReturnsNull(): void
    {
        $this->assertNull($this->class->parse_accept_language());
    }

    /**
     * Test that parse_accept_charset() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_charset
     */
    public function testParseAcceptCharsetReturnsNull(): void
    {
        $this->assertNull($this->class->parse_accept_charset());
    }

    /**
     * Test storing raw request data.
     *
     * @covers   Lunr\Corona\RequestParser::parse_raw_data
     */
    public function testParseRawData(): void
    {
        $this->mockFunction('file_get_contents', function () { return 'raw'; });

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmockFunction('file_get_contents');
    }

}

?>
