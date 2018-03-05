<?php

/**
 * This file contains the GCMDispatcherSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

/**
 * This class contains tests for the setters of the GCMDispatcher class.
 *
 * @covers Lunr\Vortex\GCM\GCMDispatcher
 */
class GCMDispatcherSetTest extends GCMDispatcherTest
{

    /**
     * Test that set_endpoints() sets unique endpoint with single parameter.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoints
     */
    public function testSetEndpointsSetUniqueEndpointWithString()
    {
        $this->class->set_endpoints('endpoint');

        $this->assertPropertyEquals('endpoints', [ 'endpoint' ]);
    }

    /**
     * Test that set_endpoints() set endpoints list with array parameter.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoints
     */
    public function testSetEndpointsSetEndpointsListWithArray()
    {
        $this->class->set_endpoints([ 'endpoint1', 'endpoint2' ]);

        $this->assertPropertyEquals('endpoints', [ 'endpoint1', 'endpoint2' ]);
    }

    /**
     * Test that set_endpoints() set empty endpoints list with empty array parameter.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoints
     */
    public function testSetEndpointsSetEmptyEndpointsListWithEmptyArray()
    {
        $this->class->set_endpoints([]);

        $this->assertPropertyEquals('endpoints', []);
    }

    /**
     * Test the fluid interface of set_endpoints().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_endpoints
     */
    public function testSetEndpointsReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoints('endpoint'));
    }

    /**
     * Test that set_payload() sets the payload.
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
        $this->class->set_auth_token('auth_token');

        $this->assertPropertyEquals('auth_token', 'auth_token');
    }

    /**
     * Test the fluid interface of set_auth_token().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_auth_token
     */
    public function testSetAuthTokenReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_auth_token('auth_token'));
    }

    /**
     * Test that set_priority() sets the priority.
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_priority
     */
    public function testSetPrioritySetsPayload()
    {
        $this->class->set_priority('priority');

        $this->assertPropertyEquals('priority', 'priority');
    }

    /**
     * Test the fluid interface of set_priority().
     *
     * @covers Lunr\Vortex\GCM\GCMDispatcher::set_priority
     */
    public function testSetPriorityReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_priority('high'));
    }

}

?>
