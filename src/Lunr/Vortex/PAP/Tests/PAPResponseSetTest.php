<?php

/**
 * This file contains the PAPResponseSetTest class.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for setting meta information about PAP dispatches.
 *
 * @covers Lunr\Vortex\PAP\PAPResponse
 */
class PAPResponseSetTest extends PAPResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        parent::setUpSuccess();
    }

    /**
     * Test setting the status for a successful request.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testStatusForSuccessRequestStatus(): void
    {
        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->logger->expects($this->never())
                     ->method('warning');

        $this->assertPropertySame('status', PushNotificationStatus::SUCCESS);
    }

    /**
     * Test setting the status for a failed request.
     *
     * @param integer $code     Status code
     * @param integer $expected Expected push notification status
     *
     * @dataProvider failedRequestProvider
     * @covers       Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testSetStatusForNonSuccessRequestStatus($code, $expected): void
    {
        $this->set_reflection_property_value('http_code', $code);
        $this->set_reflection_property_value('result', 'something');

        $context = [
            'endpoint'    => 'URL',
            'code'        => $expected,
            'description' => 'something',
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
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->assertEquals($expected, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a successful request logs any possible failures.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testStatusForSuccessRequestStatusLogsOneError(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_error.xml');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('http_code', 200);
        $this->set_reflection_property_value('pap_response', []);

        $context = [
            'code'        => 5,
            'endpoint'    => 'URL',
            'description' => 'Invalid or missing attribute address-value',
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= 'failed with an error: {description}. Error #{code}';

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $method->invoke($this->class);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->assertEquals(PushNotificationStatus::ERROR, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a successful request logs any possible failures.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testSetStatusWithInvalidEndpointsLogsError(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_error_invalid_endpoint.xml');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('http_code', 200);
        $this->set_reflection_property_value('pap_response', []);

        $context = [
            'code'        => 3,
            'endpoint'    => 'URL',
            'description' => 'The specified PIN is not recognized',
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= 'failed with an error: {description}. Error #{code}';

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $method->invoke($this->class);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->assertEquals(PushNotificationStatus::INVALID_ENDPOINT, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a successful request logs any possible failures.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testSetStatusLogsTemporaryError(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_error_temporary.xml');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('http_code', 200);
        $this->set_reflection_property_value('pap_response', []);

        $context = [
            'code'        => 2,
            'endpoint'    => 'URL',
            'description' => 'The server is busy',
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= 'failed with an error: {description}. Error #{code}';

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $method->invoke($this->class);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->assertEquals(PushNotificationStatus::TEMPORARY_ERROR, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a successful request logs any possible failures.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::set_status
     */
    public function testSetStatusLogsUnknownError(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_error_unknown.xml');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('http_code', 200);
        $this->set_reflection_property_value('pap_response', []);

        $context = [
            'code'        => 0,
            'endpoint'    => 'URL',
            'description' => 'The RIM specific request is badly formed',
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= 'failed with an error: {description}. Error #{code}';

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $method->invoke($this->class);

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with($this->equalTo($message), $this->equalTo($context));

        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, [ 'URL', $this->logger ]);

        $this->assertEquals(PushNotificationStatus::UNKNOWN, $this->get_reflection_property_value('status'));
    }

    /**
     * Test parse_pap_response() parses a response with a failure.
     *
     * @covers Lunr\Vortex\PAP\PAPResponse::parse_pap_response
     */
    public function testParsePAPResponseWithOneFailure(): void
    {
        $file = file_get_contents(TEST_STATICS . '/Vortex/pap/response_error.xml');

        $this->set_reflection_property_value('result', $file);
        $this->set_reflection_property_value('pap_response', []);

        $method = $this->get_accessible_reflection_method('parse_pap_response');
        $result = $method->invoke($this->class);

        $res = $this->get_reflection_property_value('pap_response');

        $this->assertArrayHasKey('message', $res);
    }

}

?>
