<?php

/**
 * This file contains functionality to dispatch Windows Phone Push Notifications.
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
        $this->http     = $http;
        $this->logger   = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Push the notification.
     *
     * @param MPNSPayload $payload   Payload object
     * @param array       $endpoints Endpoints to send to in this batch
     *
     * @return MPNSResponse $return Response object
     */
    public function push($payload, &$endpoints)
    {
        $type = MPNSType::RAW;
        if ($payload instanceof MPNSToastPayload)
        {
            $type = MPNSTYPE::TOAST;
        }
        elseif ($payload instanceof MPNSTilePayload)
        {
            $type = MPNSTYPE::TILE;
        }

        $headers = [
            'Content-Type' => 'text/xml',
            'Accept'       => 'application/*',
        ];

        if (($type === MPNSType::TILE) || ($type === MPNSType::TOAST))
        {
            $headers['X-WindowsPhone-Target'] = $type;
        }

        $priority = $payload->get_priority();
        if ($priority !== 0)
        {
            $headers['X-NotificationClass'] = $priority;
        }

        try
        {
            $response = $this->http->post($endpoints[0], $headers, $payload->get_payload());
        }
        catch (Requests_Exception $e)
        {
            $response = $this->get_new_response_object_for_failed_request($endpoints[0]);
            $context  = [ 'error' => $e->getMessage(), 'endpoint' => $endpoints[0] ];

            $this->logger->warning('Dispatching push notification to {endpoint} failed: {error}', $context);
        }

        return new MPNSResponse($response, $this->logger);
    }

    /**
     * Get a Requests_Response object for a failed request.
     *
     * @param string $endpoint Endpoint to send to
     *
     * @return \Requests_Response $http_response New instance of a Requests_Response object.
     */
    protected function get_new_response_object_for_failed_request($endpoint)
    {
        $http_response = new Requests_Response();

        $http_response->url = $endpoint;

        return $http_response;
    }

}

?>
