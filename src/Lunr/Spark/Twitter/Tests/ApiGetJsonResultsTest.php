<?php

/**
 * This file contains the ApiGetJsonResultsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Twitter
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Twitter\Tests;

use Requests_Exception_HTTP_400;
use Requests_Exception;

/**
 * This class contains the tests for the Api.
 *
 * @covers Lunr\Spark\Twitter\Api
 */
class ApiGetJsonResultsTest extends ApiTest
{

    /**
     * Test that get_json_results() does a correct request.
     *
     * @param String $http_method HTTP method to use for the request.
     *
     * @dataProvider requestParamProvider
     * @covers       Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsCallsRequest(...$arguments)
    {
        $count = count($arguments);

        $options           = [];
        $http_method_upper = 'GET';
        $params            = [];
        $headers           = [];

        switch ($count)
        {
            case 5:
                $options = $arguments[4];
            case 4:
                $http_method_upper = strtoupper($arguments[3]);
            case 3:
                $params = $arguments[2];
            case 2:
                $headers = $arguments[1];
            case 1:
            default:
                $url = $arguments[0];
        }

        $options['verify'] = TRUE;

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($params), $this->equalTo($http_method_upper), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, $arguments);
    }

    /**
     * Test that get_json_results() throws an error if the request had an error.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestHadError()
    {
        $output = [
            'errors' => [
                [
                    'message' => 'Message',
                    'code'    => 'Code',
                ],
            ],
        ];

        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = $url;

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Invalid Input!')));

        $context = [ 'message' => 'Message', 'code' => 'Code', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Twitter API Request ({request}) failed, ({code}): {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() throws an error if the request failed.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestFailed()
    {
        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'Network error!', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Twitter API Request ({request}) failed: {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() does not throw an error if the request was successful.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsDoesNotThrowErrorIfRequestSuccessful()
    {
        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = '{}';
        $this->response->url         = $url;

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $this->logger->expects($this->never())
                     ->method('warning');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() returns an empty array if there was a request error.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsReturnsEmptyArrayOnRequestError()
    {
        $output = [
            'errors' => [
                [
                    'message' => 'Message',
                    'code'    => 'Code',
                ],
            ],
        ];

        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = $url;

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400('Invalid Input!')));

        $context = [ 'message' => 'Message', 'code' => 'Code', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Twitter API Request ({request}) failed, ({code}): {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_json_results() returns an empty array if the request failed.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsReturnsEmptyArrayIfRequestFailed()
    {
        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'Network error!', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Twitter API Request ({request}) failed: {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEmpty($method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

    /**
     * Test that get_json_results() returns the request result on success.
     *
     * @covers Lunr\Spark\Twitter\Api::get_json_results
     */
    public function testGetJsonResultsReturnsResultsOnSuccessfulRequest()
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $url     = 'http://localhost';
        $options = [ 'verify' => TRUE ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo([]), $this->equalTo('GET'), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);
        $this->response->url         = $url;

        $this->response->expects($this->once())
                       ->method('throw_for_status');

        $this->logger->expects($this->never())
                     ->method('warning');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals(
            [ 'param1' => 1, 'param2' => 2 ],
            $method->invokeArgs($this->class, [ 'http://localhost' ])
        );
    }

}

?>
