<?php

/**
 * This file contains the RequestParserBaseTest class.
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
 * @covers        Lunr\Corona\RequestParser
 * @backupGlobals enabled
 */
class RequestParserBaseTest extends RequestParserTest
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
        $this->mock_function('file_get_contents', 'return "raw";');

        $result = $this->class->parse_raw_data();

        $this->assertEquals('raw', $result);

        $this->unmock_function('file_get_contents');
    }

}

?>
