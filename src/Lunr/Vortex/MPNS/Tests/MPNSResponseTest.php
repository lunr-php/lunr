<?php

/**
 * This file contains the MPNSResponseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSResponse
 */
abstract class MPNSResponseTest extends LunrBaseTest
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
    public function setUpError()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $response->expects($this->once())
                 ->method('get_network_error_number')
                 ->will($this->returnValue(-1));

        $response->expects($this->once())
                 ->method('get_network_error_message')
                 ->will($this->returnValue('Error Message'));

        $map = [ [ 'http_code', 404 ], [ 'url', 'http://localhost/' ] ];

        $response->expects($this->exactly(2))
                 ->method('__get')
                 ->will($this->returnValueMap($map));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with(
                        $this->equalTo('Dispatching push notification to {endpoint} failed: {error}'),
                        $this->equalTo(['error' => 'Error Message', 'endpoint' => 'http://localhost/'])
                     );

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
        if (extension_loaded('http') === FALSE)
        {
            $this->markTestSkipped('Extension http is required.');
        }

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $response->expects($this->once())
                 ->method('get_network_error_number')
                 ->will($this->returnValue(0));

        $file = TEST_STATICS . '/Vortex/mpns_response.txt';
        $map  = [ [ 'http_code', 200 ], [ 'header_size', 129 ], [ 'url', 'http://localhost/' ] ];

        $response->expects($this->exactly(3))
                 ->method('__get')
                 ->will($this->returnValueMap($map));

        $response->expects($this->once())
                 ->method('get_result')
                 ->will($this->returnValue(file_get_contents($file)));

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
