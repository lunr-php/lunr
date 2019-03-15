<?php

/**
 * This file contains the GCMDispatcherTest class.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\GCM\GCMDispatcher;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the GCMDispatcher class.
 *
 * @covers Lunr\Vortex\GCM\GCMDispatcher
 */
abstract class GCMDispatcherTest extends LunrBaseTest
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
     * Mock instance of the GCM Payload class.
     * @var GCMPayload
     */
    protected $payload;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->http   = $this->getMockBuilder('Requests_Session')->getMock();
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->payload = $this->getMockBuilder('Lunr\Vortex\GCM\GCMPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->class = new GCMDispatcher($this->http, $this->logger);

        $this->constant_redefine('Lunr\Vortex\GCM\GCMDispatcher::BATCH_SIZE', 2);

        $this->reflection = new ReflectionClass('Lunr\Vortex\GCM\GCMDispatcher');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->logger);
        unset($this->payload);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that get_response() returns GCMResponseObject.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::get_response
     */
    public function testGetResponseReturnsGCMResponseObject(): void
    {
        $result = $this->class->get_response();

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $result);
    }

    /**
     * Test that get_batch_response() returns GCMBatchResponse.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::get_batch_response
     */
    public function testGetBatchResponseReturnsGCMBatchResponseObject(): void
    {
        $this->http->expects($this->at(0))
                   ->method('__get')
                   ->with('status_code')
                   ->will($this->returnValue(500));

        $method = $this->get_accessible_reflection_method('get_batch_response');
        $result = $method->invokeArgs($this->class, [ $this->http, $this->logger, [ 'endpoint' ] ]);

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMBatchResponse', $result);
    }

}

?>
