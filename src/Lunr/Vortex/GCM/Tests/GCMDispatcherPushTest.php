<?php

/**
 * This file contains the GCMDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;


/**
 * This class contains test for the push() method of the GCMDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherPushTest extends GCMDispatcherTest
{

    /**
     * Test that push() returns GCMResponseObject.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
     */
    public function testPushReturnsGCMResponseObject()
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
                   ->with($this->config['gcm']['google_send_url'], $this->equalTo('{"registration_ids":["endpoint"]}'))
                   ->will($this->returnValue($response));

        $this->assertInstanceOf('Lunr\Vortex\GCM\GCMResponse', $this->class->push());
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::push
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
                   ->with($this->config['gcm']['google_send_url'], $this->equalTo('{"registration_ids":["endpoint"]}'))
                   ->will($this->returnValue($response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertPropertyEquals('auth_token', '');
    }

}

?>