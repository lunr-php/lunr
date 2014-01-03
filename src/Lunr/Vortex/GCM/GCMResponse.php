<?php

/**
 * This file contains an abstraction for the response from the GCM server.
 *
 * PHP Version 5.4
 *
 * @category   Response
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM;

use Lunr\Vortex\PushNotificationStatus;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 *
 * @category   Response
 * @package    Vortex
 * @subpackage GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 */
class GCMResponse
{

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
     * The gcm response info.
     * @var String
     */
    private $result;

    /**
     * Constructor.
     *
     * @param CurlResponse    $response  Curl Response object.
     * @param LoggerInterface $logger    Shared instance of a Logger.
     * @param string          $device_id The deviceID that the message was sent to.
     */
    public function __construct($response, $logger, $device_id)
    {
        $this->http_code = $response->http_code;
        $this->result    = $response->get_result();

        if ($response->get_network_error_number() !== 0)
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'error' => $response->get_network_error_message(), 'endpoint' => $device_id ];
            $logger->error('Dispatching push notification to {endpoint} failed: {error}', $context);
        }
        else
        {
            $this->set_status($device_id, $logger);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->http_code);
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
        switch ($this->http_code)
        {
            case 200:
                $this->status = PushNotificationStatus::SUCCESS;
                break;
            case 400:
                $this->status = PushNotificationStatus::ERROR;
                break;
            case 401:
                $this->status = PushNotificationStatus::INVALID_ENDPOINT;
                break;
            case 503:
                $this->status = PushNotificationStatus::ERROR;
                break;
            default:
                $this->status = PushNotificationStatus::UNKNOWN;
                break;
        }

        if ($this->status !== PushNotificationStatus::SUCCESS)
        {
            $context = [
                'endpoint' => $endpoint,
                'code' => $this->status,
                'description' => $this->result
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= 'failed with an error: {description}. Error #{code}';

            $logger->warning($message, $context);
        }
        else
        {
            $failures = $this->parse_gcm_failures();

            if($failures['failure'] != 0)
            {
                $context = [
                    'failure' => $failures['failure'],
                    'errors' => json_encode($failures['messages'])
                ];

                $message  = '{failure} push notification(s) failed with the following ';
                $message .= 'error information {errors}.';

                $logger->warning($message, $context);
            }
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

    /**
     * Helper function for extracting the error info from the gcm response json.
     *
     * @return array An array with the amount of errors and their information.
     */
    private function parse_gcm_failures()
    {
        $results = json_decode($this->result, TRUE);

        $failures            = [];
        $failures['failure'] = $results['failure'];

        if($results['failure'] == 0)
        {
            return $failures;
        }

        foreach($results['results'] as $value)
        {
            if(isset($value['error']))
            {
                $failures['messages'][] = $value['error'];
            }
        }

        return $failures;
    }

}

?>
