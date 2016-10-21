<?php

/**
 * This file contains the WNSDispatcherBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\WNS\WNSType;
use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains test for the constructor of the WNSDispatcher class.
 *
 * @covers Lunr\Vortex\WNS\WNSDispatcher
 */
class WNSDispatcherBaseTest extends WNSDispatcherTest
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
     * Test that the passed Requesys_Session object is set correctly.
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
        $this->assertSame(WNSType::RAW, $this->get_reflection_property_value('type'));
    }

    /**
     * Test get_new_response_object_for_failed_request().
     *
     * @covers Lunr\Vortex\WNS\WNSDispatcher::get_new_response_object_for_failed_request
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
