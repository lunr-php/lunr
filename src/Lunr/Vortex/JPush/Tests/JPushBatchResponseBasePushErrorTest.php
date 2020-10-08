<?php

/**
 * This file contains the JPushBatchResponseBasePushErrorTest class.
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
 * in case of a push notification error.
 *
 * @covers \Lunr\Vortex\JPush\JPushBatchResponse
 */
class JPushBatchResponseBasePushErrorTest extends JPushBatchResponseTest
{

    /**
     * Test constructor behavior for error of push notification in case of invalid JSON.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
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
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Invalid request' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
    }

    /**
     * Test constructor behavior for error of push notification in case of invalid JSON.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushErrorWithUpstreamMessage(): void
    {
        $http_code = 400;
        $content   = '{"error": {"message": "Field \"collapse_key\" must be a JSON string: 1463565451"}}';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Field "collapse_key" must be a JSON string: 1463565451' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
    }

    /**
     * Test constructor behavior for error of push notification in case of authentication error.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
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
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Error with authentication' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
    }

    /**
     * Test constructor behavior for error of push notification in case of authentication error.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushErrorConfigError(): void
    {
        $http_code = 403;
        $content   = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Error with configuration' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::ERROR ]);
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
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushErrorInternalError($http_code): void
    {
        $content = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Internal error' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::TEMPORARY_ERROR ]);
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
        $data[] = [ 405 ];

        return $data;
    }

    /**
     * Test constructor behavior for error of push notification in case of unknown error.
     *
     * @param integer $http_code HTTP code received
     *
     * @dataProvider unknownErrorHTTPCodeDataProvider
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushErrorUnknownError($http_code): void
    {
        $content = 'stuff';

        $this->response->status_code = $http_code;
        $this->response->body        = $content;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Unknown error' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::UNKNOWN ]);
    }

    /**
     * Test constructor behavior for error of push notification in case of unknown error.
     *
     * @covers \Lunr\Vortex\JPush\JPushBatchResponse::__construct
     */
    public function testPushErrorReportingAPI(): void
    {

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         'Dispatching JPush notification failed: {error}',
                         [ 'error' => 'Unknown error' ]
                     );

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');

        $this->assertPropertySame('logger', $this->logger);
        $this->assertPropertyEquals('statuses', [ 'endpoint1' => PushNotificationStatus::UNKNOWN ]);
    }

}

?>
