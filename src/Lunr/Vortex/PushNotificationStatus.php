<?php

/**
 * Push Notification delivery status.
 *
 * @package    Lunr\Vortex
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex;

/**
 * Windows Phone Push Notification Priority Types.
 */
class PushNotificationStatus
{

    /**
     * Push notification status unknown.
     * @var integer
     */
    const UNKNOWN = 0;

    /**
     * Push notification delivered successfully.
     * @var integer
     */
    const SUCCESS = 1;

    /**
     * Push notification could not be delivered. Try again later.
     * @var integer
     */
    const TEMPORARY_ERROR = 2;

    /**
     * Push notification endpoint invalid.
     * @var integer
     */
    const INVALID_ENDPOINT = 3;

    /**
     * Push notification not delivered because of client misconfiguration.
     * @var integer
     */
    const CLIENT_ERROR = 4;

    /**
     * Push notification not delivered because of server error.
     * @var integer
     */
    const ERROR = 5;

}

?>
