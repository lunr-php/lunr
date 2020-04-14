<?php

/**
 * This file contains the FCMDispatcherBaseTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMType;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherBaseTest extends FCMDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requests_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);
    }

    /**
     * Test that the auth token is set to an empty string by default.
     */
    public function testAuthTokenIsEmptyString(): void
    {
        $this->assertPropertyEquals('auth_token', '');
    }

    /**
     * Test get_new_response_object_for_failed_request().
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::get_new_response_object_for_failed_request
     */
    public function testGetNewResponseObjectForFailedRequest(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_response_object_for_failed_request');

        $result = $method->invoke($this->class);

        $this->assertInstanceOf('\Requests_Response', $result);
        $this->assertEquals('https://fcm.googleapis.com/fcm/send', $result->url);
    }

    /**
     * Test that get_response() returns FCMResponseObject.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::get_response
     */
    public function testGetResponseReturnsFCMResponseObject(): void
    {
        $result = $this->class->get_response();

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMResponse', $result);
    }

    /**
     * Test that get_batch_response() returns FCMBatchResponse.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::get_batch_response
     */
    public function testGetBatchResponseReturnsFCMBatchResponseObject(): void
    {
        $this->http->expects($this->at(0))
                   ->method('__get')
                   ->with('status_code')
                   ->will($this->returnValue(500));

        $method = $this->get_accessible_reflection_method('get_batch_response');
        $result = $method->invokeArgs($this->class, [ $this->http, $this->logger, [ 'endpoint' ], '{}' ]);

        $this->assertInstanceOf('Lunr\Vortex\FCM\FCMBatchResponse', $result);
    }

}

?>
