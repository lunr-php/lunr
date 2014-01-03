<?php

/**
 * This file contains the GCMResponseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMResponse;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMResponse class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMResponse
 */
abstract class GCMResponseTest extends LunrBaseTest
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

        $map = [ [ 'http_code', 503 ] ];

        $response->expects($this->exactly(1))
                 ->method('__get')
                 ->will($this->returnValueMap($map));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with(
                        $this->equalTo('Dispatching push notification to {endpoint} failed: {error}'),
                        $this->equalTo(['error' => 'Error Message', 'endpoint' => '12345679'])
                     );

        $this->class      = new GCMResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $response->expects($this->once())
                 ->method('get_network_error_number')
                 ->will($this->returnValue(0));

        $file = TEST_STATICS . '/Vortex/gcm_response.json';
        $map  = [ [ 'http_code', 200 ], [ 'header_size', 176 ] ];

        $response->expects($this->once())
                 ->method('__get')
                 ->will($this->returnValueMap($map));

        $response->expects($this->once())
                 ->method('get_result')
                 ->will($this->returnValue(file_get_contents($file)));

        $this->class      = new GCMResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMResponse');
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
        $requests[] = [ 400, PushNotificationStatus::ERROR ];
        $requests[] = [ 401, PushNotificationStatus::INVALID_ENDPOINT ];
        $requests[] = [ 503, PushNotificationStatus::ERROR ];
        $requests[] = [ 500, PushNotificationStatus::UNKNOWN ];

        return $requests;
    }

}
