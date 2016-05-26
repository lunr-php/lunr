<?php

/**
 * This file contains the GCMDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

/**
 * This class contains test for the push() method of the GCMDispatcher class.
 *
 * @covers Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherPushTest extends GCMDispatcherTest
{

    /**
     * Test that push() returns GCMResponseObject.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushReturnsGCMResponseObject()
    {
        $result = $this->class->push();

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);
    }

    /**
     * Test that push() doesn't send any request if no endpoint is set.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushDoesNoRequestIfNoEndpoint()
    {
        $this->curl->expects($this->never())
                   ->method('post_request');

        $this->class->push();
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoints', [ 'endpoint' ]);
        $this->set_reflection_property_value('payload', '{"collapse_key":"abcde-12345"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($response));

        $this->class->push();

        $this->assertPropertyEquals('endpoints', []);
        $this->assertPropertyEquals('payload', '{}');
        $this->assertPropertyEquals('auth_token', '');
        $this->assertPropertyEquals('priority', 'normal');
    }

    /**
     * Test that push() sends correct request with no properties set except the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithDefaultValues()
    {
        $this->set_reflection_property_value('endpoints', [ 'endpoint' ]);

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=' ]);

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with('https://gcm-http.googleapis.com/gcm/send', '{"to":"endpoint","priority":"normal"}')
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that push() sends correct request with single endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithSingleEndpoint()
    {
        $this->set_reflection_property_value('endpoints', [ 'endpoint' ]);
        $this->set_reflection_property_value('payload', '{"collapse_key":"abcde-12345"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=auth_token' ]);

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with(
                        'https://gcm-http.googleapis.com/gcm/send',
                        '{"collapse_key":"abcde-12345","to":"endpoint","priority":"normal"}'
                    )
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that push() sends correct request with multiple endpoints within one batch.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsOneBatch()
    {
        $this->set_reflection_property_value('endpoints', [ 'endpoint1', 'endpoint2' ]);
        $this->set_reflection_property_value('payload', '{"collapse_key":"abcde-12345"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=auth_token' ]);

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with(
                        'https://gcm-http.googleapis.com/gcm/send',
                        '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"],"priority":"high"}'
                    )
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that push() sends correct request with multiple endpoints within multiple batches.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsMultipleBatches()
    {
        runkit_constant_redefine('Lunr\Vortex\GCM\GCMDispatcher::BATCH_SIZE', 2);

        $this->set_reflection_property_value('endpoints', [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ]);
        $this->set_reflection_property_value('payload', '{"collapse_key":"abcde-12345"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $pos = 0;

        $this->curl->expects($this->at($pos++))
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->at($pos++))
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=auth_token' ]);

        $this->curl->expects($this->at($pos++))
                   ->method('post_request')
                   ->with(
                        'https://gcm-http.googleapis.com/gcm/send',
                        '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"],"priority":"high"}'
                    )
                   ->will($this->returnValue($response));

        $this->curl->expects($this->at($pos++))
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->at($pos++))
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=auth_token' ]);

        $this->curl->expects($this->at($pos++))
                   ->method('post_request')
                   ->with(
                        'https://gcm-http.googleapis.com/gcm/send',
                        '{"collapse_key":"abcde-12345","registration_ids":["endpoint3","endpoint4"],"priority":"high"}'
                    )
                   ->will($this->returnValue($response));

        $this->curl->expects($this->at($pos++))
                   ->method('set_option')
                   ->with('CURLOPT_FAILONERROR', FALSE);

        $this->curl->expects($this->at($pos++))
                   ->method('set_http_headers')
                   ->with([ 'Content-Type:application/json', 'Authorization: key=auth_token' ]);

        $this->curl->expects($this->at($pos++))
                   ->method('post_request')
                   ->with(
                        'https://gcm-http.googleapis.com/gcm/send',
                        '{"collapse_key":"abcde-12345","to":"endpoint5","priority":"high"}'
                    )
                   ->will($this->returnValue($response));

        $this->class->push();
    }

}

?>
