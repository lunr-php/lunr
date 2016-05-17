<?php

/**
 * This file contains an abstraction for the response from the WNS server.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS;

use Lunr\Vortex\PushNotificationStatus;

/**
 * Windows Push Notification response wrapper.
 */
class WNSResponse
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
     * Push notification endpoint.
     * @var String
     */
    private $endpoint;

    /**
     * Constructor.
     *
     * @param \Lunr\Network\CurlResponse $response Curl Response object.
     * @param \Psr\Log\LoggerInterface   $logger   Shared instance of a Logger.
     * @param \http\Header               $header   Instance of a Header class.
     */
    public function __construct($response, $logger, $header)
    {
        $this->http_code = $response->http_code;
        $this->endpoint  = $response->url;

        if ($response->get_network_error_number() !== 0)
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'error' => $response->get_network_error_message(), 'endpoint' => $response->url ];
            $logger->warning('Dispatching push notification to {endpoint} failed: {error}', $context);
        }
        else
        {
            $this->parse_headers($header, $response->get_result(), $response->header_size);
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
     * @param \http\Header $header      Instance of a Header class.
     * @param String       $result      Response result
     * @param Integer      $header_size Size of the header
     *
     * @return void
     */
    private function parse_headers($header, $result, $header_size)
    {
        $this->headers = $header->parse(substr($result, 0, $header_size));
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
                if ($this->headers['X-WNS-Status'] === 'received')
                {
                    $this->status = PushNotificationStatus::SUCCESS;
                }
                elseif ($this->headers['X-WNS-Status'] === 'channelthrottled')
                {
                    $this->status = PushNotificationStatus::TEMPORARY_ERROR;
                }
                else
                {
                    $this->status = PushNotificationStatus::CLIENT_ERROR;
                }

                break;
            case 404:
            case 410:
                $this->status = PushNotificationStatus::INVALID_ENDPOINT;
                break;
            case 400:
            case 401:
            case 403:
            case 405:
            case 413:
                $this->status = PushNotificationStatus::ERROR;
                break;
            case 406:
            case 500:
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
                'endpoint'          => $endpoint,
                'nstatus'           => $this->headers['X-WNS-Status'],
                'dstatus'           => $this->headers['X-WNS-DeviceConnectionStatus'],
                'error_description' => $this->headers['X-WNS-Error-Description'],
                'error_trace'       => $this->headers['X-WNS-Debug-Trace'],
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= '{nstatus}, device {dstatus}, description {error_description}, trace {error_trace}';

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
