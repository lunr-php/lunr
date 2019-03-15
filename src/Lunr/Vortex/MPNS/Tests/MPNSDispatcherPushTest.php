<?php

/**
 * This file contains the MPNSDispatcherPushTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSType;
use Lunr\Vortex\MPNS\MPNSPriority;
use Requests_Exception;

/**
 * This class contains test for the push() method of the MPNSDispatcher class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSDispatcher
 */
class MPNSDispatcherPushTest extends MPNSDispatcherTest
{

    /**
     * Test that pushing a Tile notification sets the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingTileSetsTargetHeader(): void
    {
        $this->payload = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSTilePayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => MPNSType::TILE,
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->once())
                   ->method('get_priority')
                   ->willReturn(0);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing a Toast notification sets the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingToastSetsTargetHeader(): void
    {
        $this->payload = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSToastPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => MPNSType::TOAST,
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->once())
                      ->method('get_priority')
                      ->willReturn(0);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing a Raw notification does not set the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingRawDoesNotSetTargetHeader(): void
    {
        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->once())
                      ->method('get_priority')
                      ->willReturn(0);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing with the default priority does not set the X-NotificationClass header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingWithDefaultPriorityDoesNotSetPriorityHeader(): void
    {
        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->once())
                      ->method('get_priority')
                      ->willReturn(0);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing with a valid priority sets the X-NotificationClass header.
     *
     * @param integer $priority Valid MPNS Priority
     *
     * @dataProvider validPriorityProvider
     * @covers       Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingWithValidPrioritySetsPriorityHeader($priority): void
    {
        $this->payload->set_priority($priority);

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'        => 'text/xml',
            'Accept'              => 'application/*',
            'X-NotificationClass' => $priority,
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->any())
                      ->method('get_priority')
                      ->willReturn($priority);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnError(): void
    {
        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->will($this->throwException(new Requests_Exception('Network problem!', 'curlerror', NULL)));

        $message = 'Dispatching push notification to {endpoint} failed: {error}';
        $context = [ 'error' => 'Network problem!', 'endpoint' => 'endpoint' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($message, $context);

        $this->payload->expects($this->any())
                      ->method('get_priority')
                      ->willReturn(0);

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push($this->payload, $endpoints));
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnSuccess(): void
    {
        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->any())
                      ->method('get_priority')
                      ->willReturn(0);

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push($this->payload, $endpoints));
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsPropertiesOnError(): void
    {
        $this->payload = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSToastPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->payload->set_priority(MPNSPriority::TOAST_IMMEDIATELY);

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => 'toast',
            'X-NotificationClass'   => 2,
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->will($this->throwException(new Requests_Exception('Network problem!', 'curlerror', NULL)));

        $this->payload->expects($this->any())
                      ->method('get_priority')
                      ->willReturn(2);

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsPropertiesOnSuccess(): void
    {
        $this->payload = $this->getMockBuilder('Lunr\Vortex\MPNS\MPNSToastPayload')
                              ->disableOriginalConstructor()
                              ->getMock();

        $this->payload->set_priority(MPNSPriority::TOAST_IMMEDIATELY);

        $endpoints = [ 'endpoint' ];

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => 'toast',
            'X-NotificationClass'   => 2,
        ];

        $this->payload->expects($this->once())
                      ->method('get_payload')
                      ->willReturn('payload');

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('endpoint', $headers, 'payload')
                   ->willReturn($this->response);

        $this->payload->expects($this->any())
                      ->method('get_priority')
                      ->willReturn(2);

        $this->class->push($this->payload, $endpoints);
    }

}

?>
