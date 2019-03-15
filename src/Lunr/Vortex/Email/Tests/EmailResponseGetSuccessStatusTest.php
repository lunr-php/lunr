<?php

/**
 * This file contains the EmailResponseGetSuccessStatusTest class.
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
class EmailResponseGetSuccessStatusTest extends EmailResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpSuccess();
    }

    /**
     * Test that get_status() returns PushNotification::SUCCESS
     * for an endpoint with a succesful notification.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetSuccessStatusForEndpoint(): void
    {
        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->class->get_status('success-endpoint'));
    }

}
