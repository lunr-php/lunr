<?php

/**
 * This file contains the GCMDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Requests_Exception;

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
        $endpoints = [];

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);
    }

    /**
     * Test that push() doesn't send any request if no endpoint is set.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushDoesNoRequestIfNoEndpoint()
    {
        $endpoints = [];

        $this->http->expects($this->never())
                   ->method('post');

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $endpoints = [ 'endpoint' ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);

        $this->assertPropertyEquals('auth_token', '');
        $this->assertPropertyEquals('priority', 'normal');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushWithFailedRequest()
    {
        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"to":"endpoint","priority":"normal"}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->throwException(new Requests_Exception('cURL error 10: Request error', 'curlerror', NULL)));

        $message = 'Dispatching GCM notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 10: Request error' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);
    }

    /**
     * Test that push() sends correct request with no properties set except the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithDefaultValues()
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"to":"endpoint","priority":"normal"}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with single endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithSingleEndpoint()
    {
        $endpoints = [ 'endpoint' ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=auth_token',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"collapse_key":"abcde-12345","to":"endpoint","priority":"normal"}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within one batch.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsOneBatch()
    {
        $endpoints = [ 'endpoint1', 'endpoint2' ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=auth_token',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"],"priority":"high"}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within multiple batches.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsMultipleBatches()
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];

        $this->payload->expects($this->exactly(3))
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('priority', 'high');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=auth_token',
        ];

        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $pos = 0;

        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"],"priority":"high"}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint3","endpoint4"],"priority":"high"}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","to":"endpoint5","priority":"high"}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

}

?>
