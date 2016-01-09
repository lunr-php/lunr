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
     * Test that the status is set as error.
     */
    public function testStatusIsSuccess()
    {
        $this->assertSame(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

}

?>
