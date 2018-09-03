<?php

/**
 * This file contains the FCMBatchResponse class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM;

use Lunr\Vortex\GCM\GCMBatchResponse;

/**
 * FCM response for a batch push notification.
 */
class FCMBatchResponse extends GCMBatchResponse
{

    /**
     * Constructor.
     *
     * @param \Requests_Response       $response  Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger    Shared instance of a Logger.
     * @param array                    $endpoints The endpoints the message was sent to (in the same order as sent).
     */
    public function __construct($response, $logger, $endpoints)
    {
        parent::__construct($response, $logger, $endpoints);
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
