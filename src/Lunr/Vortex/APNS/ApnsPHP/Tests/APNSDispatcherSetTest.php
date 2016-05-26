<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

/**
 * This class contains tests for the setters of the APNSDispatcher class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher
 */
class APNSDispatcherSetTest extends APNSDispatcherTest
{

    /**
     * Test that set_endpoints() sets unique endpoint with single parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoints
     */
    public function testSetEndpointsSetUniqueEndpointWithString()
    {
        $this->class->set_endpoints('endpoint');

        $this->assertPropertyEquals('endpoints', [ 'endpoint' ]);
    }

    /**
     * Test that set_endpoints() set endpoints list with array parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoints
     */
    public function testSetEndpointsSetEndpointsListWithArray()
    {
        $this->class->set_endpoints([ 'endpoint1', 'endpoint2' ]);

        $this->assertPropertyEquals('endpoints', [ 'endpoint1', 'endpoint2' ]);
    }

    /**
     * Test that set_endpoints() set empty endpoints list with empty array parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoints
     */
    public function testSetEndpointsSetEmptyEndpointsListWithEmptyArray()
    {
        $this->class->set_endpoints([]);

        $this->assertPropertyEquals('endpoints', []);
    }

    /**
     * Test the fluid interface of set_endpoints().
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoints
     */
    public function testSetEndpointsReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoints('endpoint'));
    }

    /**
     * Test that set_payload() sets the payload.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_payload
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
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_payload
     */
    public function testSetPayloadReturnsSelfReference()
    {
        $payload = 'payload';
        $this->assertEquals($this->class, $this->class->set_payload($payload));
    }

}

?>
