<?php

/**
 * This file contains the DeliveryApiGetEntriesTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2016, M2Mobi BV, Amsterdam, The Netherlands
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
class DeliveryApiGetEntriesTest extends DeliveryApiTest
{

    /**
     * Test that get_entries() returns an empty result if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithoutFiltersReturnsEmptyResultOnRequestError()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('https://cdn.contentful.com/spaces//entries?access_token=token&content_type=foo'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result');

        $return = $this->class->get_entries('foo');

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns an empty result if there was a request error.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithFiltersReturnsEmptyResultOnRequestError()
    {
        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url = 'https://cdn.contentful.com/spaces//entries?field.urlName%5Bmatch%5D=bar&access_token=token&content_type=foo';

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result');

        $return = $this->class->get_entries('foo', [ 'field.urlName[match]' => 'bar' ]);

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_entries() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithoutFiltersReturnsResultsOnSuccessfulRequest()
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('https://cdn.contentful.com/spaces//entries?access_token=token&content_type=foo'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $result = $this->class->get_entries('foo');

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

    /**
     * Test that get_entries() returns the request result on success.
     *
     * @covers Lunr\Spark\Contentful\DeliveryApi::get_entries
     */
    public function testGetEntriesWithFiltersReturnsResultsOnSuccessfulRequest()
    {
        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url = 'https://cdn.contentful.com/spaces//entries?field.urlName%5Bmatch%5D=bar&access_token=token&content_type=foo';

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo($url))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

        $result = $this->class->get_entries('foo', [ 'field.urlName[match]' => 'bar' ]);

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

}

?>
