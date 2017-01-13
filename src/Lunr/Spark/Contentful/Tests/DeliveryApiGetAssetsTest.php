<?php

/**
 * This file contains the DeliveryApiGetAssetsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2017, M2Mobi BV, Amsterdam, The Netherlands
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
class DeliveryApiGetAssetsTest extends DeliveryApiTest
{

    /**
     * Test that get_assets() returns an empty result if there was a request error.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithoutFiltersReturnsEmptyResultOnRequestError()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->body        = NULL;

        $return = $this->class->get_assets();

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_assets() with filters returns an empty result if there was a request error.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithFiltersReturnsEmptyResultOnRequestError()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'mimetype_group' => 'image', 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('throw_for_status')
                       ->will($this->throwException(new Requests_Exception_HTTP_400(NULL, $this->response)));

        $this->response->status_code = 400;
        $this->response->body        = NULL;

        $return = $this->class->get_assets([ 'mimetype_group' => 'image' ]);

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_assets() returns an empty result if the request failed.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithoutFiltersReturnsEmptyResultOnRequestFailure()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->throwException(new Requests_Exception('cURL error 0001: Network error', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $return = $this->class->get_assets();

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_assets() with filters returns an empty result if the request failed.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithFiltersReturnsEmptyResultOnRequestFailure()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'mimetype_group' => 'image', 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->throwException(new Requests_Exception('cURL error 0001: Network error', 'curlerror', NULL)));

        $this->response->expects($this->never())
                       ->method('throw_for_status');

        $return = $this->class->get_assets([ 'mimetype_group' => 'image' ]);

        $this->assertInternalType('array', $return);
        $this->assertArrayHasKey('total', $return);
        $this->assertSame(0, $return['total']);
    }

    /**
     * Test that get_assets() returns the request result on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithoutFiltersReturnsResultsOnSuccessfulRequest()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $result = $this->class->get_assets();

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

    /**
     * Test that get_assets() with filters returns the request result on success.
     *
     * @requires extension runkit
     * @covers   Lunr\Spark\Contentful\DeliveryApi::get_assets
     */
    public function testGetAssetsWithFiltersReturnsResultsOnSuccessfulRequest()
    {
        $this->set_reflection_property_value('space', '5p4c31D');

        $output = [
            'param1' => 1,
            'param2' => 2,
        ];

        $this->cas->expects($this->once())
                  ->method('get')
                  ->with($this->equalTo('contentful'), $this->equalTo('access_token'))
                  ->will($this->returnValue('token'));

        $url    = 'https://cdn.contentful.com/spaces/5p4c31D/assets';
        $params = [ 'mimetype_group' => 'image', 'access_token' => 'token' ];

        $this->http->expects($this->once())
                   ->method('request')
                   ->with($this->equalTo($url), $this->equalTo([]), $this->equalTo($params))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = json_encode($output);

        $result = $this->class->get_assets([ 'mimetype_group' => 'image' ]);

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

}

?>
