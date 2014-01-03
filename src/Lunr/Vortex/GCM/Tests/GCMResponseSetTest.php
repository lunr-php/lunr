<?php

/**
 * This file contains the GCMResponseSetTest class.
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
 * This class contains tests for setting meta information about GCM dispatches.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @covers     Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseSetTest extends GCMResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test setting the status for a successful request.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::set_status
     */
    public function testStatusForSuccessRequestStatus()
    {
        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, ['URL', $this->logger]);

        $this->logger->expects($this->never())
                     ->method('warning');

        $this->assertPropertySame('status', PushNotificationStatus::SUCCESS);
    }

    /**
     * Test setting the status for a failed request.
     *
     * @param Integer $code     Status code
     * @param Integer $expected Expected push notification status
     *
     * @dataProvider failedRequestProvider
     * @covers       Lunr\Vortex\GCM\GCMResponse::set_status
     */
    public function testSetStatusForNonSuccessRequestStatus($code, $expected)
    {
        $this->set_reflection_property_value('http_code', $code);
        $this->set_reflection_property_value('result', 'something');

        $context = [
            'endpoint' => 'URL',
            'code' => $expected,
            'description' => 'something'
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= 'failed with an error: {description}. Error #{code}';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with(
                         $this->equalTo($message),
                         $this->equalTo($context)
                     );

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, ['URL', $this->logger]);

        $this->assertEquals($expected, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a successful request logs any possible failures.
     *
     * @covers Lunr\Vortex\GCM\GCMResponse::set_status
     */
    public function testStatusForSuccessRequestStatusLogsOneError()
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/gcm_response_error.json');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('http_code', 200);

        $context = [
            'failure' => 1,
            'errors' => '["InvalidRegistration"]'
        ];

        $message  = '{failure} push notification(s) failed with the following ';
        $message .= 'error information {errors}.';

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, ['URL', $this->logger]);

        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

}

?>
