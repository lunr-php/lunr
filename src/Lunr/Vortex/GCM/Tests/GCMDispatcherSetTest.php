<?php

/**
 * This file contains the GCMDispatcherSetTest class.
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
 * This class contains tests for the setters of the GCMDispatcher class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherSetTest extends GCMDispatcherTest
{

    /**
     * Test that set_endpoint() sets the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoint
     */
    public function testSetEndpointSetsEndpoint()
    {
        $this->class->set_endpoint('endpoint');

        $this->assertPropertyEquals('endpoint', 'endpoint');
    }

    /**
     * Test the fluid interface of set_endpoint().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoint
     */
    public function testSetEndpointReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoint('endpoint'));
    }

    /**
     * Test that set_payload() sets the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_payload
     */
    public function testSetPayloadSetsPayload()
    {
        $payload = 'payload';
        $this->class->set_payload($payload);

        $this->assertPropertyEquals('payload', 'payload');
    }

    /**
     * Test the fluid interface of set_payload().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_payload
     */
    public function testSetPayloadReturnsSelfReference()
    {
        $payload = 'payload';
        $this->assertEquals($this->class, $this->class->set_payload($payload));
    }

    /**
     * Test that set_auth_token() sets the endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenSetsPayload()
    {
        $auth_token = 'auth_token';
        $this->class->set_auth_token($auth_token);

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference()
    {
        $auth_token = 'auth_token';
        $this->assertEquals($this->class, $this->class->set_auth_token($auth_token));
    }

}

?>