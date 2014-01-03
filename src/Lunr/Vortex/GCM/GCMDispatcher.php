<?php

/**
 * This file contains functionality to dispatch Google Cloud Messaging Push Notifications.
 *
 * PHP Version 5.4
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

use Lunr\Vortex\PushNotificationDispatcherInterface;

/**
 * Google Cloud Messaging Push Notification Dispatcher.
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class GCMDispatcher implements PushNotificationDispatcherInterface
{

    /**
     * Push Notification endpoint.
     * @var String
     */
    private $endpoint;

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
     * Shared instance of the Configuration class.
     * @var Configuration
     */
    private $config;

    /**
     * Constructor.
     *
     * @param Curl            $curl   Shared instance of the Curl class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     * @param Configuration   $config Shared instance of the Configuration class.
     */
    public function __construct($curl, $logger, $config)
    {
        $this->endpoint   = '';
        $this->payload    = '';
        $this->auth_token = '';
        $this->curl       = $curl;
        $this->logger     = $logger;
        $this->config     = $config;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->endpoint);
        unset($this->payload);
        unset($this->auth_token);
        unset($this->curl);
        unset($this->logger);
        unset($this->config);
    }

    /**
     * Push the notification.
     *
     * @return GCMResponse $return Response object
     */
    public function push()
    {
        $this->curl->set_option('CURLOPT_HEADER', TRUE);
        $this->curl->set_http_headers(['Content-Type:application/json', 'Authorization: key=' . $this->auth_token]);

        $tmp_payload                     = json_decode($this->payload, TRUE);
        $tmp_payload['registration_ids'] = [$this->endpoint];
        $this->payload                   = json_encode($tmp_payload);

        $response = $this->curl->post_request($this->config['gcm']['google_send_url'], $this->payload);

        $this->endpoint   = '';
        $this->payload    = '';
        $this->auth_token = '';

        return new GCMResponse($response, $this->logger, $this->endpoint);
    }

    /**
     * Set the endpoint for the push.
     *
     * @param String $endpoint The endpoint for the push
     *
     * @return GCMSDispatcher $self Self reference
     */
    public function set_endpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the the payload to push.
     *
     * @param String &$payload The reference to the payload of the push
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

}

?>
