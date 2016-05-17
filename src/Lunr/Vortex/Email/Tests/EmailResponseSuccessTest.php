<?php

/**
 * This file contains the EmailResponseSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diaamntis <leonidas@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful Email dispatches.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
class EmailResponseSuccessTest extends EmailResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test that the endpoint is set correctly.
     */
    public function testEndpointSetCorrectly()
    {
        $this->assertPropertySame('endpoint', '12345679');
    }

    /**
     * Test that the status is set as error.
     */
    public function testStatusIsSuccess()
    {
        $this->assertSame(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('12345679'), PushNotificationStatus::SUCCESS);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('abcdefghi'), PushNotificationStatus::UNKNOWN);
    }

}

?>
