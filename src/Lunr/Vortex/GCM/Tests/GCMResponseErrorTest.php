<?php

/**
 * This file contains the GCMResponseErrorTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed GCM dispatches.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseErrorTest extends GCMResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpError();
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsError()
    {
        $this->assertPropertySame('status', PushNotificationStatus::ERROR);
    }

    /**
     * Test that the endpoint is set correctly.
     */
    public function testEndpointSetCorrectly()
    {
        $this->assertPropertySame('endpoint', '12345679');
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertPropertySame('http_code', 503);
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('12345679'), PushNotificationStatus::ERROR);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('abcdefghi'), PushNotificationStatus::UNKNOWN);
    }

}

?>
