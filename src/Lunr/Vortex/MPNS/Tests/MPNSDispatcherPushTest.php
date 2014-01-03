<?php

/**
 * This file contains the MPNSDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSType;
use Lunr\Vortex\MPNS\MPNSPriority;

/**
 * This class contains test for the push() method of the MPNSDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSDispatcher
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

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_header')
                   ->with($this->equalTo('X-WindowsPhone-Target: ' . MPNSType::TILE));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

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

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_header')
                   ->with($this->equalTo('X-WindowsPhone-Target: ' . MPNSType::TOAST));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

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

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->never())
                   ->method('set_http_header');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

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

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->never())
                   ->method('set_http_header');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that pushing with a valid priority sets the X-NotificationClass header.
     *
     * @param Integer $priority Valid MPNS Priority
     *
     * @dataProvider validPriorityProvider
     * @covers       Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushingWithValidPrioritySetsPriorityHeader($priority)
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', $priority);

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_header')
                   ->with($this->equalTo('X-NotificationClass: ' . $priority));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that push() returns MPNSResponseObject.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushReturnsMPNSResponseObject()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_HEADER'), $this->equalTo(TRUE));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo([ 'Content-Type: text/xml', 'Accept: application/*' ]));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

        $this->assertInstanceOf('Lunr\Vortex\MPNS\MPNSResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('priority', MPNSPriority::TOAST_IMMEDIATELY);
        $this->set_reflection_property_value('type', MPNSType::TOAST);

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertSame(0, $this->get_reflection_property_value('priority'));
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

}

?>
