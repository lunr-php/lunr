<?php

/**
 * This file contains the RequestBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use \ReflectionClass;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Request
 */
class RequestBaseTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Check that post is empty if $_POST is empty.
     */
    public function test_post_empty()
    {
        $post = $this->reflection_request->getProperty('post');
        $post->setAccessible(TRUE);
        $this->assertEmpty($post->getValue($this->request));
    }

    /**
     * Check that get is empty if $_GET is empty.
     */
    public function test_get_empty()
    {
        $get = $this->reflection_request->getProperty('get');
        $get->setAccessible(TRUE);
        $this->assertEmpty($get->getValue($this->request));
    }

    /**
     * Check that cookie is empty if $_COOKIE is empty.
     */
    public function test_cookie_empty()
    {
        $cookie = $this->reflection_request->getProperty('cookie');
        $cookie->setAccessible(TRUE);
        $this->assertEmpty($cookie->getValue($this->request));
    }

    /**
     * Check that json_enums is empty by default.
     */
    public function test_json_enums_empty()
    {
        $json_enums = $this->reflection_request->getProperty('json_enums');
        $json_enums->setAccessible(TRUE);
        $this->assertEmpty($json_enums->getValue($this->request));
    }

    /**
     * Check that request is filled with sane default values.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @dataProvider requestValueProvider
     */
    public function test_request_default_values($key, $value)
    {
        $request = $this->reflection_request->getProperty('request');
        $request->setAccessible(TRUE);
        $request = $request->getValue($this->request);
        $this->assertEquals($value, $request[$key]);
    }

    /**
     * Test setting json enums.
     *
     * @depends test_json_enums_empty
     * @covers  Lunr\Libraries\Core\Request::set_json_enums
     */
    public function test_set_json_enums()
    {
        $JSON = $this->get_json_enums();
        $this->request->set_json_enums($JSON);
        $json_enums = $this->reflection_request->getProperty('json_enums');
        $json_enums->setAccessible(TRUE);
        $this->assertEquals($JSON, $json_enums->getValue($this->request));
        $this->assertSame($JSON, $json_enums->getValue($this->request));
    }

    /**
     * Test getting GET data when $_GET is empty.
     *
     * @param String $key key for a GET value
     *
     * @depends      test_get_empty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Libraries\Core\Request::get_get_data
     */
    public function test_get_get_data_when_get_empty($key)
    {
        $this->assertNull($this->request->get_get_data($key));
    }

    /**
     * Test getting POST data when $_POST is empty.
     *
     * @param String $key key for a POST value
     *
     * @depends      test_post_empty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Libraries\Core\Request::get_post_data
     */
    public function test_get_post_data_when_get_empty($key)
    {
        $this->assertNull($this->request->get_post_data($key));
    }

    /**
     * Test getting COOKIE data when $_COOKIE is empty.
     *
     * @param String $key key for a COOKIE value
     *
     * @depends      test_cookie_empty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Libraries\Core\Request::get_cookie_data
     */
    public function test_get_cookie_data_when_get_empty($key)
    {
        $this->assertNull($this->request->get_cookie_data($key));
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @depends      test_request_default_values
     * @dataProvider requestValueProvider
     * @covers       Lunr\Libraries\Core\Request::__get
     */
    public function test_magic_get_method_when_get_empty($key, $value)
    {
        $this->assertEquals($value, $this->request->$key);
    }

    /**
     * Test that __get() returns NULL for unhandled keys.
     *
     * @param String $key key for __get()
     *
     * @dataProvider unhandledMagicGetKeysProvider
     * @covers       Lunr\Libraries\Core\Request::__get
     */
    public function test_magic_get_null_for_unhandled_keys($key)
    {
        $this->assertNull($this->request->$key);
    }

}

?>
