<?php

/**
 * This file contains Apple Push Notification Service stream status codes.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP;

/**
 * Apple Push Notification Service status codes.
 */
class APNSHttpStatus
{

    /**
     * No error encountered.
     * @var integer
     */
    const SUCCESS = 200;

    /**
     * Bad request error.
     * @var integer
     */
    const ERROR_BAD_REQUEST = 400;

    /**
     * Certificate or token error.
     * @var integer
     */
    const ERROR_AUTHENTICATION = 403;

    /**
     * The device token is inactive for the specified topic.
     * @var integer
     */
    const ERROR_UNREGISTERED = 410;

    /**
     * The message payload was too large.
     * @var integer
     */
    const ERROR_PAYLOAD_TOO_LARGE = 413;

    /**
     * The provider token is being updated too often.
     * @var integer
     */
    const TOO_MANY_REQUESTS = 429;

    /**
     * Unknown internal error.
     * @var integer
     */
    const ERROR_INTERNAL_ERROR = 500;

    /**
     * Shutdown error.
     * @var integer
     */
    const ERROR_SHUTDOWN = 503;

}

?>
