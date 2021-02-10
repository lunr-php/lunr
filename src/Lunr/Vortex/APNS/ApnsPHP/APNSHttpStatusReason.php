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
 * Apple Push Notification Service status reasons.
 */
class APNSHttpStatusReason
{

    /**
     * Bad token error.
     * @var string
     */
    const ERROR_BAD_TOKEN = 'BadDeviceToken';

    /**
     * Bad collapse ID error.
     * @var string
     */
    const ERROR_BAD_COLLAPSE_ID = 'BadCollapseId';

    /**
     * Bad expiration date error.
     * @var string
     */
    const ERROR_BAD_EXPIRATION_DATE = 'BadExpirationDate';

    /**
     * Bad message ID error.
     * @var string
     */
    const ERROR_BAD_MESSAGE_ID = 'BadMessageId';

    /**
     * Bad priority error.
     * @var string
     */
    const ERROR_BAD_PRIORITY = 'BadPriority';

    /**
     * Bad topic error.
     * @var string
     */
    const ERROR_BAD_TOPIC = 'BadTopic';

    /**
     * Token not for current topic error.
     * @var string
     */
    const ERROR_NON_MATCHING_TOKEN = 'DeviceTokenNotForTopic';

    /**
     * Idle timeout.
     * @var string
     */
    const ERROR_IDLE_TIMEOUT = 'IdleTimeout';

    /**
     * Topic not allowed error.
     * @var string
     */
    const ERROR_TOPIC_BLOCKED = 'TopicDisallowed';

    /**
     * Certificate is not valid.
     * @var string
     */
    const ERROR_CERTIFICATE_INVALID = 'BadCertificate';

    /**
     * Certificate does not match requested environment.
     * @var string
     */
    const ERROR_CERTIFICATE_ENVIRONMENT = 'BadCertificateEnvironment';

    /**
     * JWT Provider token is expired.
     * @var string
     */
    const ERROR_EXPIRED_AUTH_TOKEN = 'ExpiredProviderToken';

    /**
     * JWT Provider token is invalid.
     * @var string
     */
    const ERROR_INVALID_AUTH_TOKEN = 'InvalidProviderToken';

    /**
     * JWT Provider token is missing.
     * @var string
     */
    const ERROR_MISSING_AUTH_TOKEN = 'MissingProviderToken';

    /**
     * Action is forbidden.
     * @var string
     */
    const ERROR_FORBIDDEN = 'Forbidden';

}

?>
