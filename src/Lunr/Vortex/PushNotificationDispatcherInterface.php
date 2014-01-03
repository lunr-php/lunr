<?php

/**
 * This file contains the PushNotificationDispatcherInterface interface which
 * is the base of all push notifications.
 *
 * PHP Version 5.4
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage General
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex;

/**
 * Push notification interface.
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage General
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
interface PushNotificationDispatcherInterface
{

    /**
     * Push the notification.
     *
     * @return PushNotificationResponseInterface $return Response object
     */
    public function push();

    /**
     * Set the endpoint for the push.
     *
     * @param String $endpoint The endpoint for the push
     *
     * @return PushNotificationDispatcherInterface $self Self reference
     */
    public function set_endpoint($endpoint);

    /**
     * Set the the payload to push.
     *
     * @param String &$payload The reference to the payload of the push
     *
     * @return PushNotificationDispatcherInterface $self Self reference
     */
    public function set_payload(&$payload);

}

?>
