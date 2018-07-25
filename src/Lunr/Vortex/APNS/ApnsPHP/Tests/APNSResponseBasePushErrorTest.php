<?php

/**
 * This file contains the APNSResponseBasePushErrorTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the APNSResponse class
 * in case of a push notification error.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
class APNSResponseBasePushErrorTest extends APNSResponseTest
{

    /**
     * Test constructor behavior for error of push notification with valid endpoint.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushErrorWithValidEndpoint()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = FALSE;
        $status           = PushNotificationStatus::ERROR;

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, NULL);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

    /**
     * Test constructor behavior for error of push notification with invalid endpoint.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushErrorWithInvalidEndpoints()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = TRUE;
        $status           = PushNotificationStatus::INVALID_ENDPOINT;

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, NULL);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

    /**
     * Test constructor behavior for error of push notification with invalid endpoint error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushWithInvalidEndpointError()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = FALSE;
        $errors           = [
            1 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 8,
                        'statusCode'    => 8,
                        'identifier'    => 1,
                        'time'          => 1465997381,
                        'statusMessage' => 'Invalid token',
                    ],
                ],
            ],
        ];
        $status           = PushNotificationStatus::INVALID_ENDPOINT;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Invalid token' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, $errors);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

    /**
     * Test constructor behavior for error of push notification with temporary error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushWithTemporaryError()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = FALSE;
        $errors           = [
            3 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 1,
                        'statusCode'    => 1,
                        'identifier'    => 1,
                        'time'          => 1465997383,
                        'statusMessage' => 'Processing error',
                    ],
                ],
            ],
            4 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 10,
                        'identifier'    => 1,
                        'time'          => 1465997390,
                        'statusMessage' => 'Shutdown',
                    ],
                ],
            ],
        ];
        $status           = PushNotificationStatus::TEMPORARY_ERROR;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Processing error' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, $errors);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

    /**
     * Test constructor behavior for error of push notification with temporary error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushWithUnknownError()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = FALSE;
        $errors           = [
            4 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 10,
                        'identifier'    => 1,
                        'time'          => 1465997390,
                        'statusMessage' => 'Shutdown',
                    ],
                ],
            ],
        ];
        $status           = PushNotificationStatus::UNKNOWN;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Shutdown' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, $errors);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

}
