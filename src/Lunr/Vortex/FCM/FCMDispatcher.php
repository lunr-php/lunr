<?php

/**
 * This file contains functionality to dispatch Firebase Cloud Messaging Push Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMDispatcher;
use Lunr\Vortex\PushNotificationDispatcherInterface;

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
     * Service name.
     * @var String
     */
    const SERVICE_NAME = 'FCM';

    /**
     * Constructor.
     *
     * @param \Requests_Session        $http   Shared instance of the Requests_Session class.
     * @param \Psr\Log\LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($http, $logger)
    {
        parent::__construct($http, $logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Getter for FCMResponse.
     *
     * @return FCMResponse
     */
    public function get_response()
    {
        return new FCMResponse();
    }

    /**
     * Getter for FCMBatchResponse.
     *
     * @param \Requests_Response       $http_response Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger        Shared instance of a Logger.
     * @param Array                    $endpoints     The endpoints the message was sent to (in the same order as sent).
     *
     * @return FCMBatchResponse
     */
    public function get_batch_response($http_response, $logger, $endpoints)
    {
        return new FCMBatchResponse($http_response, $logger, $endpoints);
    }

}

?>
