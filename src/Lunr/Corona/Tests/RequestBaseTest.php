<?php

/**
 * This file contains the RequestBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
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
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
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
        $this->assertArrayEmpty($this->get_reflection_property_value('post'));
    }

    /**
     * Check that get is empty if $_GET is empty.
     */
    public function testGetEmpty()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('get'));
    }

    /**
     * Check that files is empty if $_FILES is empty.
     */
    public function testFilesEmpty()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('files'));
    }

    /**
     * Check that cookie is empty if $_COOKIE is empty.
     */
    public function testCookieEmpty()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('cookie'));
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
        $request = $this->get_reflection_property_value('request');

        $this->assertArrayHasKey($key, $request);
        $this->assertEquals($value, $request[$key]);
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
        $this->assertNull($this->class->get_get_data($key));
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
        $this->assertNull($this->class->get_post_data($key));
    }

    /**
     * Test getting FILE data when $_FILES is empty.
     *
     * @param String $key key for a POST value
     *
     * @depends      testFilesEmpty
     * @dataProvider invalidKeyProvider
     * @covers       Lunr\Corona\Request::get_files_data
     */
    public function testGetFilesDataWhenPostEmpty($key)
    {
        $this->assertNull($this->class->get_files_data($key));
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
        $this->assertNull($this->class->get_cookie_data($key));
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
        $this->assertEquals($value, $this->class->$key);
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
        $this->assertNull($this->class->$key);
    }

}

?>
