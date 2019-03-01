<?php

/**
 * This file contains the FCMDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains test for the push() method of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherPushTest extends FCMDispatcherTest
{

    /**
     * Test that push() returns FCMResponseObject.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushReturnsFCMResponseObject()
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
                   ->method('set_http_headers');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with('https://fcm.googleapis.com/fcm/send', $this->equalTo('{"to":"endpoint","priority":"normal"}'))
                   ->will($this->returnValue($response));

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('auth_token', 'auth_token');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->with('https://fcm.googleapis.com/fcm/send', $this->equalTo('{"to":"endpoint","priority":"normal"}'))
                   ->will($this->returnValue($response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
    }

}

?>
