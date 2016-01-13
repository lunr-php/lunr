<?php

/**
 * This file contains the WNSResponseErrorTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed WNS dispatches.
 *
 * @covers Lunr\Vortex\WNS\WNSResponse
 */
class WNSResponseErrorTest extends WNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpError();
    }

    /**
     * Test headers are not set when request failed.
     */
    public function testHeadersIsNull()
    {
        $this->assertNull($this->get_reflection_property_value('headers'));
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsError()
    {
        $this->assertEquals(PushNotificationStatus::ERROR, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertEquals(404, $this->get_reflection_property_value('http_code'));
    }

    /**
     * Test that get_status() returns the dispatch status.
     *
     * @covers Lunr\Vortex\WNS\WNSResponse::get_status
     */
    public function testGetStatusReturnsStatus()
    {
        $this->assertEquals(PushNotificationStatus::ERROR, $this->class->get_status());
    }

}

?>
