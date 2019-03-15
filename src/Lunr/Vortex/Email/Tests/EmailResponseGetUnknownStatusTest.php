<?php

/**
 * This file contains the EmailResponseGetUnknownStatusTest class.
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
class EmailResponseGetUnknownStatusTest extends EmailResponseTest
{

    /**
     * Test that get_status() returns PushNotification::UNKNOWN
     * when an unknown endpoint is passed in.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetUnknownStatusForEndpoint(): void
    {
        $this->assertEquals(PushNotificationStatus::UNKNOWN, $this->class->get_status('unknown'));
    }

}
