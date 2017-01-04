<?php

/**
 * This file contains the APNSResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\libcapn\Tests;

use Lunr\Vortex\APNS\libcapn\APNSResponse;
use Lunr\Vortex\APNS\libcapn\APNSStatus;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the APNSResponse class.
 *
 * @covers Lunr\Vortex\APNS\libcapn\APNSResponse
 */
abstract class APNSResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = [ 'error_code' => 0, 'error_message' => NULL ];

        $this->class      = new APNSResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\libcapn\APNSResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Unit test data provider for failed requests.
     *
     * @return array $requests Array of failed request info
     */
    public function failedRequestProvider()
    {
        $requests   = [];
        $requests[] = [
            APNSStatus::APN_ERR_TOKEN_IS_NOT_SET,
            'no device tokens given',
            PushNotificationStatus::INVALID_ENDPOINT,
        ];
        $requests[] = [
            APNSStatus::APN_ERR_TOKEN_INVALID,
            'invalid device token',
            PushNotificationStatus::INVALID_ENDPOINT,
        ];
        $requests[] = [
            APNSStatus::APN_ERR_PROCESSING_ERROR,
            'processing error',
            PushNotificationStatus::TEMPORARY_ERROR,
        ];
        $requests[] = [
            APNSStatus::APN_ERR_UNKNOWN,
            'unknown error',
            PushNotificationStatus::UNKNOWN,
        ];
        $requests[] = [
            APNSStatus::APN_ERR_UNABLE_TO_USE_SPECIFIED_CERTIFICATE,
            'unable to use specified SSL certificate',
            PushNotificationStatus::ERROR,
        ];

        return $requests;
    }

}
