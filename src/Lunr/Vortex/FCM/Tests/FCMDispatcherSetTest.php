<?php

/**
 * This file contains the FCMDispatcherSetTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the setters of the FCMDispatcher class.
 *
 * @covers Lunr\Vortex\FCM\FCMDispatcher
 */
class FCMDispatcherSetTest extends FCMDispatcherTest
{

    /**
     * Test that set_auth_token() sets the endpoint.
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsPayload(): void
    {
        $this->class->set_auth_token('auth_token');

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\FCM\FCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference(): void
    {
        $this->assertEquals($this->class, $this->class->set_auth_token('auth_token'));
    }

}

?>
