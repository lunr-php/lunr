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
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for requests in Curl class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Network\Curl
 */
class CurlRequestTest extends CurlTest
{

    /**
     * Test that get_request() returns response object on successful request.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnSuccess
     * @covers  Lunr\Network\Curl::get_request
     */
    public function testGetRequestReturnsResponseObjectOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $return = $this->class->get_request('http://localhost/');

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

    /**
     * Test that get_request() returns response object on failed request.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnError
     * @covers  Lunr\Network\Curl::get_request
     */
    public function testGetRequestReturnsResponseObjectOnError()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $return = $this->class->get_request('http://localhost/');

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

    /**
     * Test that post_request() returns response object on successful request.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnSuccess
     * @covers  Lunr\Network\Curl::post_request
     */
    public function testPostRequestReturnsResponseObjectOnSuccess()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $return = $this->class->post_request('http://localhost/', []);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

    /**
     * Test that post_request() returns response object on failed request.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnError
     * @covers  Lunr\Network\Curl::post_request
     */
    public function testPostRequestReturnsResponseObjectOnError()
    {
        runkit_function_redefine('curl_init', '', self::CURL_RETURN_TRUE);
        runkit_function_redefine('curl_setopt_array', '', self::CURL_RETURN_FALSE);
        runkit_function_redefine('curl_exec', '', self::CURL_RETURN_VALUE);
        runkit_function_redefine('curl_errno', '', self::CURL_RETURN_ERRNO);
        runkit_function_redefine('curl_error', '', self::CURL_RETURN_ERRMSG);
        runkit_function_redefine('curl_getinfo', '', self::CURL_RETURN_CODE);
        runkit_function_redefine('curl_close', '', self::CURL_RETURN_TRUE);

        $return = $this->class->post_request('http://localhost/', []);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);
    }

}

?>
