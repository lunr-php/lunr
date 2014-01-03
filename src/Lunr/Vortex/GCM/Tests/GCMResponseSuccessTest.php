<?php

/**
 * This file contains the GCMResponseSuccessTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for successful GCM dispatches.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseSuccessTest extends GCMResponseTest
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
     * Test that the http code is set from the Response object.
     */
    public function testHttpCodeIsSetCorrectly()
    {
        $this->assertSame(200, $this->get_reflection_property_value('http_code'));
    }

    /**
     * Test parse_gcm_failures() parses a response with a failure.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::parse_gcm_failures
     */
    public function testParseGCMFailuresWithOneFailure()
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/gcm_response_error.json');

        $this->set_reflection_property_value('result', $file);

        $method = $this->get_accessible_reflection_method('parse_gcm_failures');
        $result = $method->invoke($this->class);

        $this->assertArrayHasKey('messages', $result);
    }

    /**
     * Test parse_gcm_failures() parses a response without a failure.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::parse_gcm_failures
     */
    public function testParseGCMFailuresWithoutFailure()
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/gcm_response.json');

        $this->set_reflection_property_value('result', $file);

        $method = $this->get_accessible_reflection_method('parse_gcm_failures');
        $result = $method->invoke($this->class);

        $this->assertEquals(1, count($result));
    }

}

?>
