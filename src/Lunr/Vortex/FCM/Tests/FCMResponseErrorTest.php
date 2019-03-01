<?php

/**
 * This file contains the FCMResponseErrorTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed FCM dispatches.
 *
 * @covers Lunr\Vortex\FCM\FCMResponse
 */
class FCMResponseErrorTest extends FCMResponseTest
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
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertPropertySame('http_code', 503);
    }

    /**
     * Test that get_status() returns the dispatch status.
     *
     * @covers Lunr\Vortex\FCM\FCMResponse::get_status
     */
    public function testGetStatusReturnsStatus()
    {
        $this->assertEquals($this->class->get_status(), PushNotificationStatus::ERROR);
    }

}

?>
