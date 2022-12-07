<?php

/**
 * This file contains the WebRequestParserAcceptTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @author    Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright 2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserAcceptTest extends WebRequestParserTest
{

    /**
     * Test that parse_accept_format() returns content type when called with a valid set of supported formats.
     *
     * @param string $value The expected value
     *
     * @dataProvider contentTypeProvider
     * @requires     extension http
     * @requires     function http\Header::negotiate
     * @covers       Lunr\Corona\WebRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString($value): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT'] = 'accept_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($value)
                     ->willReturn('text/html');

        $this->assertEquals($value, $this->class->parse_accept_format($value));

        $this->assertSame('Accept', $this->header->name);
        $this->assertSame('accept_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported formats.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT'] = 'accept_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with([])
                     ->willReturn(NULL);

        $this->assertNull($this->class->parse_accept_format([]));

        $this->assertSame('Accept', $this->header->name);
        $this->assertSame('accept_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called without a set of supported formats.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_format
     */
    public function testGetAcceptFormatWithoutSupportedFormatsReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        unset($_SERVER['HTTP_ACCEPT']);

        $this->header->expects($this->never())
                     ->method('negotiate')
                     ->with([]);

        $this->assertNull($this->class->parse_accept_format([]));

        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);
    }

    /**
     * Test that parse_accept_language() returns content type when called with a valid set of supported languages.
     *
     * @param string $value The expected value
     *
     * @dataProvider acceptLanguageProvider
     * @requires     extension http
     * @requires     function http\Header::negotiate
     * @covers       Lunr\Corona\WebRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString($value): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'accept_language_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($value)
                     ->willReturn('en-US');

        $this->assertEquals($value, $this->class->parse_accept_language($value));

        $this->assertSame('Accept-Language', $this->header->name);
        $this->assertSame('accept_language_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called with an empty set of supported languages.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'accept_language_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with([])
                     ->willReturn(NULL);

        $this->assertNull($this->class->parse_accept_language([]));

        $this->assertSame('Accept-Language', $this->header->name);
        $this->assertSame('accept_language_value', $this->header->value);
    }

    /**
     * Test that parse_accept_format() returns null when called without a set of supported languages.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_language
     */
    public function testGetAcceptLanguageWithoutSupportedLanguagesReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        unset($_SERVER['HTTP_ACCEPT_LANGUAGE']);

        $this->header->expects($this->never())
                     ->method('negotiate')
                     ->with([]);

        $this->assertNull($this->class->parse_accept_language([]));

        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);
    }

    /**
     * Test that parse_accept_charset() returns content type when called with a valid set of supported charsets.
     *
     * @param string $value The expected value
     *
     * @dataProvider acceptCharsetProvider
     * @requires     extension http
     * @requires     function http\Header::negotiate
     * @covers       Lunr\Corona\WebRequestParser::parse_accept_charset
     */
    public function testGetAcceptCharsetWithValidSupportedCharsetsReturnsString($value): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT_CHARSET'] = 'accept_charset_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with($value)
                     ->willReturn('utf-8');

        $this->assertEquals($value, $this->class->parse_accept_charset($value));

        $this->assertSame('Accept-Charset', $this->header->name);
        $this->assertSame('accept_charset_value', $this->header->value);
    }

    /**
     * Test that parse_accept_charset() returns null when called with an empty set of supported charsets.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_charset
     */
    public function testGetAcceptCharsetWithEmptySupportedCharsetsReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        $_SERVER['HTTP_ACCEPT_CHARSET'] = 'accept_charset_value';

        $this->header->expects($this->once())
                     ->method('negotiate')
                     ->with([])
                     ->willReturn(NULL);

        $this->assertNull($this->class->parse_accept_charset([]));

        $this->assertSame('Accept-Charset', $this->header->name);
        $this->assertSame('accept_charset_value', $this->header->value);
    }

    /**
     * Test that parse_accept_charset() returns null when called without a set of supported charsets.
     *
     * @requires extension http
     * @requires function http\Header::negotiate
     * @covers   Lunr\Corona\WebRequestParser::parse_accept_charset
     */
    public function testGetAcceptCharsetWithoutSupportedCharsetsReturnsNull(): void
    {
        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);

        unset($_SERVER['HTTP_ACCEPT_CHARSET']);

        $this->header->expects($this->never())
                     ->method('negotiate')
                     ->with([]);

        $this->assertNull($this->class->parse_accept_charset([]));

        $this->assertNull($this->header->name);
        $this->assertNull($this->header->value);
    }

}

?>
