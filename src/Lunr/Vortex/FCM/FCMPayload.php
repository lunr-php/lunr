<?php

/**
 * This file contains functionality to generate Firebase Cloud Messaging Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\GCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMPayload;

/**
 * Google Cloud Messaging Push Notification Payload Generator.
 */
class FCMPayload extends GCMPayload
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Sets the payload key data.
     *
     * The fields of data represent the key-value pairs of the message's payload data.
     *
     * @param array $data The actual notification information
     *
     * @return FCMPayload $self Self Reference
     */
    public function set_data($data)
    {
        $this->elements['notification'] = $data;

        return $this;
    }

}

?>
