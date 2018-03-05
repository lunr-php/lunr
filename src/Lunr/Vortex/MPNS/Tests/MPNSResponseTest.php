<?php

/**
 * This file contains the MPNSResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSResponse;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the MPNSResponse class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSResponse
 */
abstract class MPNSResponseTest extends LunrBaseTest
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
    public function setUpError()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->status_code = FALSE;
        $response->url         = 'http://localhost/';

        $this->class      = new MPNSResponse($response, $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Vortex\MPNS\MPNSResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->headers = [
            'Date'                     => '2013-07-05',
            'X-Notificationstatus'     => 'Received',
            'X-Deviceconnectionstatus' => 'Connected',
            'X-Subscriptionstatus'     => 'Active',
        ];

        $response->status_code = 200;
        $response->url         = 'http://localhost/';

        $this->class      = new MPNSResponse($response, $this->logger);
        $this->reflection = new ReflectionClass('Lunr\Vortex\MPNS\MPNSResponse');
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
     * Unit test data provider for special status codes.
     *
     * @return array $statuses Array of special statuses
     */
    public function specialStatusProvider()
    {
        $statuses   = [];
        $statuses[] = [ 400 ];
        $statuses[] = [ 401 ];
        $statuses[] = [ 405 ];
        $statuses[] = [ 503 ];

        return $statuses;
    }

    /**
     * Unit test data provider for failed requests.
     *
     * @return array $requests Array of failed request info
     */
    public function failedRequestProvider()
    {
        $requests   = [];
        $requests[] = [ 200, 'QueueFull', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 200, 'Suppressed', PushNotificationStatus::CLIENT_ERROR ];
        $requests[] = [ 404, 'Dropped', PushNotificationStatus::INVALID_ENDPOINT ];
        $requests[] = [ 400, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 401, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 405, 'N/A', PushNotificationStatus::ERROR ];
        $requests[] = [ 406, 'Dropped', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 412, 'Dropped', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 503, 'N/A', PushNotificationStatus::TEMPORARY_ERROR ];
        $requests[] = [ 500, 'N/A', PushNotificationStatus::UNKNOWN ];

        return $requests;
    }

}
