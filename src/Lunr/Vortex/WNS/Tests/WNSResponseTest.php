<?php

/**
 * This file contains the WNSResponseTest class.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSResponse;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the WNSResponse class.
 *
 * @covers Lunr\Vortex\WNS\WNSResponse
 */
abstract class WNSResponseTest extends LunrBaseTest
{

    /**
     * Mock instance of the Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpError(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->status_code = FALSE;
        $response->url         = 'http://localhost/';

        $this->class      = new WNSResponse($response, $this->logger, '<?xml version="1.0" encoding="utf-8"?>');
        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->headers = [
            'Date'                         => '2016-01-13',
            'X-WNS-Status'                 => 'received',
            'X-WNS-DeviceConnectionStatus' => 'connected',
            'X-WNS-Error-Description'      => 'Some Error',
            'X-WNS-Debug-Trace'            => 'Some Trace',
        ];

        $response->status_code = 200;
        $response->url         = 'http://localhost/';

        $this->class      = new WNSResponse($response, $this->logger, '<?xml version="1.0" encoding="utf-8"?>');
        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSResponse');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
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
        $requests[] = [ 200, 'channelthrottled', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 200, 'dropped', PushNotificationStatus::CLIENT_ERROR ];
        $requests[] = [ 404, 'N/A', PushNotificationStatus::INVALID_ENDPOINT ];
        $requests[] = [ 410, 'N/A', PushNotificationStatus::INVALID_ENDPOINT ];
        $requests[] = [ 400, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 401, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 403, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 405, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 413, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 406, 'N/A', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 500, 'N/A', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 503, 'N/A', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 420, 'N/A', PushNotificationStatus::UNKNOWN ];

        return $requests;
    }

}
