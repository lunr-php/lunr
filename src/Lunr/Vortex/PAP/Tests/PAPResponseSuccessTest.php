<?php

/**
 * This file contains the PAPResponseSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diaamntis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful PAP dispatches.
 *
 * @covers Lunr\Vortex\PAP\PAPResponse
 */
class PAPResponseSuccessTest extends PAPResponseTest
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
    public function testStatusIsError()
    {
        $this->assertSame(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test that the endpoint is set correctly.
     */
    public function testEndpointSetCorrectly()
    {
        $this->assertPropertySame('endpoint', '12345679');
    }

    /**
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertSame(200, $this->get_reflection_property_value('http_code'));
    }

    /**
     * Test parse_pap_response() parses a response without a failure.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::parse_pap_response
     */
    public function testParsePAPResponseWithoutFailure()
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response.xml');

        $this->set_reflection_property_value('result', $file);

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $result = $method->invoke($this->class);

        $this->assertEquals(1, count($result));
    }

    /**
     * Test that get_status() returns the dispatch status with correct endpoint.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::get_status
     */
    public function testGetStatusReturnsStatusForCorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('12345679'), PushNotificationStatus::SUCCESS);
    }

    /**
     * Test that get_status() returns unknown status with incorrect endpoint.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::get_status
     */
    public function testGetStatusReturnsUnknownStatusForIncorrectEndpoint()
    {
        $this->assertEquals($this->class->get_status('abcdefghi'), PushNotificationStatus::UNKNOWN);
    }

}

?>
