<?php

/**
 * This file contains the GCMResponseAddBatchResponseTest class.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

use Lunr\Vortex\PushNotificationStatus;

/**
 * This class contains tests for the add_batch_response function of the GCMResponse class.
 *
 * @covers Lunr\Vortex\GCM\GCMResponse
 */
class GCMResponseAddBatchResponseTest extends GCMResponseTest
{

    /**
     * Test that add_batch_response() with no endpoint doesn't modify the statuses property.
     *
     * @covers  Lunr\Vortex\GCM\GCMResponse::add_batch_response
     */
    public function testAddBatchResponseWithNoEndpointDoesNotModifyStatuses()
    {
        $statuses = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::SUCCESS,
        ];

        $this->set_reflection_property_value('statuses', $statuses);

        $this->class->add_batch_response($this->batch_response, []);

        $this->assertPropertySame('statuses', $statuses);
    }

    /**
     * Test that add_batch_response() with endpoints add status for each of them.
     *
     * @covers  Lunr\Vortex\GCM\GCMResponse::add_batch_response
     */
    public function testAddBatchResponseWithEndpointsAddStatus()
    {
        $statuses = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::SUCCESS,
        ];

        $endpoints = [ 'endpoint2', 'endpoint3', 'endpoint4' ];

        $expected_statuses = [
            'endpoint1' => PushNotificationStatus::ERROR,
            'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
            'endpoint3' => PushNotificationStatus::UNKNOWN,
            'endpoint4' => PushNotificationStatus::SUCCESS,
        ];

        $this->set_reflection_property_value('statuses', $statuses);

        $pos = 0;

        $this->batch_response->expects($this->at($pos++))
                             ->method('get_status')
                             ->with('endpoint2')
                             ->willReturn(PushNotificationStatus::INVALID_ENDPOINT);

        $this->batch_response->expects($this->at($pos++))
                             ->method('get_status')
                             ->with('endpoint3')
                             ->willReturn(PushNotificationStatus::UNKNOWN);

        $this->batch_response->expects($this->at($pos++))
                             ->method('get_status')
                             ->with('endpoint4')
                             ->willReturn(PushNotificationStatus::SUCCESS);

        $this->class->add_batch_response($this->batch_response, $endpoints);

        $this->assertPropertySame('statuses', $expected_statuses);
    }

}

?>
