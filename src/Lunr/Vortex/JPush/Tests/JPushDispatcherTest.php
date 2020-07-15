<?php

/**
 * This file contains the JPushDispatcherTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushDispatcher;
use Lunr\Halo\LunrBaseTest;
use Lunr\Vortex\JPush\JPushPayload;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the JPushDispatcher class.
 *
 * @covers \Lunr\Vortex\JPush\JPushDispatcher
 */
abstract class JPushDispatcherTest extends LunrBaseTest
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
     * Mock instance of the JPush Payload class.
     * @var JPushPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->http   = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\JPush\JPushPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new JPushDispatcher($this->http, $this->logger);

        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->http);
        unset($this->logger);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
