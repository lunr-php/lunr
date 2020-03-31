<?php

/**
 * This file contains notification types for Windows Phone Push Notifications.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

/**
 * Windows Phone Push Notification Types.
 */
class MPNSType
{

    /**
     * Tile notification.
     * @var string
     */
    const TILE = 'token';

    /**
     * Toast notification.
     * @var string
     */
    const TOAST = 'toast';

    /**
     * Raw notification.
     * @var string
     */
    const RAW = 'raw';

}

?>
