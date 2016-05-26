<?php

/**
 * This file contains functionality to dispatch Google Cloud Messaging Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;

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
    private $endpoints;

    /**
     * Push Notification payload to send.
     * @var String
     */
    private $payload;

    /**
     * Push Notification authentication token.
     * @var String
     */
    private $auth_token;

    /**
     * Push Notification Priority
     * @var string
     */
    private $priority;

    /**
     * Shared instance of the Curl class.
     * @var Curl
     */
    private $curl;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Url to send the GCM push notification to.
     * @var String
     */
    const GOOGLE_SEND_URL = 'https://gcm-http.googleapis.com/gcm/send';

    /**
     * Constructor.
     *
     * @param Curl            $curl   Shared instance of the Curl class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($curl, $logger)
    {
        $this->curl   = $curl;
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
        unset($this->curl);
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
     * Push the notification.
     *
     * @return GCMResponse $return Response object
     */
    public function push()
    {
        $gcm_response = new GCMResponse();

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
        $this->curl->set_option('CURLOPT_FAILONERROR', FALSE);
        $this->curl->set_http_headers(['Content-Type:application/json', 'Authorization: key=' . $this->auth_token]);

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

        $curl_response      = $this->curl->post_request(self::GOOGLE_SEND_URL, json_encode($tmp_payload));
        $gcm_batch_response = new GCMBatchResponse($curl_response, $this->logger, $this->endpoints);

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

}

?>
