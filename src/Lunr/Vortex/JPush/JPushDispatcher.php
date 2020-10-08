<?php

/**
 * This file contains functionality to dispatch JPush Push Notifications.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * JPush Push Notification Dispatcher.
 */
class JPushDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Maximum number of endpoints allowed in one push.
     * @var integer
     */
    const BATCH_SIZE = 1000;

    /**
     * Url to send the JPush push notification to.
     * @var string
     */
    const JPUSH_SEND_URL = 'https://api.jpush.cn/v3/push';

    /**
     * Service name.
     * @var string
     */
    const SERVICE_NAME = 'JPush';

    /**
     * Push Notification authentication token.
     * @var string
     */
    protected $auth_token;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    protected $http;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        $this->http       = $http;
        $this->logger     = $logger;
        $this->auth_token = NULL;

        $this->http->options = [
            'timeout'         => 15, // timeout in seconds
            'connect_timeout' => 15 // timeout in seconds
        ];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->auth_token);
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Getter for JPushResponse.
     *
     * @return JPushResponse
     */
    public function get_response()
    {
        return new JPushResponse();
    }

    /**
     * Getter for JPushBatchResponse.
     *
     * @param \Requests_Response $http_response Requests_Response object.
     * @param array              $endpoints     The endpoints the message was sent to (in the same order as sent).
     * @param array              $payload       Raw payload that was sent to JPush.
     *
     * @return JPushBatchResponse
     */
    public function get_batch_response($http_response, $endpoints, $payload)
    {
        return new JPushBatchResponse($this->http, $this->logger, $http_response, $endpoints, $payload);
    }

    /**
     * Push the notification.
     *
     * @param JPushPayload $payload   Payload object
     * @param string[]     $endpoints Endpoints to send to in this batch
     *
     * @return JPushResponse Response object
     */
    public function push($payload, &$endpoints)
    {
        $response = $this->get_response();

        foreach (array_chunk($endpoints, static::BATCH_SIZE) as &$batch)
        {
            $batch_response = $this->push_batch($payload, $batch);

            $response->add_batch_response($batch_response, $batch);

            unset($batch_response);
        }

        unset($batch);

        return $response;
    }

    /**
     * Push the notification to a batch of endpoints.
     *
     * @param JPushPayload $payload   Payload object
     * @param string[]     $endpoints Endpoints to send to in this batch
     *
     * @return JPushBatchResponse Response object
     */
    protected function push_batch($payload, &$endpoints)
    {

        $tmp_payload = $payload->get_payload();
        $tmp_payload['audience']['registration_id'] = $endpoints;

        try
        {
            $http_response = $this->http->post(static::JPUSH_SEND_URL, [], json_encode($tmp_payload), []);
        }
        catch (Requests_Exception $e)
        {
            $this->logger->warning(
                'Dispatching ' . static::SERVICE_NAME . ' notification(s) failed: {message}',
                [ 'message' => $e->getMessage() ]
            );
            $http_response = $this->get_new_response_object_for_failed_request();

            if ($e->getType() == 'curlerror' && curl_errno($e->getData()) == 28)
            {
                $http_response->status_code = 500;
            }
        }

        return $this->get_batch_response($http_response, $endpoints, json_encode($tmp_payload));
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the JPush push notifications
     *
     * @return JPushDispatcher Self reference
     */
    public function set_auth_token($auth_token)
    {
        $this->auth_token = $auth_token;

        $this->http->headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic ' . $this->auth_token,
        ];

        return $this;
    }

    /**
     * Get a Requests_Response object for a failed request.
     *
     * @return \Requests_Response New instance of a Requests_Response object.
     */
    protected function get_new_response_object_for_failed_request()
    {
        $http_response = new Requests_Response();

        $http_response->url = static::JPUSH_SEND_URL;

        return $http_response;
    }
}

?>
