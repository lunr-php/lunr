<?php

/**
 * This file contains the APNSResponseGetStatusTest class.
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
 * This class contains tests for the get_status function of the APNSResponse class.
 *
 * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse
 */
class APNSResponseGetStatusTest extends APNSResponseTest
{

    /**
     * Testcase constructor.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->class      = new APNSResponse($this->logger, [], [], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\APNS\ApnsPHP\APNSResponse');
    }

    /**
     * Test the get_status() behavior.
     *
     * @covers Lunr\Vortex\APNS\ApnsPHP\APNSResponse::get_status
     */
    public function testGetStatus()
    {
        $this->set_reflection_property_value('status', PushNotificationStatus::ERROR);

        $result = $this->class->get_status();

        $this->assertEquals(PushNotificationStatus::ERROR, $result);
    }

}
