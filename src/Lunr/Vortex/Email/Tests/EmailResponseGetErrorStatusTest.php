<?php

/**
 * This file contains the EmailResponseGetErrorStatusTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Koen Woortman <k.woortman@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the EmailResponse class.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
class EmailResponseGetErrorStatusTest extends EmailResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpError();
    }

    /**
     * Test that get_status() returns PushNotification::ERROR
     * for an endpoint with a failed notification.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetErrorStatusForEndpoint()
    {
        $this->assertEquals(PushNotificationStatus::ERROR, $this->class->get_status('error-endpoint'));
    }

}
