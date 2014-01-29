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
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestGetTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpFilled();
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @dataProvider properRequestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetMethod($key, $value)
    {
        $this->assertEquals($value, $this->class->$key);
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_get_data
     */
    public function testGetGetData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_get_data($key));
    }

    /**
     * Test getting POST data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_post_data
     */
    public function testGetPostData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_post_data($key));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::get_files_data
     */
    public function testGetFileData()
    {
        $value = [
            'image' => [
                'name' => 'Name',
                'type' => 'Type',
                'tmp_name' => 'Tmp',
                'error' => 'Error',
                'size' => 'Size'
            ]
        ];

        $this->assertEquals($value['image'], $this->class->get_files_data('image'));
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Corona\Request::get_cookie_data
     */
    public function testGetCookieData($value, $key)
    {
        $this->assertEquals($value, $this->class->get_cookie_data($key));
    }

    /**
     * Tests that get_new_inter_request_object returns an InterRequest object.
     *
     * @covers Lunr\Corona\Request::get_new_inter_request_object
     */
    public function testGetNewInterRequestObject()
    {
        $value = $this->class->get_new_inter_request_object(array());

        $this->assertInstanceOf('Lunr\Corona\InterRequest', $value);
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
        $this->mock_function('http_negotiate_content_type', 'return "text/html";');

        $this->assertEquals($value, $this->class->get_accept_format($value));

        $this->unmock_function('http_negotiate_content_type');
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported formats.
     *
     * @covers Lunr\Corona\Request::get_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull()
    {
        $this->mock_function('http_negotiate_content_type', 'return NULL;');

        $this->assertNull($this->class->get_accept_format([]));

        $this->unmock_function('http_negotiate_content_type');
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
        $this->mock_function('http_negotiate_language', 'return "en-US";');

        $this->assertEquals($value, $this->class->get_accept_language($value));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported languages.
     *
     * @covers Lunr\Corona\Request::get_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull()
    {
        $this->mock_function('http_negotiate_language', 'return NULL;');

        $this->assertNull($this->class->get_accept_language([]));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that get_accept_encoding() returns content type when called with a valid set of supported charsets.
     *
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @covers       Lunr\Corona\Request::get_accept_encoding
     */
    public function testGetAcceptEncodingWithValidSupportedCharsetsReturnsString($value)
    {
        $this->mock_function('http_negotiate_charset', 'return "utf-8";');

        $this->assertEquals($value, $this->class->get_accept_encoding($value));

        $this->unmock_function('http_negotiate_charset');
    }

    /**
     * Test that get_accept_encoding() returns null when called with an empty set of supported charsets.
     *
     * @covers Lunr\Corona\Request::get_accept_encoding
     */
    public function testGetAcceptEncodingWithEmptySupportedCharsetsReturnsNull()
    {
        $this->mock_function('http_negotiate_charset', 'return NULL;');

        $this->assertNull($this->class->get_accept_encoding([]));

        $this->unmock_function('http_negotiate_charset');
    }

}

?>
