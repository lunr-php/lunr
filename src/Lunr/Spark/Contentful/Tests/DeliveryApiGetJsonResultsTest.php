<?php

/**
 * This file contains the DeliveryApiGetJsonResultsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

use Lunr\Spark\Contentful\DeliveryApi;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

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
     * @param String $http_method HTTP method to use for the request.
     *
     * @dataProvider getMethodProvider
     * @covers       Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithoutParams($http_method)
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"message":"text",sys:{"id":"errorid"}}'));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [], $http_method ]);
    }

    /**
     * Test that get_json_results() does a correct get_request with params.
     *
     * @param String $http_method HTTP method to use for the request.
     *
     * @dataProvider getMethodProvider
     * @covers       Lunr\Spark\Contentful\DeliveryApi::get_json_results
     */
    public function testGetJsonResultsMakesGetRequestWithParams($http_method)
    {
        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_FAILONERROR'), $this->equalTo(FALSE));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?param1=1&param2=2'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{"message":"text",sys:{"id":"errorid"}}'));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $method->invokeArgs($this->class, [ 'http://localhost', [ 'param1' => 1, 'param2' => 2 ], $http_method ]);
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

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $context = [ 'message' => 'Something failed', 'id' => 'Something', 'request' => 'http://localhost' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo('Contentful API Request ({request}) failed with id "{id}": {message}'), $this->equalTo($context));

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
        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue('{}'));

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
        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result');

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

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('http://localhost?'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $method = $this->get_accessible_reflection_method('get_json_results');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $method->invokeArgs($this->class, [ 'http://localhost' ]));
    }

}

?>
