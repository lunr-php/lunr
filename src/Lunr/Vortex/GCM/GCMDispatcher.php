<?php

/**
 * This file contains functionality to dispatch Google Cloud Messaging Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * Google Cloud Messaging Push Notification Dispatcher.
 */
class GCMDispatcher implements PushNotificationMultiDispatcherInterface
{

    /**
     * Maximum number of endpoints allowed in one push.
     * @var Integer
     */
    const BATCH_SIZE = 1000;

    /**
     * Push Notification endpoints.
     * @var Array
     */
    protected $endpoints;

    /**
     * Push Notification payload to send.
     * @var String
     */
    protected $payload;

    /**
     * Push Notification authentication token.
     * @var String
     */
    protected $auth_token;

    /**
     * Push Notification Priority
     * @var string
     */
    protected $priority;

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
     * Url to send the GCM push notification to.
     * @var String
     */
    const GOOGLE_SEND_URL = 'https://gcm-http.googleapis.com/gcm/send';

    /**
     * Service name.
     * @var String
     */
    const SERVICE_NAME = 'GCM';

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        $this->http   = $http;
        $this->logger = $logger;

        $this->reset();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->endpoints);
        unset($this->payload);
        unset($this->auth_token);
        unset($this->priority);
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Reset the variable members of the class.
     *
     * @return void
     */
    protected function reset()
    {
        $this->endpoints  = [];
        $this->payload    = '{}';
        $this->auth_token = '';
        $this->priority   = 'normal';
    }

    /**
     * Getter for GCMResponse.
     *
     * @return GCMResponse
     */
    public function get_response()
    {
        return new GCMResponse();
    }

    /**
     * Getter for GCMBatchResponse.
     *
     * @param \Requests_Response       $http_response Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger        Shared instance of a Logger.
     * @param Array                    $endpoints     The endpoints the message was sent to (in the same order as sent).
     *
     * @return GCMBatchResponse
     */
    public function get_batch_response($http_response, $logger, $endpoints)
    {
        return new GCMBatchResponse($http_response, $logger, $endpoints);
    }

    /**
     * Push the notification.
     *
     * @return GCMResponse $return Response object
     */
    public function push()
    {
        $gcm_response = $this->get_response();

        foreach (array_chunk($this->endpoints, self::BATCH_SIZE) as &$endpoints)
        {
            $batch_response = $this->push_batch($endpoints);

            $gcm_response->add_batch_response($batch_response, $endpoints);

            unset($batch_response);
        }

        unset($endpoints);

        $this->reset();

        return $gcm_response;
    }

    /**
     * Push the notification to a batch of endpoints.
     *
     * @param Array $endpoints Endpoints to sent it to in this batch
     *
     * @return GCMBatchResponse $return Response object
     */
    protected function push_batch(&$endpoints)
    {
        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => 'key=' . $this->auth_token,
        ];

        $tmp_payload = json_decode($this->payload, TRUE);

        if (count($endpoints) > 1)
        {
            $tmp_payload['registration_ids'] = $endpoints;
        }
        else if (isset($endpoints[0]))
        {
            $tmp_payload['to'] = $endpoints[0];
        }

        $tmp_payload['priority'] = $this->priority;

        try {
            $http_response = $this->http->post(static::GOOGLE_SEND_URL, $headers, json_encode($tmp_payload));
        } catch(Requests_Exception $e) {
            $this->logger->warning('Dispatching ' . static::SERVICE_NAME
                . ' notification(s) failed: {message}', [ 'message' => $e->getMessage() ]);
            $http_response = $this->get_new_response_object_for_failed_request();
        }

        $gcm_batch_response = $this->get_batch_response($http_response, $this->logger, $endpoints);

        return $gcm_batch_response;
    }

    /**
     * Set the endpoint(s) for the push.
     *
     * @param Array|String $endpoints The endpoint(s) for the push
     *
     * @return GCMSDispatcher $self Self reference
     */
    public function set_endpoints($endpoints)
    {
        $this->endpoints = !is_array($endpoints) ? [ $endpoints ] : $endpoints;

        return $this;
    }

    /**
     * Set the the payload to push.
     *
     * @param String $payload The reference to the payload of the push
     *
     * @return GCMDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

    /**
     * Set the the auth token for the http headers.
     *
     * @param String $auth_token The auth token for the gcm push notifications
     *
     * @return GCMDispatcher $self Self reference
     */
    public function set_auth_token($auth_token)
    {
        $this->auth_token = $auth_token;

        return $this;
    }

    /**
     * Sets the notification priority.
     *
     * @see https://developers.google.com/cloud-messaging/concept-options#setting-the-priority-of-a-message
     *
     * @param string $priority notification priority (normal|high)
     *
     * @return GCMPayload $self Self Reference
     */
    public function set_priority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get a Requests_Response object for a failed request.
     *
     * @return \Requests_Response $http_response New instance of a Requests_Response object.
     */
    protected function get_new_response_object_for_failed_request()
    {
        $http_response = new Requests_Response();

        $http_response->url = static::GOOGLE_SEND_URL;

        return $http_response;
    }

}

?>
