<?php

/**
 * This file contains the JPushDispatcherBaseTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushType;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the JPushDispatcher class.
 *
 * @covers \Lunr\Vortex\JPush\JPushDispatcher
 */
class JPushDispatcherBaseTest extends JPushDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the passed Requests_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly(): void
    {
        $this->assertPropertySame('http', $this->http);

        $this->assertSame(15, $this->http->options['timeout']);
        $this->assertSame(15, $this->http->options['connect_timeout']);
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
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::get_new_response_object_for_failed_request
     */
    public function testGetNewResponseObjectForFailedRequest(): void
    {
        $method = $this->get_accessible_reflection_method('get_new_response_object_for_failed_request');

        $result = $method->invoke($this->class);

        $this->assertInstanceOf('\Requests_Response', $result);
        $this->assertEquals('https://api.jpush.cn/v3/push', $result->url);
    }

    /**
     * Test that get_response() returns JPushResponseObject.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::get_response
     */
    public function testGetResponseReturnsJPushResponseObject(): void
    {
        $result = $this->class->get_response();

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushResponse', $result);
    }

    /**
     * Test that get_batch_response() returns JPushBatchResponse.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::get_batch_response
     */
    public function testGetBatchResponseReturnsJPushBatchResponseObject(): void
    {
        $this->http->expects($this->at(0))
                   ->method('__get')
                   ->with('success')
                   ->will($this->returnValue(FALSE));

        $method = $this->get_accessible_reflection_method('get_batch_response');
        $result = $method->invokeArgs($this->class, [ $this->http, $this->logger, [ 'endpoint' ], '{}' ]);

        $this->assertInstanceOf('Lunr\Vortex\JPush\JPushBatchResponse', $result);
    }

}

?>
