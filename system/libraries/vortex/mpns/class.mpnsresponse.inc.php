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
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Vortex\MPNS;

use Lunr\Libraries\Vortex\PushNotificationStatus;
use Lunr\Libraries\Core\Output;

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
     * @param String $response Curl Response string.
     * @param Curl   $curl     Instance of the curl class.
     */
    public function __construct($response, $curl)
    {
        $this->http_code = $curl->info['http_code'];

        if ($curl->errno !== 0)
        {
            $this->status = PushNotificationStatus::ERROR;

            global $config;
            Output::error('Dispatching push notification to ' . $curl->info['url'] . ' failed: ' . $curl->errmsg, $config['mpns']['log']);
        }
        else
        {
            $this->parse_headers($response, $curl->info['header_size']);
            $this->set_status($curl->info['url']);
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
     * @param String $endpoint The notification endpoint that was used.
     *
     * @return void
     */
    private function set_status($endpoint)
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
            global $config;

            $message  = 'Push notification delivery status for endpoint ' . $endpoint . ': ';
            $message .= $this->headers['X-Notificationstatus'] . ', device ';
            $message .= $this->headers['X-Deviceconnectionstatus'] . ', subscription ';
            $message .= $this->headers['X-Subscriptionstatus'];

            Output::error($message, $config['mpns']['log']);
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
