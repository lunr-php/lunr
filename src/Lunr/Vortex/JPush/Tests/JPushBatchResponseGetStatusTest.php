<?php

/**
 * This file contains the JPushBatchResponseGetStatusTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushBatchResponse;
use Lunr\Vortex\PushNotificationStatus;

use ReflectionClass;

/**
 * This class contains tests for the get_status function of the JPushBatchResponse class.
 *
 * @covers \Lunr\Vortex\JPush\JPushBatchResponse
 */
class JPushBatchResponseGetStatusTest extends JPushBatchResponseTest
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

        $this->class      = new JPushBatchResponse($this->http, $this->logger, $this->response, [ 'endpoint1' ], []);
        $this->reflection = new ReflectionClass('Lunr\Vortex\JPush\JPushBatchResponse');
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
        $data[] = [ ['endpoint14432'], PushNotificationStatus::UNKNOWN ];

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
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::get_status
     */
    public function testGetStatus($statuses, $status): void
    {
        $this->set_reflection_property_value('statuses', $statuses);
        $this->set_reflection_property_value('message_id', 'fdshjdsfhjk');

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals($status, $result);
    }

    /**
     * Test the get_status() behavior to fetch new statuses if it fails.
     *
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::get_status
     */
    public function testGetStatusWillFetchUpstreamFails(): void
    {
        $this->set_reflection_property_value('statuses', []);
        $this->set_reflection_property_value('message_id', 'fdshjdsfhjk');

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "fdshjdsfhjk"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], ['msg_id' => 'fdshjdsfhjk', 'registration_ids' => ['endpoint1']], [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status')
                        ->will($this->throwException(new \Requests_Exception('Message', 'type')));

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals(0, $result);
    }

    /**
     * Test the get_status() behavior to fetch new statuses if it fails.
     *
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::get_status
     */
    public function testGetStatusWillFetchUpstreamSingle(): void
    {
        $this->set_reflection_property_value('statuses', []);
        $this->set_reflection_property_value('message_id', 'fdshjdsfhjk');

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "fdshjdsfhjk"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $report_response->success = TRUE;
        $report_response->body    = '{"endpoint1": {"status":5}}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], ['msg_id' => 'fdshjdsfhjk', 'registration_ids' => ['endpoint1']], [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status');

        $result = $this->class->get_status('endpoint_param');

        $this->assertEquals(0, $result);
    }

}

?>
