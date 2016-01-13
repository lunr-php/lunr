<?php

/**
 * This file contains the WNSResponseSuccessTest class.
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
 * This class contains tests for successful WNS dispatches.
 *
 * @covers Lunr\Vortex\WNS\WNSResponse
 */
class WNSResponseSuccessTest extends WNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test headers are not set when request failed.
     */
    public function testHeadersIsNull()
    {
        $headers = $this->get_reflection_property_value('headers');

        $this->assertArrayHasKey('X-WNS-Status', $headers);
        $this->assertArrayHasKey('X-WNS-DeviceConnectionStatus', $headers);

        $this->assertEquals('received', $headers['X-WNS-Status']);
        $this->assertEquals('connected', $headers['X-WNS-DeviceConnectionStatus']);
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsError()
    {
        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertEquals(200, $this->get_reflection_property_value('http_code'));
    }

}

?>
