<?php

/**
 * This file contains the MPNSDispatcherPushTest class.
 *
 * PHP Version 5.4
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
    public function testPushingTileSetsTargetHeader()
    {
        $this->set_reflection_property_value('type', MPNSType::TILE);

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

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing a Toast notification sets the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingToastSetsTargetHeader()
    {
        $this->set_reflection_property_value('type', MPNSType::TOAST);

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

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing a Raw notification does not set the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingRawDoesNotSetTargetHeader()
    {
        $this->set_reflection_property_value('type', MPNSType::RAW);

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

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that pushing with the default priority does not set the X-NotificationClass header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingWithDefaultPriorityDoesNotSetPriorityHeader()
    {
        $this->set_reflection_property_value('priority', 0);

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
    public function testPushingWithValidPrioritySetsPriorityHeader($priority)
    {
        $this->set_reflection_property_value('priority', $priority);

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

        $this->class->push($this->payload, $endpoints);
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnError()
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

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push($this->payload, $endpoints));
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnSuccess()
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

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push($this->payload, $endpoints));
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsPropertiesOnError()
    {
        $this->set_reflection_property_value('priority', MPNSPriority::TOAST_IMMEDIATELY);
        $this->set_reflection_property_value('type', MPNSType::TOAST);

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

        $this->class->push($this->payload, $endpoints);

        $this->assertSame(0, $this->get_reflection_property_value('priority'));
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsPropertiesOnSuccess()
    {
        $this->set_reflection_property_value('priority', MPNSPriority::TOAST_IMMEDIATELY);
        $this->set_reflection_property_value('type', MPNSType::TOAST);

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

        $this->class->push($this->payload, $endpoints);

        $this->assertSame(0, $this->get_reflection_property_value('priority'));
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

}

?>
