<?php

/**
 * This file contains the PAPResponseTest class.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
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
    public function setUpError(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->status_code = FALSE;

        $this->class      = new PAPResponse($response, $this->logger, '12345679', '<?xml version="1.0"?>');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpInvalidXMLError(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->status_code = 200;

        $error = version_compare('7.4.0', PHP_VERSION, '<=') ? 'Invalid document end' : 'no element found';


        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                        $this->equalTo('Parsing response of push notification to {endpoint} failed: {error}'),
                        $this->equalTo([ 'error' => $error, 'endpoint' => '12345679' ])
                     );

        $this->class      = new PAPResponse($response, $this->logger, '12345679', '<?xml version="1.0"?>');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
    }

    /**
     * Testcase Constructor.
     *
     * @return void
     */
    public function setUpSuccess(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $file = TEST_STATICS . '/Vortex/pap/response.xml';

        $response = $this->getMockBuilder('Requests_Response')->getMock();

        $response->status_code = 200;
        $response->body        = file_get_contents($file);

        $this->class      = new PAPResponse($response, $this->logger, '12345679', '<?xml version="1.0"?>');
        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPResponse');
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
     * Unit test data provider for special status codes.
     *
     * @return array $statuses Array of special statuses
     */
    public function specialStatusProvider(): array
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
    public function failedRequestProvider(): array
    {
        $requests   = [];
        $requests[] = [ 400, PushNotificationStatus::ERROR ];
        $requests[] = [ 401, PushNotificationStatus::INVALID_ENDPOINT ];
        $requests[] = [ 503, PushNotificationStatus::ERROR ];
        $requests[] = [ 500, PushNotificationStatus::UNKNOWN ];

        return $requests;
    }

}
