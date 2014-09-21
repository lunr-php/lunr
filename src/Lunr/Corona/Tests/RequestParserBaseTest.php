<?php

/**
 * This file contains the RequestParserBaseTest class.
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
 * @covers        Lunr\Corona\RequestParser
 * @backupGlobals enabled
 */
class RequestParserBaseTest extends RequestParserTest
{

    /**
     * Test that the configuration class is set correctly.
     */
    public function testConfigurationSetCorrectly()
    {
        $this->assertPropertySame('config', $this->configuration);
    }

    /**
     * Test storing no post values.
     *
     * @covers Lunr\Corona\RequestParser::parse_post
     */
    public function testParsingNoPostValues()
    {
        $this->assertArrayEmpty($this->class->parse_post());
    }

    /**
     * Test storing no files values.
     *
     * @covers Lunr\Corona\RequestParser::parse_files
     */
    public function testParsingNoFiles()
    {
        $this->assertArrayEmpty($this->class->parse_files());
    }

    /**
     * Test storing no get values.
     *
     * @covers Lunr\Corona\RequestParser::parse_get
     */
    public function testParsingNoGet()
    {
        $this->assertArrayEmpty($this->class->parse_get());
    }

    /**
     * Test storing no cookie values.
     *
     * @covers Lunr\Corona\RequestParser::parse_cookie
     */
    public function testParsingNoCookie()
    {
        $this->assertArrayEmpty($this->class->parse_cookie());
    }

    /**
     * Test storing no command line arguments.
     *
     * @covers Lunr\Corona\RequestParser::parse_command_line_arguments
     */
    public function testParsingNoCommandLineArguments()
    {
        $this->assertArrayEmpty($this->class->parse_command_line_arguments());
    }

    /**
     * Test that parse_accept_format() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_format
     */
    public function testParseAcceptFormatReturnsNull()
    {
        $this->assertNull($this->class->parse_accept_format());
    }

    /**
     * Test that parse_accept_language() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_language
     */
    public function testParseAcceptLanguageReturnsNull()
    {
        $this->assertNull($this->class->parse_accept_language());
    }

    /**
     * Test that parse_accept_charset() returns NULL.
     *
     * @covers Lunr\Corona\RequestParser::parse_accept_charset
     */
    public function testParseAcceptCharsetReturnsNull()
    {
        $this->assertNull($this->class->parse_accept_charset());
    }

}

?>
