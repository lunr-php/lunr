<?php

/**
 * This file contains the PAPResponseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PAP\PAPResponse;
use Lunr\Vortex\PushNotificationStatus;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PAPResponse class.
 *
 * @covers Lunr\Vortex\PAP\PAPResponse
 */
abstract class PAPResponseTest extends LunrBaseTest
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
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMock('Requests_Response');

        $response->status_code = FALSE;

        $this->class      = new PAPResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpInvalidXMLError()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $response = $this->getMock('Requests_Response');

        $response->status_code = 200;

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        $this->equalTo('Parsing response of push notification to {endpoint} failed: {error}'),
                        $this->equalTo(['error' => 'Invalid document end', 'endpoint' => '12345679'])
                     );

        $this->class      = new PAPResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess()
    {
        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $file = TEST_STATICS . '/Vortex/pap/response.xml';

        $response = $this->getMock('Requests_Response');

        $response->status_code = 200;
        $response->body        = file_get_contents($file);

        $this->class      = new PAPResponse($response, $this->logger, '12345679');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
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
