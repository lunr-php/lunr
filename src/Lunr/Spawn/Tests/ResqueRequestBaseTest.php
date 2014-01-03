<?php

/**
 * This file contains the ResqueRequestBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spawn\ResqueRequest
 */
class ResqueRequestBaseTest extends ResqueRequestTest
{

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
     * @covers Lunr\Spawn\ResqueRequest::get_get_data
     */
    public function testGetGetDataReturnsNull()
    {
        $this->assertNull($this->class->get_get_data('invalid'));
    }

    /**
     * Test getting POST data when $_POST is empty.
     *
     * @covers Lunr\Spawn\ResqueRequest::get_post_data
     */
    public function testGetPostDataReturnsNull()
    {
        $this->assertNull($this->class->get_post_data('invalid'));
    }

    /**
     * Test getting FILE data when $_FILES is empty.
     *
     * @covers Lunr\Spawn\ResqueRequest::get_files_data
     */
    public function testGetFilesDataReturnsNull()
    {
        $this->assertNull($this->class->get_files_data('invalid'));
    }

    /**
     * Test getting COOKIE data when $_COOKIE is empty.
     *
     * @covers Lunr\Spawn\ResqueRequest::get_cookie_data
     */
    public function testGetCookieDataReturnsNull()
    {
        $this->assertNull($this->class->get_cookie_data('invalid'));
    }

    /**
     * Check that request values are returned correctly by the magic get method.
     *
     * @param String $key   key for a request value
     * @param mixed  $value value of a request value
     *
     * @depends      testRequestDefaultValues
     * @dataProvider requestValueProvider
     * @covers       Lunr\Spawn\ResqueRequest::__get
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
     * @covers       Lunr\Spawn\ResqueRequest::__get
     */
    public function testMagicGetIsNullForUnhandledKeys($key)
    {
        $this->assertNull($this->class->$key);
    }

    /**
     * Tests that get_new_inter_request_object returns an InterRequest object.
     *
     * @covers Lunr\Spawn\ResqueRequest::get_new_inter_request_object
     */
    public function testGetNewInterRequestObject()
    {
        $value = $this->class->get_new_inter_request_object(array());

        $this->assertInstanceOf('Lunr\Corona\InterRequest', $value);
    }

    /**
     * Test that set_job_name() sets the request method.
     *
     * @covers Lunr\Spawn\ResqueRequest::set_job_name
     */
    public function testSetJobNameSetsRequestMethod()
    {
        $this->class->set_job_name('job');

        $this->assertEquals('job', $this->get_reflection_property_value('request')['method']);
    }

    /**
     * Test that set_job_name() sets the call.
     *
     * @covers Lunr\Spawn\ResqueRequest::set_job_name
     */
    public function testSetJobNameSetsCall()
    {
        $this->class->set_job_name('job');

        $this->assertEquals('resque/job', $this->get_reflection_property_value('request')['call']);
    }

}

?>
