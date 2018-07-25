<?php

/**
 * This file contains the APNSResponseBasePushSuccessTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP\Tests;

use Lunr\Vortex\APNS\ApnsPHP\APNSResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the constructor of the APNSResponse class
 * in case of a push notification success.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
class APNSResponseBasePushSuccessTest extends APNSResponseTest
{

    /**
     * Test constructor behavior for push success with single endpoint success.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::__construct
     */
    public function testPushSuccessWithSingleSuccess()
    {
        $endpoint         = 'endpoint1';
        $invalid_endpoint = FALSE;
        $errors           = [];
        $status           = PushNotificationStatus::SUCCESS;

        $this->class      = new APNSResponse($this->logger, $endpoint, $invalid_endpoint, $errors);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');

        $this->assertPropertyEquals('status', $status);
    }

}
