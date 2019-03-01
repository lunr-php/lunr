<?php

/**
 * This file contains an abstraction for the response from the FCM server.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMResponse;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 */
class FCMResponse extends GCMResponse
{

    /**
     * Constructor.
     *
     * @param CurlResponse    $response  Curl Response object.
     * @param LoggerInterface $logger    Shared instance of a Logger.
     * @param string          $device_id The deviceID that the message was sent to.
     */
    public function __construct($response, $logger, $device_id)
    {
        parent::__construct($response, $logger, $device_id);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

}

?>
