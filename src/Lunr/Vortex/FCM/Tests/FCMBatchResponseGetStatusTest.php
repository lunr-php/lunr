<?php

/**
 * This file contains the FCMBatchResponseGetStatusTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

use Lunr\Vortex\FCM\FCMBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the get_status function of the FCMBatchResponse class.
 *
 * @covers Lunr\Vortex\FCM\FCMBatchResponse
 */
class FCMBatchResponseGetStatusTest extends FCMBatchResponseTest
{

    /**
     * Testcase constructor.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $content = file_get_contents(TEST_STATICS . '/Vortex/gcm/response_single_success.json');

        $this->response->status_code = 200;
        $this->response->body        = $content;

        $this->class      = new FCMBatchResponse($this->response, $this->logger, [ 'endpoint1' ], '{}');
        $this->reflection = new ReflectionClass('Lunr\Vortex\FCM\FCMBatchResponse');
    }

    /**
     * Unit test data provider.
     *
     * @return array $data array of endpoints statuses / status result
     */
    public function endpointDataProvider(): array
    {
        $data = [];

        // return unknown status if no status set
        $data[] = [ [], PushNotificationStatus::UNKNOWN ];

        // return unknown status if endpoint absent
        $data[] = [
            [
                'endpoint1' => PushNotificationStatus::INVALID_ENDPOINT,
            ],
            PushNotificationStatus::UNKNOWN,
        ];
        $data[] = [
            [
                'endpoint1' => PushNotificationStatus::ERROR,
                'endpoint2' => PushNotificationStatus::INVALID_ENDPOINT,
                'endpoint3' => PushNotificationStatus::SUCCESS,
            ],
            PushNotificationStatus::UNKNOWN,
        ];

        // return endpoint own status if present
        $data[] = [
            [
                'endpoint_param' => PushNotificationStatus::INVALID_ENDPOINT,
            ],
            PushNotificationStatus::INVALID_ENDPOINT,
        ];
        $data[] = [
            [
                'endpoint1'      => PushNotificationStatus::ERROR,
                'endpoint_param' => PushNotificationStatus::SUCCESS,
                'endpoint2'      => PushNotificationStatus::TEMPORARY_ERROR,
            ],
            PushNotificationStatus::SUCCESS,
        ];

        return $data;
    }

    /**
     * Test the get_status() behavior.
     *
     * @param array   $statuses Endpoints statuses
     * @param integer $status   Expected function result
     *
     * @dataProvider endpointDataProvider
     * @covers       Lunr\Vortex\FCM\FCMBatchResponse::get_status
     */
    public function testGetStatus($statuses, $status): void
    {
        $this->set_reflection_property_value('statuses', $statuses);

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals($status, $result);
    }

}

?>
