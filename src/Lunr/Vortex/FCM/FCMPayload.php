<?php

/**
 * This file contains functionality to generate Google Cloud Messaging Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
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

}

?>
