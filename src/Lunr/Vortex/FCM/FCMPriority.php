<?php

/**
 * This file contains priority types for delivering Firebase Cloud Messaging Notifications.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

/**
 * Firebase Cloud Messaging Notification Priority Types.
 */
class FCMPriority
{

    /**
     * Deliver notification immediately.
     * @var Integer
     */
    const HIGH = 'high';

    /**
     * Deliver notification with normal priority.
     * @var Integer
     */
    const NORMAL = 'normal';

}

?>
