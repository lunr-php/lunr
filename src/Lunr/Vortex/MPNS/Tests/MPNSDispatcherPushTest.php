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
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', MPNSType::TILE);

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => MPNSType::TILE,
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();
    }

    /**
     * Test that pushing a Toast notification sets the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingToastSetsTargetHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', MPNSType::TOAST);

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => MPNSType::TOAST,
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();
    }

    /**
     * Test that pushing a Raw notification does not set the X-WindowsPhone-Target header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingRawDoesNotSetTargetHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', MPNSType::RAW);

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();
    }

    /**
     * Test that pushing with the default priority does not set the X-NotificationClass header.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingWithDefaultPriorityDoesNotSetPriorityHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', 0);

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();
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
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', $priority);

        $headers = [
            'Content-Type'        => 'text/xml',
            'Accept'              => 'application/*',
            'X-NotificationClass' => $priority,
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnError()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->throwException(new Requests_Exception('Network problem!', 'curlerror', NULL)));

        $message = 'Dispatching push notification to {endpoint} failed: {error}';
        $context = [ 'error' => 'Network problem!', 'endpoint' => 'endpoint' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push());
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObjectOnSuccess()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsPropertiesOnError()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', MPNSPriority::TOAST_IMMEDIATELY);
        $this->set_reflection_property_value('type', MPNSType::TOAST);

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => 'toast',
            'X-NotificationClass'   => 2,
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->throwException(new Requests_Exception('Network problem!', 'curlerror', NULL)));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
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
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', MPNSPriority::TOAST_IMMEDIATELY);
        $this->set_reflection_property_value('type', MPNSType::TOAST);

        $headers = [
            'Content-Type'          => 'text/xml',
            'Accept'                => 'application/*',
            'X-WindowsPhone-Target' => 'toast',
            'X-NotificationClass'   => 2,
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo('endpoint'), $this->equalTo($headers), $this->equalTo('payload'))
                   ->will($this->returnValue($this->response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertSame(0, $this->get_reflection_property_value('priority'));
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

}

?>
