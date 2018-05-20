<?php

/**
 * This file contains functionality to generate Google Cloud Messaging Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

/**
 * Google Cloud Messaging Push Notification Payload Generator.
 */
class GCMPayload
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
     * @return string $return GCMPayload
     */
    public function get_payload()
    {
        return json_encode($this->elements);
    }

    /**
     * Sets the payload key collapse_key.
     *
     * An arbitrary string that is used to collapse a group of alike messages
     * when the device is offline, so that only the last message gets sent to the client.
     *
     * @param string $key The notification collapse key identifier
     *
     * @return GCMPayload $self Self Reference
     */
    public function set_collapse_key($key)
    {
        $this->elements['collapse_key'] = $key;

        return $this;
    }

    /**
     * Sets the payload key data.
     *
     * The fields of data represent the key-value pairs of the message's payload data.
     *
     * @param array $data The actual notification information
     *
     * @return GCMPayload $self Self Reference
     */
    public function set_data($data)
    {
        $this->elements['data'] = $data;

        return $this;
    }

    /**
     * Sets the payload key time_to_live.
     *
     * It defines how long (in seconds) the message should be kept on GCM storage,
     * if the device is offline.
     *
     * @param integer $ttl The time in seconds for the notification to stay alive
     *
     * @return GCMPayload $self Self Reference
     */
    public function set_time_to_live($ttl)
    {
        $this->elements['time_to_live'] = $ttl;

        return $this;
    }

}

?>
