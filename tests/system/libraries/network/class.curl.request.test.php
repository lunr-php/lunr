<?php

/**
 * This file contains the CurlRequestTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Network;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for requests in Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Network\Curl
 */
class CurlRequestTest extends CurlTest
{

    /**
     * Test that get_request() returns FALSE if init() fails.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testInitReturnsFalseOnError
     * @covers  Lunr\Libraries\Network\Curl::get_request
     */
    public function testGetRequestReturnsFalseIfInitFails()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);

        $this->assertFalse($this->curl->get_request('http://localhost/'));
    }

    /**
     * Test that get_request() returns FALSE if execute() fails.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testExecuteReturnsFalseOnError
     * @covers  Lunr\Libraries\Network\Curl::get_request
     */
    public function testGetRequestReturnsFalseIfExecuteFails()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $this->assertFalse($this->curl->get_request('http://localhost/'));
    }

    /**
     * Test that get_request() returns value on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testExecuteReturnsValueOnSuccess
     * @covers  Lunr\Libraries\Network\Curl::get_request
     */
    public function testGetRequestReturnsValueOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_INFO);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $this->assertEquals('value', $this->curl->get_request('http://localhost/'));
    }

    /**
     * Test that post_request() returns FALSE if init() fails.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testInitReturnsFalseOnError
     * @covers  Lunr\Libraries\Network\Curl::post_request
     */
    public function testPostRequestReturnsFalseIfInitFails()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);

        $this->assertFalse($this->curl->post_request('http://localhost/', array()));
    }

    /**
     * Test that post_request() returns FALSE if execute() fails.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testExecuteReturnsFalseOnError
     * @covers  Lunr\Libraries\Network\Curl::post_request
     */
    public function testPostRequestReturnsFalseIfExecuteFails()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $this->assertFalse($this->curl->post_request('http://localhost/', array()));
    }

    /**
     * Test that post_request() returns value on success.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @depends Lunr\Libraries\Network\CurlExecuteTest::testExecuteReturnsValueOnSuccess
     * @covers  Lunr\Libraries\Network\Curl::post_request
     */
    public function testPostRequestReturnsValueOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_INFO);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $this->assertEquals('value', $this->curl->post_request('http://localhost/', array()));
    }

    /**
     * Test that post options are not kept after the request.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\EnvironmentTest::testRunkit
     * @covers  Lunr\Libraries\Network\Curl::get_request
     */
    Public function testPostOptionsAreNotPersistant()
    {
        $property = $this->curl_reflection->getProperty('options');
        $property->setAccessible(TRUE);

        $old = $property->getValue($this->curl);

        $this->assertArrayNotHasKey(CURLOPT_CUSTOMREQUEST, $old);
        $this->assertArrayNotHasKey(CURLOPT_POST, $old);
        $this->assertArrayNotHasKey(CURLOPT_POSTFIELDS, $old);

        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_INFO);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $this->curl->post_request('http://localhost/', array());

        $new = $property->getValue($this->curl);

        $this->assertArrayNotHasKey(CURLOPT_CUSTOMREQUEST, $new);
        $this->assertArrayNotHasKey(CURLOPT_POST, $new);
        $this->assertArrayNotHasKey(CURLOPT_POSTFIELDS, $new);
    }

}

?>
