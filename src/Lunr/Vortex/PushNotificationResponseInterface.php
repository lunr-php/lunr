<?php

/**
 * This file contains the PushNotificationResponseInterface.
 *
 * PHP Version 5.4
 *
 * @package   Lunr\Vortex
 * @author    Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright 2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex;

/**
 * Push notification Response interface.
 */
interface PushNotificationResponseInterface
{

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param String $endpoint endpoint
     *
     * @return PushNotificationStatus $status Delivery status for the endpoint
     */
    public function get_status($endpoint);

}

?>
