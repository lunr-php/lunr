<?php

/**
 * This file contains functionality to generate Apple Push Notification Service payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS;

/**
 * Apple Push Notification Service Payload Generator.
 */
class APNSPayload
{

    /**
     * Array of Push Notification elements.
     * @var array
     */
    protected $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return string $return APNSPayload
     */
    public function get_payload()
    {
        return json_encode($this->elements);
    }

    /**
     * Sets the payload badge index.
     *
     * Used to determine what type of icon to show on the appicon when the message arrives
     *
     * @param integer $badge The badge index
     *
     * @return APNSPayload $self Self Reference
     */
    public function set_badge($badge)
    {
        $this->elements['badge'] = $badge;

        return $this;
    }

    /**
     * Sets the payload sound.
     *
     * @param string $sound The sound to set it to
     *
     * @return APNSPayload $self Self Reference
     */
    public function set_sound($sound)
    {
        $this->elements['sound'] = $sound;

        return $this;
    }

    /**
     * Sets the payload alert.
     *
     * The alert key represents the actual message to be sent
     * and it is named alert for sake of convention, as this is
     * the name of the key in the actual bytestream payload.
     *
     * @param string $alert The actual message
     *
     * @return APNSPayload $self Self Reference
     */
    public function set_alert($alert)
    {
        $this->elements['alert'] = $alert;

        return $this;
    }

    /**
     * Sets custom data in the payload.
     *
     * @param string $key   The key of the custom property
     * @param string $value The value of the custom property
     *
     * @return APNSPayload $self Self Reference
     */
    public function set_custom_data($key, $value)
    {
        if (!isset($this->elements['custom_data']))
        {
            $this->elements['custom_data'] = [];
        }

        $this->elements['custom_data'][$key] = $value;

        return $this;
    }

}

?>
