<?php

/**
 * This file contains the WNSResponseSuccessTest class.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful WNS dispatches.
 *
 * @covers Lunr\Vortex\WNS\WNSResponse
 */
class WNSResponseSuccessTest extends WNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpSuccess();
    }

    /**
     * Test headers are set correctly.
     */
    public function testHeadersIsSetCorrectly(): void
    {
        $headers = $this->get_reflection_property_value('headers');

        $this->assertArrayHasKey('X-WNS-Status', $headers);
        $this->assertArrayHasKey('X-WNS-DeviceConnectionStatus', $headers);

        $this->assertEquals('received', $headers['X-WNS-Status']);
        $this->assertEquals('connected', $headers['X-WNS-DeviceConnectionStatus']);
    }

    /**
     * Test that the status is set as success.
     */
    public function testStatusIsSuccess(): void
    {
        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that the endpoint is set correctly.
     */
    public function testEndpointSetCorrectly(): void
    {
        $this->assertPropertySame('endpoint', 'http://localhost/');
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly(): void
    {
        $this->assertEquals(200, $this->get_reflection_property_value('http_code'));
    }

    /**
     * Test that the payload is set correctly.
     */
    public function testPayloadIsSetCorrectly(): void
    {
        $this->assertPropertySame('payload', '<?xml version="1.0" encoding="utf-8"?>');
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\WNS\WNSResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('http://localhost/'), PushNotificationStatus::SUCCESS);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\WNS\WNSResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('http://foo/'), PushNotificationStatus::UNKNOWN);
    }

}

?>
