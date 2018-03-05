<?php

/**
 * This file contains functionality to dispatch Windows Phone Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * Windows Phone Push Notification Dispatcher.
 */
class MPNSDispatcher implements PushNotificationDispatcherInterface
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
     * Delivery priority for the push notification.
     * @var Integer
     */
    private $priority;

    /**
     * Push notification type.
     * @var String
     */
    private $type;

    /**
     * Shared instance of the Requests_Session class.
     * @var \Requests_Session
     */
    private $http;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        $this->endpoint = '';
        $this->payload  = '';
        $this->priority = 0;
        $this->http     = $http;
        $this->logger   = $logger;
        $this->type     = MPNSType::RAW;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->endpoint);
        unset($this->payload);
        unset($this->priority);
        unset($this->type);
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Push the notification.
     *
     * @return MPNSResponse $return Response object
     */
    public function push()
    {
        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        if (($this->type === MPNSType::TILE) || ($this->type === MPNSType::TOAST))
        {
            $headers['X-WindowsPhone-Target'] = $this->type;
        }

        if ($this->priority !== 0)
        {
            $headers['X-NotificationClass'] = $this->priority;
        }

        try
        {
            $response = $this->http->post($this->endpoint, $headers, $this->payload);
        }
        catch (Requests_Exception $e)
        {
            $response = $this->get_new_response_object_for_failed_request();
            $context  = [ 'error' => $e->getMessage(), 'endpoint' => $this->endpoint ];

            $this->logger->warning('Dispatching push notification to {endpoint} failed: {error}', $context);
        }

        $this->endpoint = '';
        $this->payload  = '';
        $this->priority = 0;
        $this->type     = MPNSType::RAW;

        return new MPNSResponse($response, $this->logger);
    }

    /**
     * Set the endpoint(s) for the push.
     *
     * @param Array|String $endpoints The endpoint(s) for the push
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_endpoints($endpoints)
    {
        if (is_array($endpoints))
        {
            $this->endpoint = empty($endpoints) ? '' : $endpoints[0];
        }
        else
        {
            $this->endpoint = $endpoints;
        }

        return $this;
    }

    /**
     * Set the the payload to push.
     *
     * @param String $payload The reference to the payload of the push
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

    /**
     * Set the priority for the push notification.
     *
     * @param Integer $priority Priority for the push notification.
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_priority($priority)
    {
        if (in_array($priority, [ 1, 2, 3, 11, 12, 13, 21, 22, 23 ]))
        {
            $this->priority = $priority;
        }

        return $this;
    }

    /**
     * Set the type for the push notification.
     *
     * @param String $type Type for the push notification.
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_type($type)
    {
        if (in_array($type, [ MPNSType::TOAST, MPNSType::TILE, MPNSType::RAW ]))
        {
            $this->type = $type;
        }

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

        $http_response->url = $this->endpoint;

        return $http_response;
    }

}

?>
