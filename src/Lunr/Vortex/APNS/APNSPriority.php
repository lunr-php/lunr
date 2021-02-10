<?php

/**
 * This file contains priority types for delivering APNS Notifications.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS;

/**
 * APNS Priority Types.
 */
class APNSPriority
{

    /**
     * Deliver notification immediately.
     * @var string
     */
    const HIGH = 10;

    /**
     * Deliver notification with normal priority.
     * @var string
     */
    const NORMAL = 5;

}

?>
