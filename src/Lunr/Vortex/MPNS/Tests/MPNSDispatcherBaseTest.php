<?php

/**
 * This file contains the MPNSDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\MPNS\MPNSType;
use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the MPNSDispatcher class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSDispatcher
 */
class MPNSDispatcherBaseTest extends MPNSDispatcherTest
{

    use PsrLoggerTestTrait;

    /**
     * Test that the endpoint is set to an empty string by default.
     */
    public function testEndpointsIsEmptyString()
    {
        $this->assertPropertyEquals('endpoint', '');
    }

    /**
     * Test that the payload is set to an empty string by default.
     */
    public function testPayloadIsEmptyString()
    {
        $this->assertPropertyEquals('payload', '');
    }

    /**
     * Test that the priority is set to 0 by default.
     */
    public function testPriorityIsZero()
    {
        $this->assertSame(0, $this->get_reflection_property_value('priority'));
    }

    /**
     * Test that the passed Requests_Session object is set correctly.
     */
    public function testRequestsSessionIsSetCorrectly()
    {
        $this->assertSame($this->http, $this->get_reflection_property_value('http'));
    }

    /**
     * Test that the type is set to RAW by default.
     */
    public function testTypeIsSetToRaw()
    {
        $this->assertSame(MPNSType::RAW, $this->get_reflection_property_value('type'));
    }

    /**
     * Test get_new_response_object_for_failed_request().
     *
     * @covers Lunr\Vortex\MPNS\MPNSDispatcher::get_new_response_object_for_failed_request
     */
    public function testGetNewResponseObjectForFailedRequest()
    {
        $this->set_reflection_property_value('endpoint', 'http://localhost/');

        $method = $this->get_accessible_reflection_method('get_new_response_object_for_failed_request');

        $result = $method->invoke($this->class);

        $this->assertInstanceOf('\Requests_Response', $result);
        $this->assertEquals('http://localhost/', $result->url);
    }

}

?>
