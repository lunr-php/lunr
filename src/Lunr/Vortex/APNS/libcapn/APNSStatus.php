<?php

/**
 * This file contains Apple Push Notification Service stream status codes.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\libcapn;

/**
 * Apple Push Notification Service status codes.
 *
 * The file contains the combined codes of the ones that Apple gives back
 * as the status of the push notification connection & delivery, together
 * with any possible internal error that might happen in the low level
 * library we are using.
 */
class APNSStatus
{

    /**
     * Successful delivery.
     * @var Integer
     */
    const APN_SUCCESS = 0;

    /**
     * Context not initialized.
     * @var Integer
     */
    const APN_ERR_CTX_NOT_INITIALIZED = 1;

    /**
     * No opened connection to Apple Push Notification Service.
     * @var Integer
     */
    const APN_ERR_NOT_CONNECTED = 2;

    /**
     * No opened connection to Apple Push Feedback Service.
     * @var Integer
     */
    const APN_ERR_NOT_CONNECTED_FEEDBACK = 3;

    /**
     * Connection was closed.
     * @var Integer
     */
    const APN_ERR_CONNECTION_CLOSED = 4;

    /**
     * Invalid argument provided.
     * @var Integer
     */
    const APN_ERR_INVALID_ARGUMENT = 5;

    /**
     * Path to SSL certificate file is not set.
     * @var Integer
     */
    const APN_ERR_CERTIFICATE_IS_NOT_SET = 6;

    /**
     * Path to private key file is not set.
     * @var Integer
     */
    const APN_ERR_PRIVATE_KEY_IS_NOT_SET = 7;

    /**
     * Notification payload is not set.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_IS_NOT_SET = 8;

    /**
     * Device token is not set.
     * @var Integer
     */
    const APN_ERR_TOKEN_IS_NOT_SET = 9;

    /**
     * Invalid device token.
     * @var Integer
     */
    const APN_ERR_TOKEN_INVALID = 10;

    /**
     * Added too many device tokens.
     * @var Integer
     */
    const APN_ERR_TOKEN_TOO_MANY = 11;

    /**
     * Unable to use specified SSL certificate.
     * @var Integer
     */
    const APN_ERR_UNABLE_TO_USE_SPECIFIED_CERTIFICATE = 12;

    /**
     * Unable to use specified private key to set up a secure connection.
     * @var Integer
     */
    const APN_ERR_UNABLE_TO_USE_SPECIFIED_PRIVATE_KEY = 13;

    /**
     * Unable to resolve host.
     * @var Integer
     */
    const APN_ERR_COULD_NOT_RESOLVE_HOST = 14;

    /**
     * Unable to create TCP socket.
     * @var Integer
     */
    const APN_ERR_COULD_NOT_CREATE_SOCKET = 15;

    /**
     * System call select() returned error.
     * @var Integer
     */
    const APN_ERR_SELECT = 16;

    /**
     * Could not initialize connection.
     * @var Integer
     */
    const APN_ERR_COULD_NOT_INITIALIZE_CONNECTION = 17;

    /**
     * Could not initialize SSL connection.
     * @var Integer
     */
    const APN_ERR_COULD_NOT_INITIALIZE_SSL_CONNECTION = 18;

    /**
     * SSL_write failed.
     * @var Integer
     */
    const APN_ERR_SSL_WRITE_FAILED = 19;

    /**
     * SSL_read failed.
     * @var Integer
     */
    const APN_ERR_SSL_READ_FAILED = 20;

    /**
     * Invalid size of notification payload.
     * @var Integer
     */
    const APN_ERR_INVALID_PAYLOAD_SIZE = 21;

    /**
     * Payload notification contex is not initialized.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_CTX_NOT_INITIALIZED = 22;

    /**
     * Incorrect number to display as the badge on application icon.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_BADGE_INVALID_VALUE = 23;

    /**
     * Too many custom properties. Max: 5
     * @var Integer
     */
    const APN_ERR_PAYLOAD_TOO_MANY_CUSTOM_PROPERTIES = 24;

    /**
     * Specified custom property key is already used.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_CUSTOM_PROPERTY_KEY_IS_ALREADY_USED = 25;

    /**
     * Could not create json document.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_COULD_NOT_CREATE_JSON_DOCUMENT = 26;

    /**
     * Alert message text is not set.
     * @var Integer
     */
    const APN_ERR_PAYLOAD_ALERT_IS_NOT_SET = 27;

    /**
     * Non-UTF8 symbols detected in a string.
     * @var Integer
     */
    const APN_ERR_STRING_CONTAINS_NON_UTF8_CHARACTERS = 28;

    /**
     * Processing error.
     * @var Integer
     */
    const APN_ERR_PROCESSING_ERROR = 29;

    /**
     * Unknown error.
     * @var Integer
     */
    const APN_ERR_UNKNOWN = 30;

}

?>
