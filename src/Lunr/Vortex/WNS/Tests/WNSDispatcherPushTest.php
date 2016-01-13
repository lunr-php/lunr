<?php

/**
 * This file contains the WNSDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSType;

/**
 * This class contains test for the push() method of the WNSDispatcher class.
 *
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
class WNSDispatcherPushTest extends WNSDispatcherTest
{

    /**
     * Test that the response will be null if no authentication is done.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushingWithoutOauthReturnsNull()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->never())
                   ->method('set_http_headers')
                   ->with($this->equalTo(
                       [
                           'X-WNS-Type: wns/tile',
                           'Accept: application/*',
                           'Authenication: Bearer 123456',
                           'X-WNS-RequestForStatus: true',
                       ]));
                       $this->curl->expects($this->never())
                       ->method('set_http_header')
                       ->with($this->equalTo('Content-Type: text/xml'));

                       $this->curl->expects($this->never())
                       ->method('post_request')
                       ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                       ->will($this->returnValue($response));

                       $this->logger->expects($this->once())
                       ->method('warning')
                       ->with(
                         $this->equalTo('Tried to push notification to {endpoint} but wasn\'t authenticated.'),
                         $this->equalTo(['endpoint' => 'endpoint'])
                       );

                       $this->assertNull($this->class->push());
    }

    /**
     * Test that pushing a Tile notification sets the X-WNS-Type header.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushingTileSetsTargetHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', WNSType::TILE);
        $this->set_reflection_property_value('oauth_token', '123456');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo(
                       [
                           'X-WNS-Type: wns/tile',
                           'Accept: application/*',
                           'Authenication: Bearer 123456',
                           'X-WNS-RequestForStatus: true',
                       ]));
                       $this->curl->expects($this->once())
                       ->method('set_http_header')
                       ->with($this->equalTo('Content-Type: text/xml'));

                       $this->curl->expects($this->once())
                       ->method('post_request')
                       ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                       ->will($this->returnValue($response));

                       $this->class->push();
    }

    /**
     * Test that pushing a Toast notification sets the X-WNS-Type header.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushingToastSetsTargetHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', WNSType::TOAST);
        $this->set_reflection_property_value('oauth_token', '123456');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo(
                       [
                           'X-WNS-Type: wns/toast',
                           'Accept: application/*',
                           'Authenication: Bearer 123456',
                           'X-WNS-RequestForStatus: true',
                       ]));
                       $this->curl->expects($this->once())
                       ->method('set_http_header')
                       ->with($this->equalTo('Content-Type: text/xml'));

                       $this->curl->expects($this->once())
                       ->method('post_request')
                       ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                       ->will($this->returnValue($response));

                       $this->class->push();
    }

    /**
     * Test that pushing a Raw notification does not set the X-WNS-Type header.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushingRawDoesNotSetTargetHeader()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('oauth_token', '123456');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_http_header')
                   ->with($this->equalTo('Content-Type: application/octet-stream'));

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                   ->will($this->returnValue($response));

        $this->class->push();
    }

    /**
     * Test that push() returns WNSResponseObject.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushReturnsWNSResponseObject()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('oauth_token', '123456');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_HEADER'), $this->equalTo(TRUE));

        $this->curl->expects($this->once())
                   ->method('set_http_headers')
                   ->with($this->equalTo(
                       [
                           'X-WNS-Type: wns/raw',
                           'Accept: application/*',
                           'Authenication: Bearer 123456',
                           'X-WNS-RequestForStatus: true',
                       ]));

                       $this->curl->expects($this->once())
                       ->method('post_request')
                       ->with($this->equalTo('endpoint'), $this->equalTo('payload'))
                       ->will($this->returnValue($response));

                       $this->assertInstanceOf('Lunr\Vortex\WNS\WNSResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('type', WNSType::TOAST);
        $this->set_reflection_property_value('oauth_token', '123456');

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
        $this->assertSame(WNSType::RAW, $this->get_reflection_property_value('type'));
    }

}

?>
