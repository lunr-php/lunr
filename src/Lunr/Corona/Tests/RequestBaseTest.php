<?php

/**
 * This file contains the RequestBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\Request
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
    public function testPostEmpty()
    {
        $post = $this->reflection_request->getProperty('post');
        $post->setAccessible(TRUE);
        $this->assertEmpty($post->getValue($this->request));
    }

    /**
     * Check that get is empty if $_GET is empty.
     */
    public function testGetEmpty()
    {
        $get = $this->reflection_request->getProperty('get');
        $get->setAccessible(TRUE);
        $this->assertEmpty($get->getValue($this->request));
    }

    /**
     * Check that cookie is empty if $_COOKIE is empty.
     */
    public function testCookieEmpty()
    {
        $cookie = $this->reflection_request->getProperty('cookie');
        $cookie->setAccessible(TRUE);
        $this->assertEmpty($cookie->getValue($this->request));
    }

    /**
     * Check that json_enums is empty by default.
     */
    public function testJsonEnumsEmpty()
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
    public function testRequestDefaultValues($key, $value)
    {
        $request = $this->reflection_request->getProperty('request');
        $request->setAccessible(TRUE);
        $request = $request->getValue($this->request);
        $this->assertEquals($value, $request[$key]);
    }

    /**
     * Test that the hostname is stored correctly in the constructor.
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     */
    public function testHostnameIsSet()
    {
        $request = $this->reflection_request->getProperty('request');
        $request->setAccessible(TRUE);
        $request = $request->getValue($this->request);
        $this->assertEquals('Lunr', $request['host']);
    }

    /**
     * Test setting json enums.
     *
     * @depends testJsonEnumsEmpty
     * @covers  Lunr\Corona\Request::set_json_enums
     */
    public function testSetJsonEnums()
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
     * @depends      testGetEmpty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Corona\Request::get_get_data
     */
    public function testGetGetDataWhenGetEmpty($key)
    {
        $this->assertNull($this->request->get_get_data($key));
    }

    /**
     * Test getting POST data when $_POST is empty.
     *
     * @param String $key key for a POST value
     *
     * @depends      testPostEmpty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Corona\Request::get_post_data
     */
    public function testGetPostDataWhenPostEmpty($key)
    {
        $this->assertNull($this->request->get_post_data($key));
    }

    /**
     * Test getting COOKIE data when $_COOKIE is empty.
     *
     * @param String $key key for a COOKIE value
     *
     * @depends      testCookieEmpty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Corona\Request::get_cookie_data
     */
    public function testGetCookieDataWhenCookieEmpty($key)
    {
        $this->assertNull($this->request->get_cookie_data($key));
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @depends      testRequestDefaultValues
     * @dataProvider requestValueProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetMethodWhenGetEmpty($key, $value)
    {
        $this->assertEquals($value, $this->request->$key);
    }

    /**
     * Test that __get() returns NULL for unhandled keys.
     *
     * @param String $key key for __get()
     *
     * @dataProvider unhandledMagicGetKeysProvider
     * @covers       Lunr\Corona\Request::__get
     */
    public function testMagicGetIsNullForUnhandledKeys($key)
    {
        $this->assertNull($this->request->$key);
    }

}

?>
