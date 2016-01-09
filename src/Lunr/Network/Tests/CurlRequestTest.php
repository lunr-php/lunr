<?php

/**
 * This file contains the CurlRequestTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Network
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network\Tests;

use Lunr\Network\Curl;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for requests in Curl class.
 *
 * @covers Lunr\Network\Curl
 */
class CurlRequestTest extends CurlTest
{

    /**
     * Test that get_request() returns response object on successful request.
     *
     * @depends  Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnSuccess
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::get_request
     */
    public function testGetRequestReturnsResponseObjectOnSuccess()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $return = $this->class->get_request('http://localhost/');

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that get_request() returns response object on failed request.
     *
     * @depends  Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnError
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::get_request
     */
    public function testGetRequestReturnsResponseObjectOnError()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_FALSE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $return = $this->class->get_request('http://localhost/');

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that post_request() returns response object on successful request.
     *
     * @depends  Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnSuccess
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::post_request
     */
    public function testPostRequestReturnsResponseObjectOnSuccess()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $return = $this->class->post_request('http://localhost/', []);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

    /**
     * Test that post_request() returns response object on failed request.
     *
     * @depends  Lunr\Network\Tests\CurlExecuteTest::testExecuteReturnsResponseObjectOnError
     * @requires extension runkit
     * @covers   Lunr\Network\Curl::post_request
     */
    public function testPostRequestReturnsResponseObjectOnError()
    {
        $this->mock_function('curl_init', self::CURL_RETURN_TRUE);
        $this->mock_function('curl_setopt_array', self::CURL_RETURN_FALSE);
        $this->mock_function('curl_exec', self::CURL_RETURN_VALUE);
        $this->mock_function('curl_errno', self::CURL_RETURN_ERRNO);
        $this->mock_function('curl_error', self::CURL_RETURN_ERRMSG);
        $this->mock_function('curl_getinfo', self::CURL_RETURN_CODE);
        $this->mock_function('curl_close', self::CURL_RETURN_TRUE);

        $return = $this->class->post_request('http://localhost/', []);

        $this->assertInstanceOf('Lunr\Network\CurlResponse', $return);

        $this->unmock_function('curl_init');
        $this->unmock_function('curl_setopt_array');
        $this->unmock_function('curl_exec');
        $this->unmock_function('curl_errno');
        $this->unmock_function('curl_error');
        $this->unmock_function('curl_getinfo');
        $this->unmock_function('curl_close');
    }

}

?>
