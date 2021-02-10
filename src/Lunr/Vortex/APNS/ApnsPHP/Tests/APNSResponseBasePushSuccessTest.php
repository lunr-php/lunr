<?php

/**
 * This file contains the APNSResponseBasePushSuccessTest class.
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the APNSResponse class
 * in case of a push notification success.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
class APNSResponseBasePushSuccessTest extends APNSResponseTest
{

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithSingleSuccess(): void
    {
        $endpoints         = [ 'endpoint1' ];
        $invalid_endpoints = [];
        $errors            = [];
        $statuses          = [ 'endpoint1' => PushNotificationStatus::SUCCESS ];

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with single error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithSingleError(): void
    {
        $endpoints         = [ 'endpoint1' ];
        $invalid_endpoints = [];
        $errors            = [
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
        $statuses          = [ 'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT ];

        $this->apns_message->expects($this->once())
                           ->method('getRecipients')
                           ->willReturn([ 'endpoint1' ]);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'Invalid token' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with single error.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithSingleErrorHttpReason(): void
    {
        $endpoints         = [ 'endpoint1' ];
        $invalid_endpoints = [];
        $errors            = [
            1 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 8,
                        'statusCode'    => 400,
                        'identifier'    => 1,
                        'time'          => 1465997381,
                        'statusMessage' => '{"reason": "IdleTimeout"}',
                    ],
                ],
            ],
        ];
        $statuses          = [ 'endpoint1' => PushNotificationStatus::TEMPORARY_ERROR ];

        $this->apns_message->expects($this->once())
                           ->method('getRecipients')
                           ->willReturn([ 'endpoint1' ]);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint1', 'error' => 'IdleTimeout' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with multiple success.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithMultipleSuccess(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3' ];
        $invalid_endpoints = [];
        $errors            = [];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::SUCCESS,
            'endpoint2' => PushNotificationStatus::SUCCESS,
            'endpoint3' => PushNotificationStatus::SUCCESS,
        ];

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with multiple errors.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithMultipleErrors(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4' ];
        $invalid_endpoints = [];
        $errors            = [
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
            2 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 5,
                        'statusCode'    => 5,
                        'identifier'    => 2,
                        'time'          => 1465997382,
                        'statusMessage' => 'Invalid token size',
                    ],
                ],
            ],
            3 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 1,
                        'statusCode'    => 1,
                        'identifier'    => 3,
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
                        'identifier'    => 4,
                        'time'          => 1465997390,
                        'statusMessage' => 'Shutdown',
                    ],
                ],
            ],
        ];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint3' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint4' => PushNotificationStatus::UNKNOWN,
        ];

        $this->apns_message->expects($this->exactly(4))
                           ->method('getRecipients')
                           ->willReturn([ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4' ]);

        $this->logger->expects($this->exactly(4))
                     ->method('warning')
                     ->withConsecutive(
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint1', 'error' => 'Invalid token' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint2', 'error' => 'Invalid token size' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint3', 'error' => 'Processing error' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint4', 'error' => 'Shutdown' ],
                        ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with multiple errors.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithMultipleErrorsHttpReason(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5', 'endpoint6', 'endpoint7' ];
        $invalid_endpoints = [];
        $errors            = [
            1 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 8,
                        'statusCode'    => 501,
                        'identifier'    => 1,
                        'time'          => 1465997381,
                        'statusMessage' => '{"reason": "TopicDisallowed"}',
                    ],
                ],
            ],
            2 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 5,
                        'statusCode'    => 501,
                        'identifier'    => 2,
                        'time'          => 1465997382,
                        'statusMessage' => '{"reason": "BadCertificate"}',
                    ],
                ],
            ],
            3 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 1,
                        'statusCode'    => 501,
                        'identifier'    => 3,
                        'time'          => 1465997383,
                        'statusMessage' => '{"reason": "BadCertificateEnvironment"}',
                    ],
                ],
            ],
            4 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 501,
                        'identifier'    => 4,
                        'time'          => 1465997390,
                        'statusMessage' => '{"reason": "InvalidProviderToken"}',
                    ],
                ],
            ],
            5 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 501,
                        'identifier'    => 5,
                        'time'          => 1465997390,
                        'statusMessage' => '{"reason": "ExpiredProviderToken"}',
                    ],
                ],
            ],
            6 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 501,
                        'identifier'    => 6,
                        'time'          => 1465997390,
                        'statusMessage' => '{"reason": "BadDeviceToken"}',
                    ],
                ],
            ],
            7 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 10,
                        'statusCode'    => 501,
                        'identifier'    => 7,
                        'time'          => 1465997390,
                        'statusMessage' => '{"reason": "DeviceTokenNotForTopic"}',
                    ],
                ],
            ],
        ];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::ERROR,
            'endpoint3' => PushNotificationStatus::ERROR,
            'endpoint4' => PushNotificationStatus::ERROR,
            'endpoint5' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint6' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint6' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint7' => PushNotificationStatus::INVALID_ENDPOINT,
        ];

        $this->apns_message->expects($this->exactly(7))
                           ->method('getRecipients')
                           ->willReturn([ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5', 'endpoint6', 'endpoint7' ]);

        $this->logger->expects($this->exactly(7))
                     ->method('warning')
                     ->withConsecutive(
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint1', 'error' => 'TopicDisallowed' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint2', 'error' => 'BadCertificate' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint3', 'error' => 'BadCertificateEnvironment' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint4', 'error' => 'InvalidProviderToken' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint5', 'error' => 'ExpiredProviderToken' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint6', 'error' => 'BadDeviceToken' ],
                        ],
                        [
                            'Dispatching push notification failed for endpoint {endpoint}: {error}',
                            [ 'endpoint' => 'endpoint7', 'error' => 'DeviceTokenNotForTopic' ],
                        ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

    /**
     * Test constructor behavior for success of push notification with multiple mixed results and invalid endpoints
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithMultipleMixedResultsAndInvalidEndpoints(): void
    {
        $endpoints         = [ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ];
        $invalid_endpoints = [ 'endpoint2', 'endpoint3' ];
        $errors            = [
            4 => [
                'MESSAGE'             => $this->apns_message,
                'BINARY_NOTIFICATION' => 'blablibla',
                'ERRORS'              => [
                    [
                        'command'       => 1,
                        'statusCode'    => 1,
                        'identifier'    => 4,
                        'time'          => 1465997390,
                        'statusMessage' => 'Processing error',
                    ],
                ],
            ],
        ];
        $statuses          = [
            'endpoint1' => PushNotificationStatus::SUCCESS,
            'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint3' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint4' => PushNotificationStatus::TEMPORARY_ERROR,
            'endpoint5' => PushNotificationStatus::SUCCESS,
        ];

        $this->apns_message->expects($this->once())
                           ->method('getRecipients')
                           ->willReturn([ 'endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5' ]);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        'Dispatching push notification failed for endpoint {endpoint}: {error}',
                        [ 'endpoint' => 'endpoint4', 'error' => 'Processing error' ]
                     );

        $this->class      = new APNSResponse($this->logger, $endpoints, $invalid_endpoints, $errors, '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('statuses', $statuses);
    }

}
