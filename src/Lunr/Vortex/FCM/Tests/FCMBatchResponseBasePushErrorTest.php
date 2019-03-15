<?php

/**
 * This file contains the FCMBatchResponseBasePushErrorTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the FCMBatchResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\FCM\FCMBatchResponse
 */
class FCMBatchResponseBasePushErrorTest extends FCMBatchResponseTest
{

    /**
     * Test constructor behavior for error of push notification in case of invalid JSON.
     *
     * @covers Lunr\Vortex\FCM\FCMBatchResponse::__construct
     */
    public function testPushErrorInvalidJSON(): void
    {
        $http_code = 400;
        $content   = 'Field "collapse_key" must be a JSON string: 1463565451';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching push notification failed: {error}',
                         [ 'error' => "Invalid JSON ({$content})" ]
                     );

        $this->class      = new FCMBatchResponse($this->response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Test constructor behavior for error of push notification in case of authentication error.
     *
     * @covers Lunr\Vortex\FCM\FCMBatchResponse::__construct
     */
    public function testPushErrorAuthenticationError(): void
    {
        $http_code = 401;
        $content   = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching push notification failed: {error}',
                         [ 'error' => 'Error with authentication' ]
                     );

        $this->class      = new FCMBatchResponse($this->response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Unit test data provider for internal error http codes.
     *
     * @return array $data http code
     */
    public function internalErrorHTTPCodeDataProvider()
    {
        $data = [];

        $data[] = [ 500 ];
        $data[] = [ 501 ];
        $data[] = [ 503 ];
        $data[] = [ 599 ];

        return $data;
    }

    /**
     * Test constructor behavior for error of push notification in case of internal error.
     *
     * @param integer $http_code HTTP code received
     *
     * @dataProvider internalErrorHTTPCodeDataProvider
     * @covers       Lunr\Vortex\FCM\FCMBatchResponse::__construct
     */
    public function testPushErrorInternalError($http_code): void
    {
        $content = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching push notification failed: {error}',
                         [ 'error' => 'Internal error' ]
                     );

        $this->class      = new FCMBatchResponse($this->response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::TEMPORARY_ERROR ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

    /**
     * Unit test data provider for unknown error http codes.
     *
     * @return array $data http code
     */
    public function unknownErrorHTTPCodeDataProvider()
    {
        $data = [];

        $data[] = [ 404 ];
        $data[] = [ 403 ];

        return $data;
    }

    /**
     * Test constructor behavior for error of push notification in case of unknown error.
     *
     * @param integer $http_code HTTP code received
     *
     * @dataProvider unknownErrorHTTPCodeDataProvider
     * @covers       Lunr\Vortex\FCM\FCMBatchResponse::__construct
     */
    public function testPushErrorUnknownError($http_code): void
    {
        $content = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching push notification failed: {error}',
                         [ 'error' => 'Unknown error' ]
                     );

        $this->class      = new FCMBatchResponse($this->response, $this->logger, [ 'endpoint1' ]);
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::UNKNOWN ]);
        $this->assertPropertyEquals('content', $content);
        $this->assertPropertyEquals('http_code', $http_code);
    }

}

?>
