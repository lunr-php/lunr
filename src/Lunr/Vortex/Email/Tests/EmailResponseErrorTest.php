<?php

/**
 * This file contains the EmailResponseErrorTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for failed Email dispatches.
 *
 * @covers Lunr\Vortex\Email\EmailResponse
 */
class EmailResponseErrorTest extends EmailResponseTest
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
     * Test that get_status() returns the dispatch status.
     *
     * @covers Lunr\Vortex\Email\EmailResponse::get_status
     */
    public function testGetStatusReturnsStatus()
    {
        $this->assertEquals($this->class->get_status(), PushNotificationStatus::ERROR);
    }

}

?>
