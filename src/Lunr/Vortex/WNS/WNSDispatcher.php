<?php

/**
 * This file contains functionality to dispatch Windows Push Notifications.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * Windows Push Notification Dispatcher.
 */
class WNSDispatcher implements PushNotificationDispatcherInterface
{
    /**
     * Client Secret to use when obtaining an oauth token
     * @var string
     */
    protected $client_secret;

    /**
     * Client ID to use when obtaining an oauth token
     * @var string
     */
    protected $client_id;

    /**
     * The authentication token to identify the app channel
     * @var string
     */
    private $oauth_token;

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
     * The URL to use to request an OAuth token.
     * @var string
     */
    const TOKEN_URL = 'https://login.live.com/accesstoken.srf';

    /**
     * The scope to request the oauth token from.
     * @var string
     */
    const NOTIFICATION_SCOPE = 'notify.windows.com';

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        $this->http          = $http;
        $this->logger        = $logger;
        $this->type          = WNSType::RAW;
        $this->client_id     = NULL;
        $this->client_secret = NULL;
        $this->oauth_token   = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->type);
        unset($this->http);
        unset($this->logger);
        unset($this->client_id);
        unset($this->client_secret);
        unset($this->oauth_token);
    }

    /**
     * Push the notification.
     *
     * @param WNSPayload $payload   Payload object
     * @param array      $endpoints Endpoints to send to in this batch
     *
     * @return WNSResponse $return Response object
     */
    public function push($payload, &$endpoints)
    {
        if (!isset($this->oauth_token))
        {
            $this->logger->warning('Tried to push notification to {endpoint} but wasn\'t authenticated.', [ 'endpoint' => $endpoints[0] ]);
            $response = $this->get_new_response_object_for_failed_request($endpoints[0]);

            $this->type = WNSType::RAW;

            return new WNSResponse($response, $this->logger);
        }

        if ($payload instanceof WNSToastPayload)
        {
            $this->set_type(WNSType::TOAST);
        }
        elseif ($payload instanceof WNSTilePayload)
        {
            $this->set_type(WNSType::TILE);
        }
        elseif ($payload instanceof WNSBadgePayload)
        {
            $this->set_type(WNSType::BADGE);
        }
        else
        {
            $this->set_type(WNSType::RAW);
        }

        $headers = [
            'X-WNS-Type'             => 'wns/' . $this->type,
            'Accept'                 => 'application/*',
            'Authorization'          => 'Bearer ' . $this->oauth_token,
            'X-WNS-RequestForStatus' => 'true',
        ];

        if ($this->type === WNSType::RAW)
        {
            $headers['Content-Type'] = 'application/octet-stream';
        }
        else
        {
            $headers['Content-Type'] = 'text/xml';
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

        $this->type = WNSType::RAW;

        return new WNSResponse($response, $this->logger);
    }

    /**
     * Set the type for the push notification.
     *
     * @param string $type Type for the push notification.
     *
     * @return WNSDispatcher $self Self reference
     */
    public function set_type($type)
    {
        if (in_array($type, [ WNSType::TOAST, WNSType::TILE, WNSType::RAW, WNSType::BADGE ]))
        {
            $this->type = $type;
        }

        return $this;
    }

    /**
     * Set the client_id for the oauth request
     *
     * @param string $client_id The client id from the Windows Dashboard
     *
     * @return WNSDispatcher $self Self reference
     */
    public function set_client_id($client_id)
    {
        $this->client_id = $client_id;
        return $this;
    }

    /**
     * Set the client_secret for the oauth request
     *
     * @param string $client_secret The client secret from the Windows Dashboard
     *
     * @return WNSDispatcher $self Self reference
     */
    public function set_client_secret($client_secret)
    {
        $this->client_secret = $client_secret;
        return $this;
    }

    /**
     * Get an oath token from the microsoft webservice.
     *
     * @return string|boolean the oauth access token or FALSE if it failed.
     */
    public function get_oauth_token()
    {
        $request_post = [
            'grant_type'    => 'client_credentials',
            'client_id'     => $this->client_id,
            'client_secret' => $this->client_secret,
            'scope'         => self::NOTIFICATION_SCOPE,
        ];

        $headers = [ 'Content-Type' => 'application/x-www-form-urlencoded' ];

        try
        {
            $response = $this->http->post(self::TOKEN_URL, $headers, $request_post);
        }
        catch (Requests_Exception $e)
        {
            $this->logger->warning('Requesting token failed: No response');
            return FALSE;
        }

        $response_object = json_decode($response->body);

        if (!(json_last_error() === JSON_ERROR_NONE))
        {
            $this->logger->warning('Requesting token failed: Malformed JSON response');
            return FALSE;
        }

        if (!property_exists($response_object, 'access_token'))
        {
            $this->logger->warning('Requesting token failed: Not a valid JSON response');
            return FALSE;
        }

        return $response_object->access_token;
    }

    /**
     * Set a token to authenticate with.
     *
     * @param string $token The OAuth token to use
     *
     * @return void
     */
    public function set_oauth_token($token)
    {
        $this->oauth_token = $token;
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
