<?php

/**
 * This file contains the JPushDispatcherSetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the setters of the JPushDispatcher class.
 *
 * @covers \Lunr\Vortex\JPush\JPushDispatcher
 */
class JPushDispatcherSetTest extends JPushDispatcherTest
{

    /**
     * Test that set_auth_token() sets the endpoint.
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsPayload(): void
    {
        $this->class->set_auth_token('auth_token');

        $this->assertSame('Basic auth_token', $this->http->headers['Authorization']);
        $this->assertSame('application/json', $this->http->headers['Content-Type']);

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers \Lunr\Vortex\JPush\JPushDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference(): void
    {
        $this->assertEquals($this->class, $this->class->set_auth_token('auth_token'));
    }

}

?>
