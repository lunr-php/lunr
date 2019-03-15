<?php

/**
 * This file contains the PAPResponseInvalidXMLTest class.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for PAP dispatches with invalid XML response.
 *
 * @covers Lunr\Vortex\PAP\PAPResponse
 */
class PAPResponseInvalidXMLTest extends PAPResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpInvalidXMLError();
    }

    /**
     * Test setting the status for a successful request logs an error on invalid XML response.
     *
     * @return void
     */
    public function testStatusForSuccessRequestStatusLogsErrorOnInvalidXMLResponse(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_invalid.xml');

        $this->set_reflection_property_value('result', $file);

        $method = $this->get_accessible_reflection_method('parse_pap_response');

        $this->assertEquals(PushNotificationStatus::ERROR, $this->get_reflection_property_value('status'));
    }

}

?>
