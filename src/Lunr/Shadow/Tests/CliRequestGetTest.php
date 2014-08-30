<?php

/**
 * This file contains the CliRequestGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for getters of the CliRequest class.
 *
 * @category      Libraries
 * @package       Shadow
 * @subpackage    Tests
 * @author        Olivier Wizen <olivier@m2mobi.com>
 * @covers        Lunr\Shadow\CliRequest
 * @backupGlobals enabled
 */
class CliRequestGetTest extends CliRequestTest
{

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   Key for a request value
     * @param mixed  $value Value of a request value
     *
     * @dataProvider requestValueProvider
     * @covers       Lunr\Shadow\CliRequest::__get
     */
    public function testMagicGetMethod($key, $value)
    {
        $this->assertEquals($value, $this->class->$key);
    }

    /**
     * Test that __get() returns NULL for unhandled keys.
     *
     * @param String $key Key for __get()
     *
     * @dataProvider unhandledMagicGetKeysProvider
     * @covers       Lunr\Shadow\CliRequest::__get
     */
    public function testMagicGetIsNullForUnhandledKeys($key)
    {
        $this->assertNull($this->class->$key);
    }

    /**
     * Tests that get_all_options() returns the ast property.
     *
     * @param array $keys The array of keys to test
     *
     * @dataProvider astKeyProvider
     * @covers       Lunr\Shadow\CliRequest::get_all_options
     */
    public function testGetAllOptionsReturnsArray($keys)
    {
        $values = array();
        for ($i = 0; $i < sizeof($keys); $i++)
        {
            $values[] = 'value';
        }

        $this->set_reflection_property_value('ast', array_combine($keys, $values));

        $return = $this->class->get_all_options();

        $this->assertEquals($keys, $return);
    }

    /**
     * Tests that get_option_data() returns a value for a proper key.
     *
     * @param array $value The expected value to test
     *
     * @dataProvider validAstValueProvider
     * @covers       Lunr\Shadow\CliRequest::get_option_data
     */
    public function testGetOptionDataReturnsValueForValidKey($value)
    {
        $this->set_reflection_property_value('ast', array('a' => $value));

        $result = $this->class->get_option_data('a');

        $this->assertEquals($value, $result);
    }

    /**
     * Tests that get_option_data() returns NULL for invalid key.
     *
     * @covers Lunr\Shadow\CliRequest::get_option_data
     */
    public function testGetOptionDataReturnsNullForInvalidKey()
    {
        $ast = $this->get_reflection_property_value('ast');

        $this->assertArrayNotHasKey('foo', $ast);
        $this->assertNull($this->class->get_option_data('foo'));
    }

    /**
     * Tests that get_get_data() returns NULL for non-existing keys.
     *
     * @covers Lunr\Shadow\CliRequest::get_get_data
     */
    public function testGetGetDataReturnsNullForNonExistingKeys()
    {
        $get = $this->get_reflection_property_value('get');

        $this->assertArrayNotHasKey('foo', $get);
        $this->assertNull($this->class->get_get_data('foo'));
    }

    /**
     * Tests that get_post_data() returns NULL for non-existing keys.
     *
     * @covers Lunr\Shadow\CliRequest::get_post_data
     */
    public function testGetPostDataReturnsNullForNonExistingKeys()
    {
        $post = $this->get_reflection_property_value('post');

        $this->assertArrayNotHasKey('foo', $post);
        $this->assertNull($this->class->get_post_data('foo'));
    }

    /**
     * Tests that get_files_data() returns NULL for non-existing keys.
     *
     * @covers Lunr\Shadow\CliRequest::get_files_data
     */
    public function testGetFilesDataReturnsNullForNonExistingKeys()
    {
        $files = $this->get_reflection_property_value('files');

        $this->assertArrayNotHasKey('foo', $files);
        $this->assertNull($this->class->get_files_data('foo'));
    }

    /**
     * Tests that get_cookie_data() returns NULL for non-existing keys.
     *
     * @covers Lunr\Shadow\CliRequest::get_cookie_data
     */
    public function testGetCookieDataReturnsNullForNonExistingKeys()
    {
        $cookie = $this->get_reflection_property_value('cookie');

        $this->assertArrayNotHasKey('foo', $cookie);
        $this->assertNull($this->class->get_cookie_data('foo'));
    }

    /**
     * Tests that get_new_inter_request_object returns an InterRequest object.
     *
     * @covers Lunr\Shadow\CliRequest::get_new_inter_request_object
     */
    public function testGetNewInterRequestObject()
    {
        $value = $this->class->get_new_inter_request_object(array());

        $this->assertInstanceOf('Lunr\Corona\InterRequest', $value);
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Shadow\CliRequest::get_get_data
     */
    public function testGetGetData($value, $key)
    {
        $this->set_reflection_property_value('get', [ $key => $value ]);
        $this->assertSame($value, $this->class->get_get_data($key));
    }

    /**
     * Test getting POST data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Shadow\CliRequest::get_post_data
     */
    public function testGetPostData($value, $key)
    {
        $this->set_reflection_property_value('post', [ $key => $value ]);
        $this->assertSame($value, $this->class->get_post_data($key));
    }

    /**
     * Test getting GET data.
     *
     * @param String $value the expected value
     * @param String $key   key for a GET value
     *
     * @dataProvider validJsonEnumProvider
     * @covers       Lunr\Shadow\CliRequest::get_cookie_data
     */
    public function testGetCookieData($value, $key)
    {
        $this->set_reflection_property_value('cookie', [ $key => $value ]);
        $this->assertSame($value, $this->class->get_cookie_data($key));
    }

    /**
     * Test that get_accept_format() returns content type when called with a valid set of supported formats.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider contentTypeProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_content_type
     * @covers       Lunr\Shadow\CliRequest::get_accept_format
     */
    public function testGetAcceptFormatWithValidSupportedFormatsReturnsString($key, $value)
    {
        $this->mock_function('http_negotiate_content_type', 'return "text/html";');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertEquals($value, $this->class->get_accept_format($value));

        $this->unmock_function('http_negotiate_content_type');
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported formats.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider contentTypeProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_content_type
     * @covers       Lunr\Shadow\CliRequest::get_accept_format
     */
    public function testGetAcceptFormatWithEmptySupportedFormatsReturnsNull($key, $value)
    {
        $this->mock_function('http_negotiate_content_type', 'return NULL;');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertNull($this->class->get_accept_format([]));

        $this->unmock_function('http_negotiate_content_type');
    }

    /**
     * Test that get_accept_language() returns content type when called with a valid set of supported languages.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider acceptLanguageProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_language
     * @covers       Lunr\Shadow\CliRequest::get_accept_language
     */
    public function testGetAcceptLanguageWithValidSupportedLanguagesReturnsString($key, $value)
    {
        $this->mock_function('http_negotiate_language', 'return "en-US";');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertEquals($value, $this->class->get_accept_language($value));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that get_accept_format() returns null when called with an empty set of supported languages.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider acceptLanguageProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_language
     * @covers       Lunr\Shadow\CliRequest::get_accept_language
     */
    public function testGetAcceptLanguageWithEmptySupportedLanguagesReturnsNull($key, $value)
    {
        $this->mock_function('http_negotiate_language', 'return NULL;');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertNull($this->class->get_accept_language([]));

        $this->unmock_function('http_negotiate_language');
    }

    /**
     * Test that get_accept_encoding() returns content type when called with a valid set of supported charsets.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_charset
     * @covers       Lunr\Shadow\CliRequest::get_accept_encoding
     */
    public function testGetAcceptEncodingWithValidSupportedCharsetsReturnsString($key, $value)
    {
        $this->mock_function('http_negotiate_charset', 'return "utf-8";');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertEquals($value, $this->class->get_accept_encoding($value));

        $this->unmock_function('http_negotiate_charset');
    }

    /**
     * Test that get_accept_encoding() returns null when called with an empty set of supported charsets.
     *
     * @param String $key   the expected key in ast
     * @param String $value the expected value
     *
     * @dataProvider acceptCharsetProvider
     * @requires     extension http
     * @requires     extension runkit
     * @requires     function http_negotiate_charset
     * @covers       Lunr\Shadow\CliRequest::get_accept_encoding
     */
    public function testGetAcceptEncodingWithEmptySupportedCharsetsReturnsNull($key, $value)
    {
        $this->mock_function('http_negotiate_charset', 'return NULL;');

        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->assertNull($this->class->get_accept_encoding([]));

        $this->unmock_function('http_negotiate_charset');
    }

}

?>
