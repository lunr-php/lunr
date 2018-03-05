<?php

/**
 * This file contains the PAPDispatcherPushTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Requests_Exception;

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
     * @covers   Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushReturnsPAPResponseObjectOnRequestFailure()
    {
        $this->mock_function('microtime', 'return 12345;');

        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"message":"test"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', '12345');

        $headers = [
            'Content-Type' => 'multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml',
            'Accept'       => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2',
            'Connection'   => 'keep-alive',
        ];

        $url = 'https://cpcid.pushapi.na.blackberry.com/mss/PD_pushRequest';

        $xml = file_get_contents(TEST_STATICS . '/Vortex/pap/request_custom_headers.txt');

        $options = [
            'auth' => [
                'auth_token',
                'password',
            ],
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($xml), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $message = 'Dispatching push notification to {endpoint} failed: {error}';
        $context = [ 'endpoint' => 'endpoint', 'error' => 'Network error!' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->assertInstanceOf('Lunr\Vortex\PAP\PAPResponse', $this->class->push());

        $this->unmock_function('microtime');
    }

    /**
     * Test that push() returns PAPResponseObject.
     *
     * @covers   Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushReturnsPAPResponseObject()
    {
        $this->mock_function('microtime', 'return 12345;');

        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"message":"test"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', '12345');

        $headers = [
            'Content-Type' => 'multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml',
            'Accept'       => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2',
            'Connection'   => 'keep-alive',
        ];

        $url = 'https://cpcid.pushapi.na.blackberry.com/mss/PD_pushRequest';

        $xml = file_get_contents(TEST_STATICS . '/Vortex/pap/request_custom_headers.txt');

        $options = [
            'auth' => [
                'auth_token',
                'password',
            ],
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($xml), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->response->status_code = 200;
        $this->response->body        = file_get_contents(TEST_STATICS . '/Vortex/pap/response.xml');

        $this->assertInstanceOf('Lunr\Vortex\PAP\PAPResponse', $this->class->push());

        $this->unmock_function('microtime');
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers   Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushResetsPropertiesOnRequestFailure()
    {
        $this->mock_function('microtime', 'return 12345;');

        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"message":"test"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', 'endpoint12345');

        $headers = [
            'Content-Type' => 'multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml',
            'Accept'       => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2',
            'Connection'   => 'keep-alive',
        ];

        $url = 'https://cpcid.pushapi.na.blackberry.com/mss/PD_pushRequest';

        $xml = file_get_contents(TEST_STATICS . '/Vortex/pap/request_custom_headers.txt');

        $options = [
            'auth' => [
                'auth_token',
                'password',
            ],
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($xml), $this->equalTo($options))
                   ->will($this->throwException(new Requests_Exception('Network error!', 'curlerror', NULL)));

        $message = 'Dispatching push notification to {endpoint} failed: {error}';
        $context = [ 'endpoint' => 'endpoint', 'error' => 'Network error!' ];

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('push_id', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertPropertyEquals('deliverbefore', '');

        $this->unmock_function('microtime');
    }

    /**
     * Test that push() resets the properties after a push.
     *
     * @covers   Lunr\Vortex\PAP\PAPDispatcher::push
     */
    public function testPushResetsProperties()
    {
        $this->mock_function('microtime', 'return 12345;');

        $this->set_reflection_property_value('endpoint', 'endpoint');
        $this->set_reflection_property_value('payload', '{"message":"test"}');
        $this->set_reflection_property_value('auth_token', 'auth_token');
        $this->set_reflection_property_value('password', 'password');
        $this->set_reflection_property_value('cid', 'cid');
        $this->set_reflection_property_value('deliverbefore', 'deliverbefore');
        $this->set_reflection_property_value('push_id', 'endpoint12345');

        $headers = [
            'Content-Type' => 'multipart/related; boundary=mPsbVQo0a68eIL3OAxnm; type=application/xml',
            'Accept'       => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2',
            'Connection'   => 'keep-alive',
        ];

        $url = 'https://cpcid.pushapi.na.blackberry.com/mss/PD_pushRequest';

        $xml = file_get_contents(TEST_STATICS . '/Vortex/pap/request_custom_headers.txt');

        $options = [
            'auth' => [
                'auth_token',
                'password',
            ],
        ];

        $this->http->expects($this->once())
                   ->method('post')
                   ->with($this->equalTo($url), $this->equalTo($headers), $this->equalTo($xml), $this->equalTo($options))
                   ->will($this->returnValue($this->response));

        $this->class->push();

        $this->assertPropertyEquals('endpoint', '');
        $this->assertPropertyEquals('push_id', '');
        $this->assertPropertyEquals('payload', '');
        $this->assertPropertyEquals('deliverbefore', '');

        $this->unmock_function('microtime');
    }

}

?>
