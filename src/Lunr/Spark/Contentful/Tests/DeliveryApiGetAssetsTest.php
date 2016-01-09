<?php

/**
 * This file contains the DeliveryApiGetAssetsTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Spark\Contentful
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2015-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Contentful\Tests;

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

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('https://cdn.contentful.com/spaces/5p4c31D/assets?access_token=token'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(400));

        $this->response->expects($this->once())
                       ->method('get_result');

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

        $url = 'https://cdn.contentful.com/spaces/5p4c31D/assets?mimetype_group=image&access_token=token';

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

        $this->curl->expects($this->once())
                   ->method('get_request')
                   ->with($this->equalTo('https://cdn.contentful.com/spaces/5p4c31D/assets?access_token=token'))
                   ->will($this->returnValue($this->response));

        $this->response->expects($this->once())
                       ->method('__get')
                       ->with($this->equalTo('http_code'))
                       ->will($this->returnValue(200));

        $this->response->expects($this->once())
                       ->method('get_result')
                       ->will($this->returnValue(json_encode($output)));

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

        $url = 'https://cdn.contentful.com/spaces/5p4c31D/assets?mimetype_group=image&access_token=token';

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

        $result = $this->class->get_assets([ 'mimetype_group' => 'image' ]);

        $this->assertEquals([ 'param1' => 1, 'param2' => 2 ], $result);
    }

}

?>
