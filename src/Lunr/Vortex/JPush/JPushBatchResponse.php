<?php

/**
 * This file contains the JPushBatchResponse class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

use Lunr\Vortex\PushNotificationStatus;
use Requests_Exception;

/**
 * JPush response for a batch push notification.
 */
class JPushBatchResponse
{

    /**
     * JPush Report API URL.
     * @var string
     */
    const JPUSH_REPORT_URL = 'https://report.jpush.cn/v3/status/message';

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * The statuses per endpoint.
     * @var array
     */
    private $statuses;

    /**
     * Raw payload that was sent to JPush.
     * @var string
     */
    protected $payload;

    /**
     * Message ID.
     * @var string
     */
    protected $message_id;

    /**
     * Notification endpoints.
     * @var array
     */
    protected $endpoints;

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http      Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger    Shared instance of a Logger.
     * @param \Requests_Response       $response  Requests_Response object.
     * @param array                    $endpoints The endpoints the message was sent to (in the same order as sent).
     * @param array                    $payload   Raw payload that was sent to JPush.
     */
    public function __construct($http, $logger, $response, $endpoints, $payload)
    {
        $this->statuses  = [];
        $this->http      = $http;
        $this->logger    = $logger;
        $this->payload   = $payload;
        $this->endpoints = $endpoints;

        if (!$response->success)
        {
            $this->report_error($this->endpoints, $response);
            return;
        }

        $json_content = json_decode($response->body, TRUE);

        if (!isset($json_content['msg_id']))
        {
            $this->report_error($this->endpoints, $response);
            return;
        }

        $this->message_id = $json_content['msg_id'];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->http);
        unset($this->logger);
        unset($this->statuses);
        unset($this->payload);
        unset($this->endpoints);
        unset($this->message_id);
    }

    /**
     * Define the status result for each endpoint.
     *
     * @return void
     */
    private function set_statuses()
    {

        $payload = [
            'msg_id'           => $this->message_id,
            'registration_ids' => $this->endpoints,
        ];

        try
        {
            $response = $this->http->post(static::JPUSH_REPORT_URL, [], $payload, []);
            $response->throw_for_status();
        }
        catch (Requests_Exception $e)
        {
            $this->report_error($this->endpoints, $response);
            return;
        }

        foreach (json_decode($response->body, TRUE) as $endpoint => $result)
        {
            if ($result['status'] === 0)
            {
                $this->statuses[$endpoint] = PushNotificationStatus::SUCCESS;
            }
            else
            {
                $this->report_endpoint_error($endpoint, $result['status']);
            }
        }
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus Delivery status for the endpoint
     */
    public function get_status($endpoint)
    {
        if ($this->statuses === [])
        {
            $this->set_statuses();
        }

        return isset($this->statuses[$endpoint]) ? $this->statuses[$endpoint] : PushNotificationStatus::UNKNOWN;
    }

    /**
     * Report an error with the push notification.
     *
     * @param array              $endpoints The endpoints the message was sent to
     * @param \Requests_Response $response  The HTTP Response
     *
     * @see https://docs.jiguang.cn/en/jpush/server/push/rest_api_v3_push/#call-return
     *
     * @return void
     */
    private function report_error(&$endpoints, $response)
    {
        switch ($response->status_code)
        {
            case 400:
                $error_message = 'Invalid request';
                $status        = PushNotificationStatus::ERROR;
                break;
            case 401:
                $error_message = 'Error with authentication';
                $status        = PushNotificationStatus::ERROR;
                break;
            case 403:
                $error_message = 'Error with configuration';
                $status        = PushNotificationStatus::ERROR;
                break;
            default:
                $error_message = 'Unknown error';
                $status        = PushNotificationStatus::UNKNOWN;
                break;
        }

        if ($response->status_code >= 500)
        {
            $error_message = 'Internal error';
            $status        = PushNotificationStatus::TEMPORARY_ERROR;
        }

        foreach ($endpoints as $endpoint)
        {
            $this->statuses[$endpoint] = $status;
        }

        $context = [ 'error' => $error_message ];
        $this->logger->warning('Dispatching push notification failed: {error}', $context);
    }

    /**
     * Report an error with the push notification for one endpoint.
     *
     * @param string $endpoint   Endpoint for which the push failed
     * @param string $error_code Error response code
     *
     * @see https://docs.jiguang.cn/en/jpush/server/push/rest_api_v3_report/#inquiry-of-service-status
     *
     * @return void
     */
    private function report_endpoint_error($endpoint, $error_code)
    {
        switch ($error_code)
        {
            case 1:
                $status        = PushNotificationStatus::UNKNOWN;
                $error_message = 'Not delivered';
                break;
            case 2:
                $status        = PushNotificationStatus::INVALID_ENDPOINT;
                $error_message = 'Registration_id does not belong to the application';
                break;
            case 3:
                $status        = PushNotificationStatus::ERROR;
                $error_message = 'Registration_id belongs to the application, but it is not the target of the message';
                break;
            case 4:
                $status        = PushNotificationStatus::TEMPORARY_ERROR;
                $error_message = 'The system is abnormal';
                break;
            default:
                $status        = PushNotificationStatus::UNKNOWN;
                $error_message = $error_code;
                break;
        }

        $context = [ 'endpoint' => $endpoint, 'error' => $error_message ];
        $this->logger->warning('Dispatching push notification failed for endpoint {endpoint}: {error}', $context);

        $this->statuses[$endpoint] = $status;
    }

}

?>
