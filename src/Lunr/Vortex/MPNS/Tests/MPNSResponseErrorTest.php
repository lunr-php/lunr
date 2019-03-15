<?php

/**
 * This file contains the MPNSResponseErrorTest class.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed MPNS dispatches.
 *
 * @covers Lunr\Vortex\MPNS\MPNSResponse
 */
class MPNSResponseErrorTest extends MPNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpError();
    }

    /**
     * Test headers are not set when request failed.
     */
    public function testHeadersIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('headers'));
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsError(): void
    {
        $this->assertEquals(PushNotificationStatus::ERROR, $this->get_reflection_property_value('status'));
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
        $this->assertEquals(FALSE, $this->get_reflection_property_value('http_code'));
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\MPNS\MPNSResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('http://localhost/'), PushNotificationStatus::ERROR);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\MPNS\MPNSResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('http://foo/'), PushNotificationStatus::UNKNOWN);
    }

}

?>
