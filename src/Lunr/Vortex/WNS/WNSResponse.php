<?php

/**
 * This file contains an abstraction for the response from the WNS server.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
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
     * @var integer
     */
    private $http_code;

    /**
     * Delivery status.
     * @var integer
     */
    private $status;

    /**
     * Push notification endpoint.
     * @var string
     */
    private $endpoint;

    /**
     * Raw payload that was sent to WNS.
     * @var string
     */
    protected $payload;

    /**
     * Constructor.
     *
     * @param \Requests_Response       $response Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger   Shared instance of a Logger.
     * @param string                   $payload  Raw payload that was sent to WNS.
     */
    public function __construct($response, $logger, $payload)
    {
        $this->http_code = $response->status_code;
        $this->endpoint  = $response->url;
        $this->payload   = $payload;

        if ($this->http_code === FALSE)
        {
            $this->status = PushNotificationStatus::ERROR;
        }
        else
        {
            $this->headers = $response->headers;
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
        unset($this->payload);
    }

    /**
     * Set notification status information.
     *
     * @param string                   $endpoint The notification endpoint that was used.
     * @param \Psr\Log\LoggerInterface $logger   Shared instance of a Logger.
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
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus Delivery status for the endpoint
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
