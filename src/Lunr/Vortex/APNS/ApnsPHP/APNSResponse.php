<?php

/**
 * This file contains an abstraction for the response from the APNS server.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP;

use Lunr\Vortex\PushNotificationStatus;

/**
 * Apple Push Notification Service response wrapper.
 */
class APNSResponse
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Delivery status.
     * @var string
     */
    protected $status;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger           Shared instance of a Logger.
     * @param string          $endpoint         The endpoints the message was sent to
     * @param boolean         $invalid_endpoint List of invalid endpoints detected before the push.
     * @param Array           $errors           The errors response from the APNS Push.
     */
    public function __construct($logger, $endpoint, $invalid_endpoint, $errors)
    {
        $this->logger = $logger;
        $this->status = PushNotificationStatus::UNKNOWN;

        if ($invalid_endpoint === TRUE)
        {
            $this->status = PushNotificationStatus::INVALID_ENDPOINT;
        }
        elseif (!is_null($errors))
        {
            $this->set_status($endpoint, $errors);
        }
        else
        {
            $this->status = PushNotificationStatus::ERROR;
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->status);
    }

    /**
     * Define the status result for the endpoint.
     *
     * @param Array $endpoint The endpoint the message was sent to
     * @param Array $errors   The errors response from the APNS Push.
     *
     * @return void
     */
    protected function set_status($endpoint, $errors)
    {
        foreach ($errors as $error)
        {
            $message = $error['MESSAGE'];

            foreach ($error['ERRORS'] as $sub_error)
            {
                $id             = $sub_error['identifier'] - 1;
                $status_code    = $sub_error['statusCode'];
                $status_message = $sub_error['statusMessage'];

                switch ($status_code)
                {
                    case APNSStatus::ERROR_INVALID_TOKEN_SIZE:
                    case APNSStatus::ERROR_INVALID_TOKEN:
                        $status = PushNotificationStatus::INVALID_ENDPOINT;
                        break;
                    case APNSStatus::ERROR_PROCESSING:
                        $status = PushNotificationStatus::TEMPORARY_ERROR;
                        break;
                    default:
                        $status = PushNotificationStatus::UNKNOWN;
                        break;
                }

                $this->status = $status;

                $context = [ 'endpoint' => $endpoint, 'error' => $status_message ];
                $this->logger->warning('Dispatching push notification failed for endpoint {endpoint}: {error}', $context);

                return;
            }
        }

        $this->status = PushNotificationStatus::SUCCESS;
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @return PushNotificationStatus $status Delivery status for the endpoint
     */
    public function get_status()
    {
        return $this->status;
    }

}

?>
