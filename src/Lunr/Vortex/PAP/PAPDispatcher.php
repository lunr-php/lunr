<?php

/**
 * This file contains functionality to dispatch PAP Format Push Notifications.
 *
 * PHP Version 5.4
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP;

use Lunr\Vortex\PushNotificationDispatcherInterface;

/**
 * PAP Format Push Notification Dispatcher.
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class PAPDispatcher implements PushNotificationDispatcherInterface
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
     * Boundary string for the PAP request.
     * @var String
     */
    const PAP_BOUNDARY = 'mPsbVQo0a68eIL3OAxnm';

    /**
     * Constructor.
     *
     * @param Curl            $curl   Shared instance of the Curl class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($curl, $logger)
    {
        $this->endpoint      = '';
        $this->payload       = '';
        $this->auth_token    = '';
        $this->password      = '';
        $this->cid           = '';
        $this->deliverbefore = '';
        $this->push_id       = '';
        $this->curl          = $curl;
        $this->logger        = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->endpoint);
        unset($this->payload);
        unset($this->auth_token);
        unset($this->password);
        unset($this->cid);
        unset($this->deliverbefore);
        unset($this->push_id);
        unset($this->curl);
        unset($this->logger);
    }

    /**
     * Push the notification.
     *
     * @return PAPResponse $return Response object
     */
    public function push()
    {
        // construct PAP URL
        $pap_url = "https://cp{$this->cid}.pushapi.na.blackberry.com/mss/PD_pushRequest";

        $pap_data = $this->construct_pap_data();

        $this->curl->set_option('CURLOPT_URL', $pap_url);
        $this->curl->set_option('CURLOPT_HEADER', FALSE);
        $this->curl->set_option('CURLOPT_HTTP_VERSION', CURL_HTTP_VERSION_1_1);
        $this->curl->set_option('CURLOPT_HTTPAUTH', CURLAUTH_BASIC);
        $this->curl->set_option('CURLOPT_USERPWD', $this->auth_token . ':' . $this->password);
        $this->curl->set_option('CURLOPT_RETURNTRANSFER', TRUE);

        $this->curl->set_http_header("Content-Type: multipart/related; boundary=" . self::PAP_BOUNDARY . "; type=application/xml");
        $this->curl->set_http_header("Accept: text/html, image/gif, image/jpeg, *; q=.2, */*; q=.2");
        $this->curl->set_http_header("Connection: keep-alive");

        $response = $this->curl->post_request($pap_url, $pap_data);

        $this->push_id       = '';
        $this->payload       = '';
        $this->deliverbefore = '';

        return new PAPResponse($response, $this->logger, $this->endpoint);
    }

    /**
     * Constructs the control XML of the PAP request.
     *
     * @return String $pap_control The control XML populated with all relevant values
     */
    protected function construct_pap_control_xml()
    {
        // construct PAP control xml
        $pap_control  = "<?xml version=\"1.0\"?>\n";
        $pap_control .= "<!DOCTYPE pap PUBLIC \"-//WAPFORUM//DTD PAP 2.1//EN\" \"http://www.openmobilealliance.org/tech/DTD/pap_2.1.dtd\">\n";
        $pap_control .= "<pap>\n<push-message push-id=\"{$this->push_id}\" source-reference=\"{$this->auth_token}\" deliver-before-timestamp=\"{$this->deliverbefore}\">\n";
        $pap_control .= "<address address-value=\"{$this->endpoint}\"/>\n";
        $pap_control .= "<quality-of-service delivery-method=\"unconfirmed\"/>\n";
        $pap_control .= "</push-message>\n</pap>\n";

        return $pap_control;
    }

    /**
     * Constructs the full data of the PAP request.
     *
     * @return String $data The PAP request data populated with all relevant values
     */
    protected function construct_pap_data()
    {
        $this->push_id = $this->endpoint . microtime(TRUE);

        // inject the unique push id in the payload
        $tmp_payload       = json_decode($this->payload, TRUE);
        $tmp_payload['id'] = $this->push_id;
        $this->payload     = json_encode($tmp_payload);

        // construct custom headers; inject control xml & payload
        $data = '--' . self::PAP_BOUNDARY . "\r\n" .
                "Content-Type: application/xml; charset=UTF-8\r\n\r\n" .
                $this->construct_pap_control_xml() .
                "\r\n--" . self::PAP_BOUNDARY . "\r\n" .
                "Content-Type: text/plain\r\n" .
                'Push-Message-ID: ' . $this->push_id . "\r\n\r\n" .
                $this->payload .
                "\r\n--" . self::PAP_BOUNDARY . "--\n\r";

        return $data;
    }

    /**
     * Set the endpoint for the push.
     *
     * @param String $endpoint The endpoint for the push
     *
     * @return PAPDispatcher $self Self reference
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
     * @return PAPDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

    /**
     * Set the auth token for the http headers.
     *
     * @param String $auth_token The auth token for the PAP push notifications
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
     * @param String $password The password of the push service
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
     * @param String $cid The content provider id for the PAP push notifications
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
     * @param String $timestamp The timestamp to set the deliver-before to
     *
     * @return PAPDispatcher $self Self reference
     */
    public function set_deliver_before_timestamp($timestamp)
    {
        $this->deliverbefore = $timestamp;

        return $this;
    }

}

?>
