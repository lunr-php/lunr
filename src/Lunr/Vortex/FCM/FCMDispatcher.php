<?php

/**
 * This file contains functionality to dispatch Firebase Cloud Messaging Push Notifications.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * Google Cloud Messaging Push Notification Dispatcher.
 */
class FCMDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Maximum number of endpoints allowed in one push.
     * @var integer
     */
    const BATCH_SIZE = 1000;

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
     * Url to send the FCM push notification to.
     * @var string
     */
    const GOOGLE_SEND_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Service name.
     * @var string
     */
    const SERVICE_NAME = 'FCM';

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
        $this->auth_token = '';
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
     * Getter for FCMResponse.
     *
     * @return FCMResponse
     */
    public function get_response()
    {
        return new FCMResponse();
    }

    /**
     * Getter for FCMBatchResponse.
     *
     * @param \Requests_Response       $http_response Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger        Shared instance of a Logger.
     * @param array                    $endpoints     The endpoints the message was sent to (in the same order as sent).
     * @param string                   $payload       Raw payload that was sent to FCM.
     *
     * @return FCMBatchResponse
     */
    public function get_batch_response($http_response, $logger, $endpoints, $payload)
    {
        return new FCMBatchResponse($http_response, $logger, $endpoints, $payload);
    }

    /**
     * Push the notification.
     *
     * @param FCMPayload $payload   Payload object
     * @param array      $endpoints Endpoints to send to in this batch
     *
     * @return FCMResponse Response object
     */
    public function push($payload, &$endpoints)
    {
        $gcm_response = $this->get_response();

        foreach (array_chunk($endpoints, static::BATCH_SIZE) as &$batch)
        {
            $batch_response = $this->push_batch($payload, $batch);

            $gcm_response->add_batch_response($batch_response, $batch);

            unset($batch_response);
        }

        unset($batch);

        return $gcm_response;
    }

    /**
     * Push the notification to a batch of endpoints.
     *
     * @param FCMPayload $payload   Payload object
     * @param array      $endpoints Endpoints to send to in this batch
     *
     * @return FCMBatchResponse Response object
     */
    protected function push_batch($payload, &$endpoints)
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=' . $this->auth_token,
        ];

        $tmp_payload = json_decode($payload->get_payload(), TRUE);

        if (count($endpoints) > 1)
        {
            $tmp_payload['registration_ids'] = $endpoints;
        }
        elseif (isset($endpoints[0]))
        {
            $tmp_payload['to'] = $endpoints[0];
        }

        try
        {
            $options = [
                'timeout'         => 15, // timeout in seconds
                'connect_timeout' => 15 // timeout in seconds
            ];

            $http_response = $this->http->post(static::GOOGLE_SEND_URL, $headers, json_encode($tmp_payload), $options);
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

        $gcm_batch_response = $this->get_batch_response($http_response, $this->logger, $endpoints, json_encode($tmp_payload));

        return $gcm_batch_response;
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the gcm push notifications
     *
     * @return FCMDispatcher Self reference
     */
    public function set_auth_token($auth_token)
    {
        $this->auth_token = $auth_token;

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

        $http_response->url = static::GOOGLE_SEND_URL;

        return $http_response;
    }

}

?>
