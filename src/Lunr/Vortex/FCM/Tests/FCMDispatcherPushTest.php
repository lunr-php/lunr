<?php

/**
 * This file contains the FCMDispatcherPushTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\PushNotificationStatus;
use Requests_Exception;

/**
 * This class contains test for the push() method of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherPushTest extends FCMDispatcherTest
{

    /**
     * Test that push() returns FCMResponseObject.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushReturnsFCMResponseObject(): void
    {
        $endpoints = [];

        $this->constant_redefine('Lunr\Vortex\FCM\FCMDispatcher::BATCH_SIZE', 2);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $result);
    }

    /**
     * Test that push_batch() returns FCMBatchResponse.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push_batch
     */
    public function testPushBatchReturnsFCMBatchResponseObject(): void
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->will($this->returnValue($response));

        $method = $this->get_accessible_reflection_method('push_batch');
        $result = $method->invokeArgs($this->class, [ $this->payload, &$endpoints ]);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMBatchResponse', $result);
    }

    /**
     * Test that push() doesn't send any request if no endpoint is set.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
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
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
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
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushWithFailedRequest(): void
    {
        $this->mock_function('curl_errno', function (){ return 10; });

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://fcm.googleapis.com/fcm/send';
        $post = '{"to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('cURL error 10: Request error', 'curlerror', NULL)));

        $message = 'Dispatching FCM notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 10: Request error' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $result);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushWithTimeoutRequest()
    {
        $this->mock_function('curl_errno', function (){ return 28; });

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://fcm.googleapis.com/fcm/send';
        $post = '{"to":"endpoint"}';

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($post), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('cURL error 28: Request timed out', 'curlerror', NULL)));

        $message = 'Dispatching FCM notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 28: Request timed out' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $result);

        $this->assertSame($result->get_status('endpoint'), PushNotificationStatus::TEMPORARY_ERROR);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() sends correct request with no properties set except the endpoint.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushRequestWithDefaultValues(): void
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=',
        ];

        $url  = 'https://fcm.googleapis.com/fcm/send';
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
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
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

        $url  = 'https://fcm.googleapis.com/fcm/send';
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
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
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

        $url  = 'https://fcm.googleapis.com/fcm/send';
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
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
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

        $url = 'https://fcm.googleapis.com/fcm/send';

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
