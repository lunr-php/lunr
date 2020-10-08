<?php

/**
 * This file contains the JPushDispatcherPushTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\PushNotificationStatus;
use Requests_Exception;

/**
 * This class contains test for the push() method of the JPushDispatcher class.
 *
 * @covers \Lunr\Vortex\JPush\JPushDispatcher
 */
class JPushDispatcherPushTest extends JPushDispatcherTest
{

    /**
     * Test that push() returns JPushResponseObject.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushReturnsJPushResponseObject(): void
    {
        $endpoints = [];

        $this->constant_redefine('Lunr\Vortex\JPush\JPushDispatcher::BATCH_SIZE', 2);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushResponse', $result);
    }

    /**
     * Test that push_batch() returns JPushBatchResponse.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push_batch
     */
    public function testPushBatchReturnsJPushBatchResponseObject(): void
    {
        $endpoints = [ 'endpoint' ];

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->will($this->returnValue($response));

        $method = $this->get_accessible_reflection_method('push_batch');
        $result = $method->invokeArgs($this->class, [ $this->payload, &$endpoints ]);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushBatchResponse', $result);
    }

    /**
     * Test that push() doesn't send any request if no endpoint is set.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
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
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushResetsProperties(): void
    {
        $endpoints = [ 'endpoint' ];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn(['collapse_key' => 'abcde-12345']);

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
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushWithFailedRequest(): void
    {
        $this->mock_function('curl_errno', function (){ return 10; });

        $endpoints = [ 'endpoint' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"alert":"hello","audience":{"registration_id":["endpoint"]}}';
        $payload   = ['alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->throwException(new Requests_Exception('cURL error 10: Request error', 'curlerror', NULL)));

        $message = 'Dispatching JPush notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 10: Request error' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($message, $context);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushResponse', $result);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushWithTimeoutRequest()
    {
        $this->mock_function('curl_errno', function (){ return 28; });

        $endpoints = [ 'endpoint' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"alert":"hello","audience":{"registration_id":["endpoint"]}}';
        $payload   = ['alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->throwException(new Requests_Exception('cURL error 28: Request timed out', 'curlerror', NULL)));

        $message = 'Dispatching JPush notification(s) failed: {message}';
        $context = [ 'message' => 'cURL error 28: Request timed out' ];

        $this->logger->expects($this->at(0))
                     ->method('warning')
                     ->with($message, $context);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushResponse', $result);

        $this->assertSame($result->get_status('endpoint'), PushNotificationStatus::TEMPORARY_ERROR);

        $this->unmock_function('curl_errno');
    }

    /**
     * Test that push() works as expected when the request failed.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushWithFailureResponse()
    {
        $endpoints = [ 'endpoint' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"alert":"hello","audience":{"registration_id":["endpoint"]}}';
        $payload   = ['alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $response = $this->getMockBuilder('Requests_Response')->getMock();
        $response->success = FALSE;
        $response->status_code = 400;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $message = 'Dispatching JPush notification failed: {error}';
        $context = [ 'error' => 'Invalid request' ];

        $this->logger->expects($this->exactly(1))
                     ->method('warning')
                     ->with($message, $context);

        $result = $this->class->push($this->payload, $endpoints);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushResponse', $result);

        $this->assertSame(PushNotificationStatus::ERROR, $result->get_status('endpoint'));
    }

    /**
     * Test that push() sends correct request with no properties set except the endpoint.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushRequestWithDefaultValues(): void
    {
        $endpoints = [ 'endpoint' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"alert":"hello","audience":{"registration_id":["endpoint"]}}';
        $payload   = ['alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with single endpoint.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushRequestWithSingleEndpoint(): void
    {
        $endpoints = [ 'endpoint' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"collapse_key":"abcde-12345","alert":"hello","audience":{"registration_id":["endpoint"]}}';
        $payload   = ['collapse_key' => 'abcde-12345', 'alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within one batch.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsOneBatch(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2' ];
        $url       = 'https://api.jpush.cn/v3/push';
        $post      = '{"collapse_key":"abcde-12345","alert":"hello","audience":{"registration_id":["endpoint1","endpoint2"]}}';
        $payload   = ['collapse_key' => 'abcde-12345', 'alert' => 'hello'];

        $this->payload->expects($this->exactly(1))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic auth_token',
        ];

        $options = [
            'timeout'         => 15,
            'connect_timeout' => 15
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() sends correct request with multiple endpoints within multiple batches.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::push
     */
    public function testPushRequestWithMultipleEndpointsMultipleBatches(): void
    {
        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];

        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $url = 'https://api.jpush.cn/v3/push';

        $http_pos    = 0;
        $payload_pos = 0;

        $post    = '{"collapse_key":"abcde-12345","alert":"hello","audience":{"registration_id":["endpoint1","endpoint2"]}}';
        $payload = ['collapse_key' => 'abcde-12345', 'alert' => 'hello'];

        $this->payload->expects($this->at($payload_pos++))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->http->expects($this->at($http_pos++))
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","alert":"hello","audience":{"registration_id":["endpoint3","endpoint4"]}}';

        $this->payload->expects($this->at($payload_pos++))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->http->expects($this->at($http_pos++))
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $post = '{"collapse_key":"abcde-12345","alert":"hello","audience":{"registration_id":["endpoint5"]}}';

        $this->payload->expects($this->at($payload_pos++))
                      ->method('get_payload')
                      ->willReturn($payload);

        $this->http->expects($this->at($http_pos++))
                   ->method('post')
                   ->with($url, [], $post, [])
                   ->will($this->returnValue($response));

        $this->class->push($this->payload, $endpoints);
    }

}

?>
