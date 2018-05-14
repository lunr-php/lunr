<?php

/**
 * This file contains the PAPDispatcherTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PAP\PAPDispatcher;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the PAPDispatcher class.
 *
 * @covers Lunr\Vortex\PAP\PAPDispatcher
 */
abstract class PAPDispatcherTest extends LunrBaseTest
{
    /**
     * Mock instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Mock instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Mock instance of the Requests_Response class.
     * @var \Requests_Response
     */
    protected $response;

    /**
     * Mock instance of the PAP Payload class.
     * @var PAPPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->http     = $this->getMockBuilder('Requests_Session')->getMock();
        $this->response = $this->getMockBuilder('Requests_Response')->getMock();
        $this->logger   = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\PAP\PAPPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new PAPDispatcher($this->http, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\PAP\PAPDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->logger);
        unset($this->http);
        unset($this->response);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
