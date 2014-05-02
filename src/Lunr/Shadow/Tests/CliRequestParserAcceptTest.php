<?php

/**
 * This file contains the CliRequestParserAcceptTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Shadow
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserAcceptTest extends CliRequestParserTest
{

    /**
     * Test that parse_accept_format() returns content type when called with a valid set of supported formats.
     *
     * @param String $value the expected value
     *
     * @dataProvider contentTypeProvider
     * @requires     extension runkit
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString($value)
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-format'] = [ 'text/plain,text/html' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_content_type', 'return "text/html";');

        $this->assertEquals($value, $this->class->parse_accept_format($value));

        $this->unmock_function('http_negotiate_content_type');
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported formats.
     *
     * @requires extension runkit
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-format'] = [ 'text/plain,text/html' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_content_type', 'return NULL;');

        $this->assertNull($this->class->parse_accept_format([]));

        $this->unmock_function('http_negotiate_content_type');
    }

    /**
     * Test that parse_accept_language() returns content type when called with a valid set of supported languages.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptLanguageProvider
     * @requires     extension runkit
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString($value)
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-language'] = [ 'de-DE,en-US' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_language', 'return "en-US";');

        $this->assertEquals($value, $this->class->parse_accept_language($value));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported languages.
     *
     * @requires extension runkit
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-language'] = [ 'de-DE,en-US' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_language', 'return NULL;');

        $this->assertNull($this->class->parse_accept_language([]));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that parse_accept_encoding() returns content type when called with a valid set of supported charsets.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @requires     extension runkit
     * @requires     extension http
     * @covers       Lunr\Shadow\CliRequestParser::parse_accept_encoding
     */
    public function testGetAcceptEncodingWithValidSupportedCharsetsReturnsString($value)
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-encoding'] = [ 'iso8859,utf-8' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_charset', 'return "utf-8";');

        $this->assertEquals($value, $this->class->parse_accept_encoding($value));

        $this->unmock_function('http_negotiate_charset');
    }

    /**
     * Test that parse_accept_encoding() returns null when called with an empty set of supported charsets.
     *
     * @requires extension runkit
     * @requires extension http
     * @covers   Lunr\Shadow\CliRequestParser::parse_accept_encoding
     */
    public function testGetAcceptEncodingWithEmptySupportedCharsetsReturnsNull()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['accept-encoding'] = [ 'iso8859,utf-8' ];

        $property->setValue($this->class, $ast);

        $this->mock_function('http_negotiate_charset', 'return NULL;');

        $this->assertNull($this->class->parse_accept_encoding([]));

        $this->unmock_function('http_negotiate_charset');
    }

}

?>
