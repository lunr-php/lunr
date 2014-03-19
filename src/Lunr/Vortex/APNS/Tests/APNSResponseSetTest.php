<?php

/**
 * This file contains the APNSResponseSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for setting meta information about APNS dispatches.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers     Lunr\Vortex\APNS\APNSResponse
 */
class APNSResponseSetTest extends APNSResponseTest
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
     * @covers Lunr\Vortex\APNS\APNSResponse::set_status
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
     * @param Integer $msg      Status message
     * @param Integer $expected Expected push notification status
     *
     * @dataProvider failedRequestProvider
     * @covers       Lunr\Vortex\APNS\APNSResponse::set_status
     */
    public function testSetStatusForNonSuccessRequestStatus($code, $msg, $expected)
    {
        $this->set_reflection_property_value('response_code', $code);
        $this->set_reflection_property_value('result', $msg);

        $context = [
            'endpoint'    => 'URL',
            'code'        => $expected,
            'description' => $msg
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

}

?>
