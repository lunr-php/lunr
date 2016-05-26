<?php

/**
 * This file contains an abstraction for the response from the APNS server.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Vortex\APNS\ApnsPHP
 * @author     Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\ApnsPHP;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Apple Push Notification Service response wrapper.
 */
class APNSResponse implements PushNotificationResponseInterface
{

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * The statuses per endpoint.
     * @var Array
     */
    protected $statuses;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger            Shared instance of a Logger.
     * @param Array           $endpoints         The endpoints the message was sent to
     * @param Array           $invalid_endpoints List of invalid endpoints detected before the push.
     * @param Array           $errors            The errors response from the APNS Push.
     */
    public function __construct($logger, $endpoints, $invalid_endpoints, $errors)
    {
        $this->logger   = $logger;
        $this->statuses = [];

        $this->report_invalid_endpoints($invalid_endpoints);

        if (!is_null($errors))
        {
            $this->set_statuses($endpoints, $errors);
        }
        else
        {
            $this->report_error($endpoints);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);
        unset($this->statuses);
    }

    /**
     * Define the status result for each endpoint.
     *
     * @param Array $endpoints The endpoints the message was sent to
     * @param Array $errors    The errors response from the APNS Push.
     *
     * @return void
     */
    protected function set_statuses($endpoints, $errors)
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

                $endpoint = $message->getRecipients()[$id];

                $this->statuses[$endpoint] = $status;

                $context = [ 'endpoint' => $endpoint, 'error' => $status_message ];
                $this->logger->warning('Dispatching push notification failed for endpoint {endpoint}: {error}', $context);
            }
        }

        foreach ($endpoints as $endpoint)
        {
            if (!isset($this->statuses[$endpoint]))
            {
                $this->statuses[$endpoint] = PushNotificationStatus::SUCCESS;
            }
        }
    }

    /**
     * Report invalid endpoints.
     *
     * @param Array $invalid_endpoints The invalid endpoints
     *
     * @return void
     */
    protected function report_invalid_endpoints(&$invalid_endpoints)
    {
        foreach ($invalid_endpoints as $invalid_endpoint)
        {
            $this->statuses[$invalid_endpoint] = PushNotificationStatus::INVALID_ENDPOINT;
        }
    }

    /**
     * Report an error with the push notification.
     *
     * @param Array $endpoints The endpoints the message was sent to
     *
     * @return void
     */
    protected function report_error(&$endpoints)
    {
        foreach ($endpoints as $endpoint)
        {
            if (!isset($this->statuses[$endpoint]))
            {
                $this->statuses[$endpoint] = PushNotificationStatus::ERROR;
            }
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
        return isset($this->statuses[$endpoint]) ? $this->statuses[$endpoint] : PushNotificationStatus::UNKNOWN;
    }

}

?>
