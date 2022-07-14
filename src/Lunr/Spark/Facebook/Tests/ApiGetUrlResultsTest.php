<?php

/**
 * This file contains the ApiGetUrlResultsTest class.
 *
 * @package    Lunr\Spark\Facebook
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Facebook\Tests;

use Requests_Exception;
use Requests_Exception_HTTP_400;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Facebook\Api
 */
class ApiGetUrlResultsTest extends ApiTest
{

    /**
     * Test that get_url_results() does a correct request.
     *
     * @param string ...$arguments Request parameters to expect.
     *
     * @dataProvider requestParamProvider
     * @covers       Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetJsonResultsCallsRequest(...$arguments): void
    {
        $count = count($arguments);

        $http_method_upper = 'GET';
        $params            = [];

        switch ($count)
        {
            case 3:
                $http_method_upper = strtoupper($arguments[2]);
            case 2:
                $params = $arguments[1];
            case 1:
            default:
                $url = $arguments[0];
        }

        $options['verify'] = TRUE;

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], $params, $http_method_upper)
                   ->willReturn($this->response);

        $method = $this->get_accessible_reflection_method('get_url_results');

        $method->invokeArgs($this->class, $arguments);
    }

    /**
     * Test that get_url_results() throws an error if the request had an error.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetUrlResultsThrowsErrorIfRequestHadError(): void
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url/';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new Requests_Exception_HTTP_400('Not Found!'));

        $context = [ 'message' => 'Message', 'code' => 'Code', 'type' => 'Type', 'request' => 'http://localhost/url/' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Facebook API Request ({request}) failed, {type} ({code}): {message}', $context);

        $method = $this->get_accessible_reflection_method('get_url_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_url_results() throws an error if the request failed.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestFailed(): void
    {
        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willThrowException(new Requests_Exception('Network error!', 'curlerror', NULL));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'Network error!', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Facebook API Request ({request}) failed: {message}', $context);

        $method = $this->get_accessible_reflection_method('get_url_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_url_results() does not throw an error if the request was successful.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetUrlResultsDoesNotThrowErrorIfRequestSuccessful(): void
    {
        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $this->logger->expects($this->never())
                     ->method('warning');

        $method = $this->get_accessible_reflection_method('get_url_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_url_results() returns an empty array if there was a request error.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetUrlResultsReturnsEmptyArrayOnRequestError(): void
    {
        $output = [
            'error' => [
                'message' => 'Message',
                'code'    => 'Code',
                'type'    => 'Type',
            ],
        ];

        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url/';

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new Requests_Exception_HTTP_400('Not Found!'));

        $method = $this->get_accessible_reflection_method('get_url_results');

        $this->assertArrayEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_url_results() returns an empty array if there was a request failure.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetJsonResultsReturnsEmptyArrayOnRequestFailure(): void
    {
        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willThrowException(new Requests_Exception('Network error!', 'curlerror', NULL));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $method = $this->get_accessible_reflection_method('get_url_results');

        $this->assertArrayEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_url_results() returns the request result on success.
     *
     * @covers Lunr\Spark\Facebook\Api::get_url_results
     */
    public function testGetUrlResultsReturnsResultsOnSuccessfulRequest(): void
    {
        $url = 'http://localhost';

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($url, [], [], 'GET')
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = 'param1=1&param2=2';

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $method = $this->get_accessible_reflection_method('get_url_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
