<?php

/**
 * This file contains the GCMResponseBasePushSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the GCMResponse class
 * in case of a push notification success.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseBasePushSuccessTest extends GCMResponseTest
{

    /**
     * Test constructor behavior for success of push notification with missing results.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithMissingResults()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_missing_results.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed: {error}',
                        [ 'error' => 'Unknown error' ]
                     );

        $endpoints = [ 'endpoint1' ];
        $statuses  = [ 'endpoint1' => PushNotificationStatus::UNKNOWN ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithSingleSuccess()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_single_success.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1' ];
        $statuses  = [ 'endpoint1' => PushNotificationStatus::SUCCESS ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with single error.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithSingleError()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_single_error.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Invalid registration token' ]
                     );

        $endpoints = [ 'endpoint1' ];
        $statuses  = [ 'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with multiple success.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithMultipleSuccess()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_multiple_success.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3' ];
        $statuses  = [
            'endpoint1' => PushNotificationStatus::SUCCESS,
            'endpoint2' => PushNotificationStatus::SUCCESS,
            'endpoint3' => PushNotificationStatus::SUCCESS,
        ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with multiple errors.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithMultipleErrors()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_multiple_error.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $error_messages = [
            'endpoint1'  => 'Missing registration token',
            'endpoint2'  => 'Invalid registration token',
            'endpoint3'  => 'Unregistered device',
            'endpoint4'  => 'Invalid package name',
            'endpoint5'  => 'Mismatched sender',
            'endpoint6'  => 'Message too big',
            'endpoint7'  => 'Invalid data key',
            'endpoint8'  => 'Invalid time to live',
            'endpoint9'  => 'Timeout',
            'endpoint10' => 'Internal server error',
            'endpoint11' => 'Device message rate exceeded',
            'endpoint12' => 'Topics message rate exceeded',
            'endpoint13' => 'unknown-stuff',
        ];

        $endpoints = [];

        for ($i = 1; $i <= 13; $i++)
        {
            $endpoint = 'endpoint' . $i;

            $endpoints[] = $endpoint;

            $this->logger->expects($this->at($i - 1))
                         ->method('warning')
                         ->with(
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => $endpoint, 'error' => $error_messages[$endpoint] ]
                         );
        }

        $statuses = [
            'endpoint1'  => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint2'  => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint3'  => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint4'  => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint5'  => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint6'  => PushNotificationStatus::ERROR,
            'endpoint7'  => PushNotificationStatus::ERROR,
            'endpoint8'  => PushNotificationStatus::ERROR,
            'endpoint9'  => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint10' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint11' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint12' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint13' => PushNotificationStatus::UNKNOWN,
        ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with multiple mixed results.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithMultipleMixedResults()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_multiple_mixed.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];
        $statuses  = [
            'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint2' => PushNotificationStatus::SUCCESS,
            'endpoint3' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint4' => PushNotificationStatus::SUCCESS,
            'endpoint5' => PushNotificationStatus::SUCCESS,
        ];

        $this->logger->expects($this->at(0))
                      ->method('warning')
                      ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Invalid registration token' ]
                      );

        $this->logger->expects($this->at(1))
                      ->method('warning')
                      ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint3', 'error' => 'Invalid registration token' ]
                      );

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with more endpoints than results.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithMoreEndpointsThanResults()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_multiple_success.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];
        $statuses  = [
            'endpoint1' => PushNotificationStatus::SUCCESS,
            'endpoint2' => PushNotificationStatus::SUCCESS,
            'endpoint3' => PushNotificationStatus::SUCCESS,
        ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

    /**
     * Test constructor behavior for success of push notification with less endpoints than results.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::__construct
     */
    public function testPushSuccessWithLessEndpointsThanResults()
    {
        parent::setUp();

        $this->curl_response->expects($this->once())
                            ->method('__get')
                            ->with('http_code')
                            ->willReturn(200);

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_multiple_success.json');

        $this->curl_response->expects($this->once())
                            ->method('get_result')
                            ->willReturn($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1' ];
        $statuses  = [ 'endpoint1' => PushNotificationStatus::SUCCESS ];

        $this->class      = new GCMResponse($this->curl_response, $this->logger, $endpoints);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');

        $this->assertPropertySame('logger', $this->logger, $endpoints);
        $this->assertPropertyEquals('statuses', $statuses);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', 200);
    }

}

?>
