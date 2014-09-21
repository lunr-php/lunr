<?php

/**
 * This file contains the RequestGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Corona\Request
 */
class RequestGetTest extends RequestTest
{

    /**
     * Test getting GET data.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetData()
    {
        $this->assertEquals('get_value', $this->class->get_get_data('get_key'));
    }

    /**
     * Test getting POST data.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostData()
    {
        $this->assertEquals('post_value', $this->class->get_post_data('post_key'));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::get_files_data
     */
    public function testGetFileData()
    {
        $this->assertEquals($this->files['image'], $this->class->get_files_data('image'));
    }

    /**
     * Test getting COOKIE data.
     *
     * @covers Lunr\Corona\Request::get_cookie_data
     */
    public function testGetCookieData()
    {
        $this->assertEquals('cookie_value', $this->class->get_cookie_data('cookie_key'));
    }

    /**
     * Tests that get_all_options() returns the ast property.
     *
     * @param array $keys The array of keys to test
     *
     * @dataProvider cliArgsKeyProvider
     * @covers       Lunr\Corona\Request::get_all_options
     */
    public function testGetAllOptionsReturnsArray($keys)
    {
        $values = array();
        for ($i = 0; $i < sizeof($keys); $i++)
        {
            $values[] = 'value';
        }

        $this->set_reflection_property_value('cli_args', array_combine($keys, $values));

        $return = $this->class->get_all_options();

        $this->assertEquals($keys, $return);
    }

    /**
     * Tests that get_option_data() returns a value for a proper key.
     *
     * @param array $value The expected value to test
     *
     * @dataProvider validCliArgsValueProvider
     * @covers       Lunr\Corona\Request::get_option_data
     */
    public function testGetOptionDataReturnsValueForValidKey($value)
    {
        $this->set_reflection_property_value('cli_args', [ 'a' => $value ]);

        $result = $this->class->get_option_data('a');

        $this->assertEquals($value, $result);
    }

    /**
     * Tests that get_option_data() returns NULL for invalid key.
     *
     * @covers Lunr\Corona\Request::get_option_data
     */
    public function testGetOptionDataReturnsNullForInvalidKey()
    {
        $ast = $this->get_reflection_property_value('cli_args');

        $this->assertArrayNotHasKey('foo', $ast);
        $this->assertNull($this->class->get_option_data('foo'));
    }

    /**
     * Test that get_accept_format() returns content type when called with a valid set of supported formats.
     *
     * @param String $value the expected value
     *
     * @dataProvider contentTypeProvider
     * @covers       Lunr\Corona\Request::get_accept_format
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString($value)
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_format')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('text/html'));

        $this->assertEquals($value, $this->class->get_accept_format($value));
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported formats.
     *
     * @covers Lunr\Corona\Request::get_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull()
    {
        $this->assertNull($this->class->get_accept_format([]));
    }

    /**
     * Test that get_accept_language() returns content type when called with a valid set of supported languages.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptLanguageProvider
     * @covers       Lunr\Corona\Request::get_accept_language
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString($value)
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_language')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('en-US'));

        $this->assertEquals($value, $this->class->get_accept_language($value));
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported languages.
     *
     * @covers Lunr\Corona\Request::get_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull()
    {
        $this->assertNull($this->class->get_accept_language([]));
    }

    /**
     * Test that get_accept_charset() returns content type when called with a valid set of supported charsets.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @covers       Lunr\Corona\Request::get_accept_charset
     */
    public function testGetAcceptCharsetWithValidSupportedCharsetsReturnsString($value)
    {
        $this->parser->expects($this->once())
                     ->method('parse_accept_charset')
                     ->with($this->equalTo($value))
                     ->will($this->returnValue('utf-8'));

        $this->assertEquals($value, $this->class->get_accept_charset($value));
    }

    /**
     * Test that get_accept_charset() returns null when called with an empty set of supported charsets.
     *
     * @covers Lunr\Corona\Request::get_accept_charset
     */
    public function testGetAcceptCharsetWithEmptySupportedCharsetsReturnsNull()
    {
        $this->assertNull($this->class->get_accept_charset([]));
    }

}

?>
