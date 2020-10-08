<?php

/**
 * This file contains the JPushBatchResponseBasePushSuccessTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the JPushBatchResponse class
 * in case of a push notification success.
 *
 * @covers \Lunr\Vortex\JPush\JPushBatchResponse
 */
class JPushBatchResponseBasePushSuccessTest extends JPushBatchResponseTest
{

    /**
     * Test constructor behavior for success of push notification with missing results.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushSuccessWithMissingResults(): void
    {
        $content = [];

        $this->response->success     = TRUE;
        $this->response->body        = json_encode($content);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Unknown error' ]
                     );

        $this->http->expects($this->never())
                   ->method('post');

        $endpoints = [ 'endpoint1' ];
        $statuses  = [ 'endpoint1' => PushNotificationStatus::UNKNOWN ];

        $this->class      = new JPushBatchResponse($this->http, $this->logger ,$this->response, $endpoints, []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushSuccessWithSingleSuccess(): void
    {
        $content = ['msg_id' => 'dasfjksjkf'];

        $this->response->success     = TRUE;
        $this->response->body        = json_encode($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1' ];

        $this->class      = new JPushBatchResponse($this->http, $this->logger ,$this->response, $endpoints, []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', []);
        $this->assertPropertyEquals('message_id', 'dasfjksjkf');
    }

    /**
     * Test constructor behavior for success of push notification with multiple success.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushSuccessWithMultipleSuccess(): void
    {
        $content = ['msg_id' => 'dasfjksjkf'];

        $this->response->success     = TRUE;
        $this->response->body        = json_encode($content);

        $this->logger->expects($this->never())
                     ->method('warning');

        $endpoints = [ 'endpoint1', 'endpoint2', 'endpoint3' ];

        $this->class      = new JPushBatchResponse($this->http, $this->logger ,$this->response, $endpoints, []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', []);
        $this->assertPropertyEquals('message_id', 'dasfjksjkf');
    }

}

?>
