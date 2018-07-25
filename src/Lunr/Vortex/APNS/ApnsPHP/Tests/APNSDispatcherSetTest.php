<?php

/**
 * This file contains the APNSDispatcherTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
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
     * Test that set_endpoint() sets unique endpoint with single parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointWithString()
    {
        $this->class->set_endpoint('endpoint');

        $this->assertPropertyEquals('endpoint', 'endpoint');
    }

    /**
     * Test that set_endpoint() set endpoints list with array parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointWithArray()
    {
        $this->class->set_endpoint([ 'endpoint1', 'endpoint2' ]);

        $this->assertPropertyEquals('endpoint', 'endpoint1');
    }

    /**
     * Test that set_endpoint() set empty endpoints list with empty array parameter.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointWithNull()
    {
        $this->class->set_endpoint(NULL);

        $this->assertPropertyEquals('endpoint', NULL);
    }

    /**
     * Test the fluid interface of set_endpoint().
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSDispatcher::set_endpoint
     */
    public function testSetEndpointReturnsSelfReference()
    {
        $this->assertEquals($this->class, $this->class->set_endpoint('endpoint'));
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
