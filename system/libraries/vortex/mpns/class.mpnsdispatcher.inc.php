<?php

/**
 * This file contains functionality to dispatch Windows Phone Push Notifications.
 *
 * PHP Version 5.4
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Vortex\MPNS;

use Lunr\Libraries\Vortex\PushNotificationDispatcherInterface;
use Lunr\Libraries\Core\Curl;

/**
 * Windows Phone Push Notification Dispatcher.
 *
 * @category   Dispatcher
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MPNSDispatcher implements PushNotificationDispatcherInterface
{

    /**
     * Push Notification endpoint.
     * @var String
     */
    private $endpoint;

    /**
     * Push Notification payload to send.
     * @var String
     */
    private $payload;

    /**
     * Delivery priority for the push notification.
     * @var Integer
     */
    private $priority;

    /**
     * Push notification type.
     * @var String
     */
    private $type;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->endpoint = '';
        $this->payload  = '';
        $this->priority = 0;
        $this->type     = MPNSType::RAW;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->endpoint);
        unset($this->payload);
        unset($this->priority);
        unset($this->type);
    }

    /**
     * Push the notification.
     *
     * @return MPNSResponse $return Response object
     */
    public function push()
    {
        $curl = new Curl();

        $curl->set_option('HEADER', TRUE);
        $curl->set_http_headers([ 'Content-Type: text/xml', 'Accept: application/*' ]);

        if (($this->type === MPNSType::TILE) || ($this->type === MPNSType::TOAST))
        {
            $curl->set_http_header('X-WindowsPhone-Target: ' . $this->type);
        }

        if ($this->priority !== 0)
        {
            $curl->set_http_header('X-NotificationClass: ' . $this->priority);
        }

        $response = $curl->simple_post($this->endpoint, $this->payload);

        $this->endpoint = '';
        $this->payload  = '';
        $this->priority = 0;
        $this->type     = MPNSType::RAW;

        return new MPNSResponse($response, $curl);
    }

    /**
     * Set the endpoint for the push.
     *
     * @param String $endpoint The endpoint for the push
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_endpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the the payload to push.
     *
     * @param String &$payload The reference to the payload of the push
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

    /**
     * Set the priority for the push notification.
     *
     * @param Integer $priority Priority for the push notification.
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_priority($priority)
    {
        if (in_array($priority, [ 1, 2, 3, 11, 12, 13, 21, 22, 23 ]))
        {
            $this->priority = $priority;
        }

        return $this;
    }

    /**
     * Set the type for the push notification.
     *
     * @param String $type Type for the push notification.
     *
     * @return MPNSDispatcher $self Self reference
     */
    public function set_type($type)
    {
        if (in_array($type, [ MPNSType::TOAST, MPNSType::TILE, MPNSType::RAW ]))
        {
            $this->type = $type;
        }

        return $this;
    }

}

?>
