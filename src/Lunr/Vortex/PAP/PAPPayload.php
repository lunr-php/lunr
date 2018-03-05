<?php

/**
 * This file contains functionality to generate PAP Format Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP;

/**
 * PAP Format Push Notification Payload Generator.
 */
class PAPPayload
{

    /**
     * Array of Push Notification message elements.
     * @var array
     */
    protected $data;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->data = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->data);
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return String $return The PAP Payload
     */
    public function get_payload()
    {
        return json_encode($this->data);
    }

    /**
     * Sets the message that the payload is carrying.
     *
     * The each message item is represented by a key-value pair in the payload.
     *
     * @param String $key   The key of the message item
     * @param String $value The actual message item
     *
     * @return PAPPayload $self Self Reference
     */
    public function set_message_data($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

}

?>
