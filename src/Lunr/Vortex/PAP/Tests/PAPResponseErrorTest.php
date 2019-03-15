<?php

/**
 * This file contains the PAPResponseErrorTest class.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed PAP dispatches.
 *
 * @covers Lunr\Vortex\PAP\PAPResponse
 */
class PAPResponseErrorTest extends PAPResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpError();
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsError(): void
    {
        $this->assertPropertySame('status', PushNotificationStatus::ERROR);
    }

    /**
     * Test that the endpoint is set correctly.
     */
    public function testEndpointSetCorrectly(): void
    {
        $this->assertPropertySame('endpoint', '12345679');
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly(): void
    {
        $this->assertPropertySame('http_code', FALSE);
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('12345679'), PushNotificationStatus::ERROR);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint(): void
    {
        $this->assertEquals($this->class->get_status('abcdefghi'), PushNotificationStatus::UNKNOWN);
    }

}

?>
