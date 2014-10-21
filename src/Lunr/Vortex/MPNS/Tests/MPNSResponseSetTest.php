<?php

/**
 * This file contains the MPNSResponseSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for setting meta information about MPNS dispatches.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSResponse
 */
class MPNSResponseSetTest extends MPNSResponseTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpSuccess();
    }

    /**
     * Test setting headers for status 412.
     *
     * @covers Lunr\Vortex\MPNS\MPNSResponse::parse_headers
     */
    public function testParseHeadersWithPreconditionFailedStatus()
    {
        $result = file_get_contents(TEST_STATICS . '/Vortex/mpns_response.txt');
        $parsed = file_get_contents(TEST_STATICS . '/Vortex/mpns_response_parsed.txt');

        $header = $this->getMock('http\Header', [ 'parse' ]);

        $parse = [ get_class($header), 'parse' ];

        $this->mock_method($parse, "return $parsed;");

        $this->set_reflection_property_value('http_code', 412);

        $method = $this->get_accessible_reflection_method('parse_headers');
        $method->invokeArgs($this->class, [$header, $result, 129]);

        $headers = $this->get_reflection_property_value('headers');

        $this->assertArrayHasKey('X-Notificationstatus', $headers);
        $this->assertArrayHasKey('X-Deviceconnectionstatus', $headers);
        $this->assertArrayHasKey('X-Subscriptionstatus', $headers);

        $this->assertEquals('Received', $headers['X-Notificationstatus']);
        $this->assertEquals('Connected', $headers['X-Deviceconnectionstatus']);
        $this->assertEquals('N/A', $headers['X-Subscriptionstatus']);

        $this->unmock_method($parse);
    }

    /**
     * Test setting headers for special statuses that don't have optional headers.
     *
     * @param Integer $status Special status code
     *
     * @dataProvider specialStatusProvider
     * @covers       Lunr\Vortex\MPNS\MPNSResponse::parse_headers
     */
    public function testParseHeadersWithSpecialStatusCodes($status)
    {
        $result = file_get_contents(TEST_STATICS . '/Vortex/mpns_response.txt');
        $parsed = file_get_contents(TEST_STATICS . '/Vortex/mpns_response_parsed.txt');

        $header = $this->getMock('http\Header', [ 'parse' ]);

        $parse = [ get_class($header), 'parse' ];

        $this->mock_method($parse, "return $parsed;");

        $this->set_reflection_property_value('http_code', $status);

        $method = $this->get_accessible_reflection_method('parse_headers');
        $method->invokeArgs($this->class, [$header, $result, 129]);

        $headers = $this->get_reflection_property_value('headers');

        $this->assertArrayHasKey('X-Notificationstatus', $headers);
        $this->assertArrayHasKey('X-Deviceconnectionstatus', $headers);
        $this->assertArrayHasKey('X-Subscriptionstatus', $headers);

        $this->assertEquals('N/A', $headers['X-Notificationstatus']);
        $this->assertEquals('N/A', $headers['X-Deviceconnectionstatus']);
        $this->assertEquals('N/A', $headers['X-Subscriptionstatus']);

        $this->unmock_method($parse);
    }

    /**
     * Test setting the status for a successful request.
     *
     * @covers Lunr\Vortex\MPNS\MPNSResponse::set_status
     */
    public function testStatusForSuccessRequestStatus()
    {
        $method = $this->get_accessible_reflection_method('set_status');
        $method->invokeArgs($this->class, ['URL', $this->logger]);

        $this->logger->expects($this->never())
                     ->method('warning');

        $this->assertEquals(PushNotificationStatus::SUCCESS, $this->get_reflection_property_value('status'));
    }

    /**
     * Test setting the status for a failed request.
     *
     * @param Integer $code     Status code
     * @param String  $nstatus  Notification status string
     * @param Integer $expected Expected push notification status
     *
     * @dataProvider failedRequestProvider
     * @covers       Lunr\Vortex\MPNS\MPNSResponse::set_status
     */
    public function testSetStatusForNonSuccessRequestStatus($code, $nstatus, $expected)
    {
        $headers = [];

        $headers['X-Notificationstatus']     = $nstatus;
        $headers['X-Deviceconnectionstatus'] = 'N/A';
        $headers['X-Subscriptionstatus']     = 'N/A';

        $this->set_reflection_property_value('headers', $headers);
        $this->set_reflection_property_value('http_code', $code);

        $context = [
            'endpoint' => 'URL',
            'nstatus' => $nstatus,
            'dstatus' => 'N/A',
            'sstatus' => 'N/A'
        ];

        $message  = 'Push notification delivery status for endpoint {endpoint}: ';
        $message .= '{nstatus}, device {dstatus}, subscription {sstatus}';

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

}

?>
