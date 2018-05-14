<?php

/**
 * This file contains functionality to dispatch PAP Format Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use Requests_Exception;
use Requests_Response;

/**
 * PAP Format Push Notification Dispatcher.
 */
class PAPDispatcher implements PushNotificationDispatcherInterface
{

    /**
     * Push Notification authentication token.
     * @var String
     */
    private $auth_token;

    /**
     * Push Notification password.
     * @var String
     */
    private $password;

    /**
     * Push Notification content provider id.
     * @var String
     */
    private $cid;

    /**
     * Push Notification deliver before timestamp.
     * @var String
     */
    private $deliverbefore;

    /**
     * Unique push identifier for each notification.
     * @var String
     */
    private $push_id;

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
     * Boundary string for the PAP request.
     * @var String
     */
    const PAP_BOUNDARY = 'mPsbVQo0a68eIL3OAxnm';

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        $this->auth_token    = '';
        $this->password      = '';
        $this->cid           = '';
        $this->deliverbefore = '';
        $this->push_id       = '';
        $this->http          = $http;
        $this->logger        = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->auth_token);
        unset($this->password);
        unset($this->cid);
        unset($this->deliverbefore);
        unset($this->push_id);
        unset($this->http);
        unset($this->logger);
    }

    /**
     * Push the notification.
     *
     * @param PAPPayload $payload   Payload object
     * @param array      $endpoints Endpoints to send to in this batch
     *
     * @return PAPResponse $return Response object
     */
    public function push($payload, &$endpoints)
    {
        // construct PAP URL
        $pap_url = "https://cp{$this->cid}.pushapi.na.blackberry.com/mss/PD_pushRequest";

        $pap_data = $this->construct_pap_data($payload, $endpoints[0]);

        $options = [
            'auth' => [
                $this->auth_token,
                $this->password,
            ],
        ];

        $headers = [
            'Content-Type' => 'multipart/related; boundary=' . self::PAP_BOUNDARY . '; type=application/xml',
            'Accept'       => 'text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2',
            'Connection'   => 'keep-alive',
        ];

        try
        {
            $response = $this->http->post($pap_url, $headers, $pap_data, $options);
        }
        catch (Requests_Exception $e)
        {
            $response = $this->get_new_response_object_for_failed_request();
            $context  = [ 'error' => $e->getMessage(), 'endpoint' => $endpoints[0] ];

            $this->logger->warning('Dispatching push notification to {endpoint} failed: {error}', $context);
        }

        $this->push_id       = '';
        $this->deliverbefore = '';

        return new PAPResponse($response, $this->logger, $endpoints[0]);
    }

    /**
     * Constructs the control XML of the PAP request.
     *
     * @param string $endpoint Endpoint to send to
     *
     * @return String $xml The control XML populated with all relevant values
     */
    protected function construct_pap_control_xml($endpoint)
    {
        // construct PAP control xml
        // @codingStandardsIgnoreStart
        $xml  = "<?xml version=\"1.0\"?>\n";
        $xml .= "<!DOCTYPE pap PUBLIC \"-//WAPFORUM//DTD PAP 2.1//EN\" \"http://www.openmobilealliance.org/tech/DTD/pap_2.1.dtd\">\n";
        $xml .= "<pap>\n";
        $xml .= "<push-message push-id=\"{$this->push_id}\" source-reference=\"{$this->auth_token}\" deliver-before-timestamp=\"{$this->deliverbefore}\">\n";
        $xml .= "<address address-value=\"$endpoint\"/>\n";
        $xml .= "<quality-of-service delivery-method=\"unconfirmed\"/>\n";
        $xml .= "</push-message>\n</pap>\n";
        // @codingStandardsIgnoreEnd

        return $xml;
    }

    /**
     * Constructs the full data of the PAP request.
     *
     * @param PAPPayload $payload  Payload object
     * @param string     $endpoint Endpoint to send to
     *
     * @return String $data The PAP request data populated with all relevant values
     */
    protected function construct_pap_data($payload, $endpoint)
    {
        $this->push_id = $endpoint . microtime(TRUE);

        // inject the unique push id in the payload
        $tmp_payload       = json_decode($payload->get_payload(), TRUE);
        $tmp_payload['id'] = $this->push_id;

        // construct custom headers; inject control xml & payload
        $data  = '--' . self::PAP_BOUNDARY . "\r\n";
        $data .= "Content-Type: application/xml; charset=UTF-8\r\n\r\n";
        $data .= $this->construct_pap_control_xml($endpoint) . "\r\n--";
        $data .= self::PAP_BOUNDARY . "\r\n";
        $data .= "Content-Type: text/plain\r\n";
        $data .= 'Push-Message-ID: ' . $this->push_id . "\r\n\r\n";
        $data .= json_encode($tmp_payload) . "\r\n--";
        $data .= self::PAP_BOUNDARY . "--\n\r";

        return $data;
    }

    /**
     * Set the auth token for the http headers.
     *
     * @param string $auth_token The auth token for the PAP push notifications
     *
     * @return PAPDispatcher $self Self reference
     */
    public function set_auth_token($auth_token)
    {
        $this->auth_token = $auth_token;

        return $this;
    }

    /**
     * Set the password for the push service.
     *
     * @param string $password The password of the push service
     *
     * @return PAPDispatcher $self Self reference
     */
    public function set_password($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set the content provider id for the push service.
     *
     * @param string $cid The content provider id for the PAP push notifications
     *
     * @return PAPDispatcher $self Self reference
     */
    public function set_content_provider_id($cid)
    {
        $this->cid = $cid;

        return $this;
    }

    /**
     * Set the deliver-before timestamp for the push service.
     *
     * @param string $timestamp The timestamp to set the deliver-before to
     *
     * @return PAPDispatcher $self Self reference
     */
    public function set_deliver_before_timestamp($timestamp)
    {
        $this->deliverbefore = $timestamp;

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

        $http_response->url = "https://cp{$this->cid}.pushapi.na.blackberry.com/mss/PD_pushRequest";

        return $http_response;
    }

}

?>
