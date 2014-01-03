<?php

/**
 * This file contains an abstraction for the response from the MPNS server.
 *
 * PHP Version 5.4
 *
 * @category   Response
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

use Lunr\Vortex\PushNotificationStatus;

/**
 * Windows Phone Push Notification response wrapper.
 *
 * @category   Response
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MPNSResponse
{

    /**
     * HTTP headers of the response.
     * @var array
     */
    private $headers;

    /**
     * HTTP status code.
     * @var Integer
     */
    private $http_code;

    /**
     * Delivery status.
     * @var Integer
     */
    private $status;

    /**
     * Constructor.
     *
     * @param CurlResponse    $response Curl Response object.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     */
    public function __construct($response, $logger)
    {
        $this->http_code = $response->http_code;

        if ($response->get_network_error_number() !== 0)
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'error' => $response->get_network_error_message(), 'endpoint' => $response->url ];
            $logger->error('Dispatching push notification to {endpoint} failed: {error}', $context);
        }
        else
        {
            $this->parse_headers($response->get_result(), $response->header_size);
            $this->set_status($response->url, $logger);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->headers);
        unset($this->http_code);
        unset($this->status);
    }

    /**
     * Parse response header information.
     *
     * @param String  $result      Response result
     * @param Integer $header_size Size of the header
     *
     * @return void
     */
    private function parse_headers($result, $header_size)
    {
        $this->headers = http_parse_headers(substr($result, 0, $header_size));

        if (in_array($this->http_code, [ 400, 401, 405, 503 ]))
        {
            $this->headers['X-Notificationstatus']     = 'N/A';
            $this->headers['X-Deviceconnectionstatus'] = 'N/A';
            $this->headers['X-Subscriptionstatus']     = 'N/A';
        }
        elseif ($this->http_code === 412)
        {
            $this->headers['X-Subscriptionstatus'] = 'N/A';
        }

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
        switch ($this->http_code)
        {
            case 200:
                if ($this->headers['X-Notificationstatus'] === 'Received')
                {
                    $this->status = PushNotificationStatus::SUCCESS;
                }
                elseif ($this->headers['X-Notificationstatus'] === 'QueueFull')
                {
                    $this->status = PushNotificationStatus::TEMPORARY_ERROR;
                }
                else
                {
                    $this->status = PushNotificationStatus::CLIENT_ERROR;
                }

                break;
            case 404:
                $this->status = PushNotificationStatus::INVALID_ENDPOINT;
                break;
            case 400:
            case 401:
            case 405:
                $this->status = PushNotificationStatus::ERROR;
                break;
            case 406:
            case 412:
            case 503:
                $this->status = PushNotificationStatus::TEMPORARY_ERROR;
                break;
            default:
                $this->status = PushNotificationStatus::UNKNOWN;
                break;
        }

        if ($this->status !== PushNotificationStatus::SUCCESS)
        {
            $context = [
                'endpoint' => $endpoint,
                'nstatus' => $this->headers['X-Notificationstatus'],
                'dstatus' => $this->headers['X-Deviceconnectionstatus'],
                'sstatus' => $this->headers['X-Subscriptionstatus']
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= '{nstatus}, device {dstatus}, subscription {sstatus}';

            $logger->warning($message, $context);
        }
    }

    /**
     * Get notification delivery status.
     *
     * @return PushNotificationStatus $status Delivery status
     */
    public function get_status()
    {
        return $this->status;
    }

}

?>
