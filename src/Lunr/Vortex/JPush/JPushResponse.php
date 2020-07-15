<?php

/**
 * This file contains an abstraction for the response from the JPush server.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 */
class JPushResponse implements PushNotificationResponseInterface
{

    /**
     * The statuses per endpoint.
     * @var array
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
     * @param JPushBatchResponse $batch_response Batch response
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
     * @return PushNotificationStatus Delivery status for the endpoint
     */
    public function get_status($endpoint)
    {
        return isset($this->statuses[$endpoint]) ? $this->statuses[$endpoint] : PushNotificationStatus::UNKNOWN;
    }

}

?>
