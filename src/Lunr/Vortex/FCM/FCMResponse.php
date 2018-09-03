<?php

/**
 * This file contains an abstraction for the response from the FCM server.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMResponse;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 */
class FCMResponse extends GCMResponse
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

}

?>
