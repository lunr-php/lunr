<?php

/**
 * This file contains the APNSResponseSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful APNS dispatches.
 *
 * @covers Lunr\Vortex\APNS\APNSResponse
 */
class APNSResponseSuccessTest extends APNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test that the status is set as successful.
     */
    public function testStatusIsError()
    {
        $this->assertSame(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that the result is set from as null.
     */
    public function testResultSetCorrectly()
    {
        $this->assertNull($this->get_reflection_property_value('result'));
    }

    /**
     * Test that get_status() returns the dispatch status.
     *
     * @covers Lunr\Vortex\APNS\APNSResponse::get_status
     */
    public function testGetStatusReturnsStatus()
    {
        $this->assertEquals($this->class->get_status(), PushNotificationStatus::SUCCESS);
    }

}

?>
