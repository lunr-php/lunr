<?php

/**
 * This file contains the PAPDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

/**
 * This class contains test for the push() method of the PAPDispatcher class.
 *
 * @covers Lunr\Vortex\PAP\PAPDispatcher
 */
class PAPDispatcherPushTest extends PAPDispatcherTest
{

    /**
     * Test that push() returns PAPResponseObject.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushReturnsPAPResponseObject()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', '12345');

        $auth = $this->get_reflection_property_value('auth_token') . ':' . $this->get_reflection_property_value('password');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->at(0))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_URL'), 'https://cpcid.pushapi.na.blackberry.com/mss/PD_pushRequest');

        $this->curl->expects($this->at(1))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_HEADER'), $this->equalTo(FALSE));

        $this->curl->expects($this->at(2))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_HTTP_VERSION'), $this->equalTo(CURL_HTTP_VERSION_1_1));

        $this->curl->expects($this->at(3))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_HTTPAUTH'), $this->equalTo(CURLAUTH_BASIC));

        $this->curl->expects($this->at(4))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_USERPWD'), $auth);

        $this->curl->expects($this->at(5))
                   ->method('set_option')
                   ->with($this->equalTo('CURLOPT_RETURNTRANSFER'), $this->equalTo(TRUE));

        $this->curl->expects($this->at(6))
                   ->method('set_http_header')
                   ->with('Content-Type: multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml');

        $this->curl->expects($this->at(7))
                   ->method('set_http_header')
                   ->with('Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2');

        $this->curl->expects($this->at(8))
                   ->method('set_http_header')
                   ->with('Connection: keep-alive');

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($response));

        $this->assertInstanceOf('Lunr\Vortex\PAP\PAPResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', 'payload');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', 'endpoint12345');

        $response = $this->getMockBuilder('Lunr\Network\CurlResponse')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->curl->expects($this->once())
                   ->method('post_request')
                   ->will($this->returnValue($response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('push_id', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertPropertyEquals('deliverbefore', '');
    }

}

?>
