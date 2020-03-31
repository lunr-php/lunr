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
class APNSStatus
{

    /**
     * No error encountered.
     * @var integer
     */
    const SUCCESS = 0;

    /**
     * Processing error.
     * @var integer
     */
    const ERROR_PROCESSING = 1;

    /**
     * Missing device token error.
     * @var integer
     */
    const ERROR_MISSING_DEVICE_TOKEN = 2;

    /**
     * Missing topic error.
     * @var integer
     */
    const ERROR_TOPIC = 3;

    /**
     * Missing payload error.
     * @var integer
     */
    const ERROR_MISSING_PAYLOAD = 4;

    /**
     * Invalid token size error.
     * @var integer
     */
    const ERROR_INVALID_TOKEN_SIZE = 5;

    /**
     * Invalid topic size error.
     * @var integer
     */
    const ERROR_INVALID_TOPIC_SIZE = 6;

    /**
     * Invalid payload size error.
     * @var integer
     */
    const ERROR_INVALID_PAYLOAD_SIZE = 7;

    /**
     * Invalid token error.
     * @var integer
     */
    const ERROR_INVALID_TOKEN = 8;

    /**
     * Shutdown error.
     * @var integer
     */
    const ERROR_SHUTDOWN = 10;

    /**
     * Protocol error,
     * @var integer
     */
    const ERROR_PROTOCOL = 128;

    /**
     * Unknown error.
     * @var integer
     */
    const ERROR_UNKNOWN = 255;

}

?>
