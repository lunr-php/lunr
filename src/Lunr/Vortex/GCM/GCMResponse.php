<?php

/**
 * This file contains an abstraction for the response from the GCM server.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 */
class GCMResponse implements PushNotificationResponseInterface
{

    /**
     * The statuses per endpoint.
     * @var Array
     */
    protected $statuses;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->statuses = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->statuses);
    }

    /**
     * Add the results of a batch response.
     *
     * @param GCMBatchResponse $batch_response Batch response
     * @param array            $endpoints      Endpoints of the batch
     *
     * @return void
     */
    public function add_batch_response($batch_response, $endpoints)
    {
        foreach ($endpoints as $endpoint)
        {
            $this->statuses[$endpoint] = $batch_response->get_status($endpoint);
        }
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus $status Delivery status for the endpoint
     */
    public function get_status($endpoint)
    {
        return isset($this->statuses[$endpoint]) ? $this->statuses[$endpoint] : PushNotificationStatus::UNKNOWN;
    }

}

?>
