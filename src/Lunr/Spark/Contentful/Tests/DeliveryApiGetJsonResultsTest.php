<?php

/**
 * This file contains the DeliveryApiGetJsonResultsTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark\Contentful\Tests;

use WpOrg\Requests\Exception as RequestsException;
use WpOrg\Requests\Exception\Http\Status400 as RequestsExceptionHTTP400;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @covers Lunr\Spark\Contentful\DeliveryApi
 */
class DeliveryApiGetJsonResultsTest extends DeliveryApiTest
{

    /**
     * Test that get_json_results() does a correct get_request without params.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithoutParams(): void
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willReturn($this->response);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [] ]);
    }

    /**
     * Test that get_json_results() does a correct get_request with params.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithParams(): void
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [ 'param1' => 1, 'param2' => 2 ])
                   ->willReturn($this->response);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [ 'param1' => 1, 'param2' => 2 ] ]);
    }

    /**
     * Test that get_json_results() throws an error if the request had an error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestHadError(): void
    {
        $output = [
            'message' => 'Something failed',
            'sys'     => [ 'id' => 'Something' ],
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new RequestsExceptionHTTP400(NULL, $this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url';

        $context = [ 'message' => 'Something failed', 'id' => 'Something', 'request' => 'http://localhost/url' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed with id "{id}": {message}', $context);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() throws an error if the request failed.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestFailed(): void
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willThrowException(new RequestsException('cURL error 0001: Network error', 'curlerror', NULL));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'cURL error 0001: Network error', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Contentful API Request ({request}) failed! {message}', $context);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() does not throw an error if the request was successful.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsDoesNotThrowErrorIfRequestSuccessful(): void
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = '{}';

        $this->logger->expects($this->never())
                     ->method('error');

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() returns an empty result if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsReturnsEmptyResultOnRequestError(): void
    {
        $output = [
            'message' => 'Something failed',
            'sys'     => [ 'id' => 'Something' ],
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willReturn($this->response);

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->willThrowException(new RequestsExceptionHTTP400(NULL, $this->response));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url';

        $method = $this->get_accessible_reflection_method('get_json_results');

        $value = $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertIsArray($value);
        $this->assertArrayHasKey('total', $value);
        $this->assertSame(0, $value['total']);
    }

    /**
     * Test that get_json_results() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsReturnsResultsOnSuccessfulRequest(): void
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with('http://localhost', [], [])
                   ->willReturn($this->response);

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
