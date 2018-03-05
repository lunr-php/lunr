<?php

/**
 * This file contains the DeliveryApiGetJsonResultsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Requests_Exception_HTTP_400;
use Requests_Exception;

/**
 * This class contains the tests for the DeliveryApi.
 *
 * @covers Lunr\Spark\Contentful\DeliveryApi
 */
class DeliveryApiGetJsonResultsTest extends DeliveryApiTest
{

    /**
     * Test that get_josn_results() does a correct get_request without params.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithoutParams()
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [] ]);
    }

    /**
     * Test that get_json_results() does a correct get_request with params.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithParams()
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([ 'param1' => 1, 'param2' => 2 ]))
                   ->will($this->returnValue($this->response));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [ 'param1' => 1, 'param2' => 2 ] ]);
    }

    /**
     * Test that get_json_results() throws an error if the request had an error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestHadError()
    {
        $output = [
            'message' => 'Something failed',
            'sys'     => ['id' => 'Something'],
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url';

        $context = [ 'message' => 'Something failed', 'id' => 'Something', 'request' => 'http://localhost/url' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Contentful API Request ({request}) failed with id "{id}": {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() throws an error if the request failed.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsThrowsErrorIfRequestFailed()
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->throwException(new Requests_Exception('cURL error 0001: Network error', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $context = [ 'message' => 'cURL error 0001: Network error', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Contentful API Request ({request}) failed! {message}'), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost' ]);
    }

    /**
     * Test that get_json_results() does not throw an error if the request was successful.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsDoesNotThrowErrorIfRequestSuccessful()
    {
        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

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
    public function testGetJsonResultsReturnsEmptyResultOnRequestError()
    {
        $output = [
            'message' => 'Something failed',
            'sys'     => ['id' => 'Something'],
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->body        = json_encode($output);
        $this->response->url         = 'http://localhost/url';

        $method = $this->get_accessible_reflection_method('get_json_results');

        $value = $method->invokeArgs($this->class, [ 'http://localhost' ]);

        $this->assertInternalType('array', $value);
        $this->assertArrayHasKey('total', $value);
        $this->assertSame(0, $value['total']);
    }

    /**
     * Test that get_json_results() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsReturnsResultsOnSuccessfulRequest()
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo('http://localhost'), $this->equalTo([]), $this->equalTo([]))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
