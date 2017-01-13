<?php

/**
 * This file contains functionality to dispatch Apple Push Notification Service.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\libcapn;

use Lunr\Vortex\PushNotificationDispatcherInterface;

/**
 * Apple Push Notification Service Dispatcher.
 */
class APNSDispatcher implements PushNotificationDispatcherInterface
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
     * Push Notification SSL certificate path.
     * @var String
     */
    private $certificate;

    /**
     * Push Notification SSL certificate passphrase.
     * @var String
     */
    private $passphrase;

    /**
     * APNS Connection mode.
     * @var String
     */
    private $mode;

    /**
     * Reference to the php_apn extension.
     * @var Resource
     */
    private $apn;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Whether the connection is set up as intended
     * @var Boolean
     */
    private $setup;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($logger)
    {
        $this->endpoint    = '';
        $this->payload     = '';
        $this->certificate = '';
        $this->passphrase  = '';
        $this->mode        = APN_PRODUCTION;
        $this->logger      = $logger;
        $this->setup       = FALSE;

        $this->apn = apn_init();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        apn_free($this->apn);

        unset($this->endpoint);
        unset($this->payload);
        unset($this->certificate);
        unset($this->passphrase);
        unset($this->logger);
        unset($this->apn);
        unset($this->setup);
    }

    /**
     * Push the notification.
     *
     * @return APNSResponse $return Response object
     */
    public function push()
    {
        if ($this->setup === FALSE)
        {
            apn_set_certificate($this->apn, $this->certificate);
            apn_set_private_key($this->apn, $this->certificate, $this->passphrase);
            apn_set_mode($this->apn, $this->mode);

            $this->setup = TRUE;
        }

        $tmp_payload = json_decode($this->payload, TRUE);

        $apn_payload = apn_payload_init();

        apn_payload_add_token($apn_payload, $this->endpoint);

        apn_payload_set_body($apn_payload, $tmp_payload['alert']);

        // set optional properties in the payload, if they exist
        if (isset($tmp_payload['sound']) && !empty($tmp_payload['sound']))
        {
            apn_payload_set_sound($apn_payload, $tmp_payload['sound']);
        }

        if (isset($tmp_payload['badge']) && !empty($tmp_payload['badge']))
        {
            apn_payload_set_badge($apn_payload, $tmp_payload['badge']);
        }

        if (isset($tmp_payload['custom_data']) && !empty($tmp_payload['custom_data']))
        {
            foreach ($tmp_payload['custom_data'] as $key => $value)
            {
                apn_payload_add_custom_property($apn_payload, $key, $value);
            }
        }

        $response = [];

        $response['error_code']    = 0;
        $response['error_message'] = NULL;

        apn_connect($this->apn, $response['error_message'], $response['error_code']);
        apn_send($this->apn, $apn_payload, $response['error_message'], $response['error_code']);

        apn_close($this->apn);
        apn_payload_free($apn_payload);

        $res = new APNSResponse($response, $this->logger, $this->endpoint);

        $this->endpoint = '';
        $this->payload  = '';

        return $res;
    }

    /**
     * Set the endpoint(s) for the push.
     *
     * @param Array|String $endpoints The endpoint(s) for the push
     *
     * @return APNSSDispatcher $self Self reference
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
     * @return APNSDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

    /**
     * Set the the SSL certificate path.
     *
     * @param String $certificate The path to the SSL certificate
     *
     * @return APNSDispatcher $self Self reference
     */
    public function set_certificate($certificate)
    {
        $this->certificate = $certificate;
        $this->setup       = FALSE;

        return $this;
    }

    /**
     * Set the the SSL certificate passphrase.
     *
     * @param String $passphrase The actual passphrase
     *
     * @return APNSDispatcher $self Self reference
     */
    public function set_passphrase($passphrase)
    {
        $this->passphrase = $passphrase;
        $this->setup      = FALSE;

        return $this;
    }

    /**
     * Use sandbox mode for sending push notifications.
     *
     * @param Boolean $sandbox TRUE for setting sandbox mode, FALSE for setting production mode
     *
     * @return APNSDispatcher $self Self reference
     */
    public function set_sandbox_mode($sandbox = TRUE)
    {
        $this->mode = $sandbox ? APN_SANDBOX : APN_PRODUCTION;

        return $this;
    }

}

?>
