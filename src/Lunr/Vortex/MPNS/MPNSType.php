<?php

/**
 * This file contains notification types for Windows Phone Push Notifications.
 *
 * PHP Version 5.4
 *
 * @category   Types
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

/**
 * Windows Phone Push Notification Types.
 *
 * @category   Types
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MPNSType
{

    /**
     * Tile notification.
     * @var String
     */
    const TILE = 'token';

    /**
     * Toast notification.
     * @var String
     */
    const TOAST = 'toast';

    /**
     * Raw notification.
     * @var String
     */
    const RAW = 'raw';

}

?>
