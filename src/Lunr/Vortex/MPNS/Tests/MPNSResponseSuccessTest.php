<?php

/**
 * This file contains the MPNSResponseSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful MPNS dispatches.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSResponse
 */
class MPNSResponseSuccessTest extends MPNSResponseTest
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

        $this->assertArrayHasKey('X-Notificationstatus', $headers);
        $this->assertArrayHasKey('X-Deviceconnectionstatus', $headers);
        $this->assertArrayHasKey('X-Subscriptionstatus', $headers);

        $this->assertEquals('Received', $headers['X-Notificationstatus']);
        $this->assertEquals('Connected', $headers['X-Deviceconnectionstatus']);
        $this->assertEquals('Active', $headers['X-Subscriptionstatus']);
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
