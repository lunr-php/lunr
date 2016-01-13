<?php

/**
 * This file contains the WNSResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
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
     * Mock instance of the Header class.
     * @var \http\Header
     */
    protected $header;

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpError()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->header = $this->getMock('http\Header');

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
                     ->method('warning')
                     ->with(
                        $this->equalTo('Dispatching push notification to {endpoint} failed: {error}'),
                        $this->equalTo(['error' => 'Error Message', 'endpoint' => 'http://localhost/'])
                     );

        $this->class      = new WNSResponse($response, $this->logger, $this->header);
        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        if (extension_loaded('http') === FALSE || empty(get_extension_funcs('http')) === FALSE)
        {
            $this->markTestSkipped('Extension http (2.x) is required.');
        }

        $this->header = $this->getMock('http\Header', [ 'parse' ]);

        $method = [ get_class($this->header), 'parse' ];
        $parsed = file_get_contents(TEST_STATICS . '/Vortex/wns_response_parsed.txt');

        $this->mock_method($method, "return $parsed;");

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $response->expects($this->once())
                 ->method('get_network_error_number')
                 ->will($this->returnValue(0));

        $file = TEST_STATICS . '/Vortex/wns_response.txt';
        $map  = [ [ 'http_code', 200 ], [ 'header_size', 129 ], [ 'url', 'http://localhost/' ] ];

        $response->expects($this->exactly(3))
                 ->method('__get')
                 ->will($this->returnValueMap($map));

        $response->expects($this->once())
                 ->method('get_result')
                 ->will($this->returnValue(file_get_contents($file)));

        $this->class      = new WNSResponse($response, $this->logger, $this->header);
        $this->reflection = new ReflectionClass('Lunr\Vortex\WNS\WNSResponse');

        $this->unmock_method($method);
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
