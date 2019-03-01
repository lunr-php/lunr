<?php

/**
 * This file contains functionality to dispatch Google Cloud Messaging Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMDispatcher;

/**
 * Google Cloud Messaging Push Notification Dispatcher.
 */
class FCMDispatcher extends GCMDispatcher
{

    /**
     * Url to send the FCM push notification to.
     * @var String
     */
    const GOOGLE_SEND_URL = 'https://fcm.googleapis.com/fcm/send';

    /**
     * Constructor.
     *
     * @param Curl            $curl   Shared instance of the Curl class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($curl, $logger)
    {
        parent::__construct($curl, $logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Push the notification.
     *
     * @return FCMResponse $return Response object
     */
    public function push()
    {
        $this->curl->set_option('CURLOPT_HEADER', TRUE);
        $this->curl->set_http_headers(['Content-Type:application/json', 'Authorization: key=' . $this->auth_token]);

        $tmp_payload             = json_decode($this->payload, TRUE);
        $tmp_payload['to']       = $this->endpoint;
        $tmp_payload['priority'] = $this->priority;
        $this->payload           = json_encode($tmp_payload);

        $response = $this->curl->post_request(self::GOOGLE_SEND_URL, $this->payload);

        $res = new FCMResponse($response, $this->logger, $this->endpoint);

        $this->endpoint = '';
        $this->payload  = '';

        return $res;
    }

}

?>
