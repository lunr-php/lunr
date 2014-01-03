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
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @covers     Lunr\Shadow\CliRequest
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

}

?>
