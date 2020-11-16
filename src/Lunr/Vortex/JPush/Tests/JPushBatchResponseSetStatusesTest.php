<?php

/**
 * This file contains the JPushBatchResponseSetStatusesTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

use Lunr\Vortex\JPush\JPushBatchResponse;

use ReflectionClass;

/**
 * This class contains tests for the set_statuses function of the JPushBatchResponse class.
 *
 * @covers \Lunr\Vortex\JPush\JPushBatchResponse
 */
class JPushBatchResponseSetStatusesTest extends JPushBatchResponseTest
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
     * Test the set_statuses() behavior to fetch new statuses if it fails.
     *
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::set_statuses
     */
    public function testSetStatusesWillFetchUpstreamFails(): void
    {
        $this->set_reflection_property_value('message_id', 1453658564165);
        $this->set_reflection_property_value('endpoints', ['endpoint1']);

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "1453658564165"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1"]}', [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status')
                        ->will($this->throwException(new \Requests_Exception('Message', 'type')));

        $method = $this->get_accessible_reflection_method('set_statuses');
        $result = $method->invokeArgs($this->class, []);

        $this->assertEquals(0, $result);
    }

    /**
     * Test the set_statuses() behavior to fetch new statuses if it fails.
     *
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::set_statuses
     */
    public function testSetStatusesWillFetchUpstreamSingle(): void
    {
        $this->set_reflection_property_value('message_id', 1453658564165);
        $this->set_reflection_property_value('endpoints', ['endpoint1']);

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "1453658564165"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $report_response->success = TRUE;
        $report_response->body    = '{"endpoint1": {"status":0}}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1"]}', [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status');

        $method = $this->get_accessible_reflection_method('set_statuses');
        $result = $method->invokeArgs($this->class, []);

        $this->assertEquals(0, $result);
        $this->assertPropertyEquals('statuses', ['endpoint1' => 1]);
    }

    /**
     * Test the set_statuses() behavior to fetch new statuses if it fails.
     *
     * @param int    $endpoint_return Status from JPush
     * @param int    $status          Lunr status
     * @param string $message         Reported message
     *
     * @dataProvider endpointErrorProvider
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::set_statuses
     */
    public function testSetStatusesWillFetchUpstreamSingleError($endpoint_return, $status, $message): void
    {
        $this->set_reflection_property_value('message_id', 1453658564165);
        $this->set_reflection_property_value('endpoints', ['endpoint1']);

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "1453658564165"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $report_response->success = TRUE;
        $report_response->body    = '{"endpoint1": {"status":'. $endpoint_return .'}}';

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1"]}', [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status');

        $this->logger->expects($this->once())
                     ->method('warning')
                     ->with('Dispatching push notification failed for endpoint {endpoint}: {error}', ['endpoint' => 'endpoint1','error' => $message]);

        $method = $this->get_accessible_reflection_method('set_statuses');
        $result = $method->invokeArgs($this->class, []);

        $this->assertEquals(0, $result);
        $this->assertPropertyEquals('statuses', ['endpoint1' => $status]);
    }

    /**
     * Test the set_statuses() behavior to fetch new statuses if it fails on some endpoints.
     *
     * @covers       \Lunr\Vortex\JPush\JPushBatchResponse::set_statuses
     */
    public function testSetStatusesWillFetchUpstreamMixedErrorSuccess(): void
    {
        $endpoints = ['endpoint1', 'endpoint2', 'endpoint3', 'endpoint4', 'endpoint5', 'endpoint6', 'endpoint7'];
        $this->set_reflection_property_value('message_id', 1453658564165);
        $this->set_reflection_property_value('endpoints', $endpoints);

        $report_response = $this->getMockBuilder('Requests_Response')->getMock();

        $content = '{"msg_id": "1453658564165"}';

        $this->response->success = TRUE;
        $this->response->body    = $content;

        $report_content = '{"endpoint1": {"status":1},"endpoint2": {"status":2},"endpoint3": {"status":3},"endpoint4": {"status":4},"endpoint5": {"status":5},"endpoint6": {"status":6},"endpoint7": {"status":0}}';
        $report_response->success = TRUE;
        $report_response->body    = $report_content;

        $this->http->expects($this->once())
                   ->method('post')
                   ->with('https://report.jpush.cn/v3/status/message', [], '{"msg_id":1453658564165,"registration_ids":["endpoint1","endpoint2","endpoint3","endpoint4","endpoint5","endpoint6","endpoint7"]}', [])
                   ->will($this->returnValue($report_response));

        $report_response->expects($this->once())
                        ->method('throw_for_status');

        $log_message = 'Dispatching push notification failed for endpoint {endpoint}: {error}';
        $this->logger->expects($this->exactly(6))
                     ->method('warning')
                     ->withConsecutive(
                         [$log_message, ['endpoint' => 'endpoint1','error' => 'Not delivered']],
                         [$log_message, ['endpoint' => 'endpoint2','error' => 'Registration_id does not belong to the application']],
                         [$log_message, ['endpoint' => 'endpoint3','error' => 'Registration_id belongs to the application, but it is not the target of the message']],
                         [$log_message, ['endpoint' => 'endpoint4','error' => 'The system is abnormal']],
                         [$log_message, ['endpoint' => 'endpoint5','error' => 5]],
                         [$log_message, ['endpoint' => 'endpoint6','error' => 6]]
                     );

        $method = $this->get_accessible_reflection_method('set_statuses');
        $result = $method->invokeArgs($this->class, []);

        $this->assertEquals(0, $result);
        $this->assertPropertyEquals('statuses', [
            'endpoint1' => 0,
            'endpoint2' => 3,
            'endpoint3' => 5,
            'endpoint4' => 2,
            'endpoint5' => 0,
            'endpoint6' => 0,
            'endpoint7' => 1,
        ]);
    }

    public function endpointErrorProvider(): array
    {
        $return = [];

        $return['Unknown failure'] = [1, 0, 'Not delivered'];
        $return['Registration ID unknown'] = [2, 3, 'Registration_id does not belong to the application'];
        $return['Registration ID not in message'] = [3, 5, 'Registration_id belongs to the application, but it is not the target of the message'];
        $return['System failure'] = [4, 2, 'The system is abnormal'];
        $return['Failure not matched'] = [5, 0, 5];

        return $return;
    }
}

?>
