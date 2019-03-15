<?php

/**
 * This file contains the GCMDispatcherPushTest class.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\PushNotificationStatus;
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
    public function testPushReturnsGCMResponseObject(): void
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
    public function testPushDoesNoRequestIfNoEndpoint(): void
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
    public function testPushResetsProperties(): void
    {
        $endpoints = [ 'endpoint' ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushWithFailedRequest(): void
    {
        $this->mock_function('curl_errno', function (){ return 10; });

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('cURL error 10: Request error', 'curlerror', NULL)));

        $message = 'Dispatching GCM notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 10: Request error' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushWithTimeoutRequest()
    {
        $this->mock_function('curl_errno', function (){ return 28; });

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('cURL error 28: Request timed out', 'curlerror', NULL)));

        $message = 'Dispatching GCM notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 28: Request timed out' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);

        $this->assertSame($result->get_status('endpoint'), PushNotificationStatus::TEMPORARY_ERROR);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() sends correct request with no properties set except the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithDefaultValues(): void
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://gcm-http.googleapis.com/gcm/send';
        $post = '{"to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with single endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithSingleEndpoint(): void
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
        $post = '{"collapse_key":"abcde-12345","to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within one batch.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsOneBatch(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2' ];

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
        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"]}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within multiple batches.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsMultipleBatches(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];

        $this->payload->expects($this->exactly(3))
                      ->method('get_payload')
                      ->willReturn('{"collapse_key":"abcde-12345"}');

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=auth_token',
        ];

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $url = 'https://gcm-http.googleapis.com/gcm/send';

        $pos = 0;

        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint1","endpoint2"]}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","registration_ids":["endpoint3","endpoint4"]}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","to":"endpoint5"}';

        $this->http->expects($this->at($pos++))
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

}

?>
