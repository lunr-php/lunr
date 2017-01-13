<?php

/**
 * This file contains an abstraction for the response from the APNS server.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\libcapn;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Apple Push Notification Service response wrapper.
 */
class APNSResponse implements PushNotificationResponseInterface
{

    /**
     * APNS stream response code.
     * @var Integer
     */
    private $response_code;

    /**
     * Delivery status.
     * @var Integer
     */
    private $status;

    /**
     * The APNS response info.
     * @var String
     */
    private $result;

    /**
     * Push notification endpoint.
     * @var String
     */
    private $endpoint;

    /**
     * Constructor.
     *
     * @param array           $response  The response from the APNS stream.
     * @param LoggerInterface $logger    Shared instance of a Logger.
     * @param string          $device_id The deviceID that the message was sent to.
     */
    public function __construct($response, $logger, $device_id)
    {
        $this->response_code = $response['error_code'];
        $this->result        = $response['error_message'];
        $this->endpoint      = $device_id;

        $this->set_status($device_id, $logger);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->response_code);
        unset($this->status);
        unset($this->result);
    }

    /**
     * Set notification status information.
     *
     * @param String          $endpoint The notification endpoint that was used.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     *
     * @return void
     */
    private function set_status($endpoint, $logger)
    {
        switch ($this->response_code)
        {
            case APNSStatus::APN_SUCCESS:
                $this->status = PushNotificationStatus::SUCCESS;
                break;
            case APNSStatus::APN_ERR_TOKEN_IS_NOT_SET:
            case APNSStatus::APN_ERR_TOKEN_INVALID:
                $this->status = PushNotificationStatus::INVALID_ENDPOINT;
                break;
            case APNSStatus::APN_ERR_PROCESSING_ERROR:
                $this->status = PushNotificationStatus::TEMPORARY_ERROR;
                break;
            case APNSStatus::APN_ERR_UNKNOWN:
                $this->status = PushNotificationStatus::UNKNOWN;
                break;
            default:
                $this->status = PushNotificationStatus::ERROR;
                break;
        }

        if ($this->status !== PushNotificationStatus::SUCCESS)
        {
            $context = [
                'endpoint'    => $endpoint,
                'code'        => $this->status,
                'description' => $this->result,
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= 'failed with an error: {description}. Error #{code}';

            $logger->warning($message, $context);
        }
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param String $endpoint endpoint
     *
     * @return PushNotificationStatus $status Delivery status for the endpoint
     */
    public function get_status($endpoint)
    {
        if ($endpoint != $this->endpoint)
        {
            return PushNotificationStatus::UNKNOWN;
        }

        return $this->status;
    }

}

?>
