<?php

/**
 * This file contains an abstraction for the response from the PAP server.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Google Cloud Messaging Push Notification response wrapper.
 */
class PAPResponse implements PushNotificationResponseInterface
{

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
     * The HTTP response.
     * @var string
     */
    private $result;

    /**
     * The PAP response info.
     * @var array
     */
    private $pap_response;

    /**
     * Push notification endpoint.
     * @var string
     */
    private $endpoint;

    /**
     * Raw payload that was sent to PAP.
     * @var string
     */
    protected $payload;

    /**
     * Constructor.
     *
     * @param \Requests_Response       $response  Requests_Response object.
     * @param \Psr\Log\LoggerInterface $logger    Shared instance of a Logger.
     * @param string                   $device_id The deviceID that the message was sent to.
     * @param string                   $payload   Raw payload that was sent to PAP.
     */
    public function __construct($response, $logger, $device_id, $payload)
    {
        $this->http_code    = $response->status_code;
        $this->result       = $response->body;
        $this->endpoint     = $device_id;
        $this->pap_response = [];
        $this->payload      = $payload;

        if ($this->http_code === FALSE)
        {
            $this->status = PushNotificationStatus::ERROR;
        }
        elseif ($this->parse_pap_response() === FALSE)
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'error' => $this->pap_response['message'], 'endpoint' => $device_id ];
            $logger->warning('Parsing response of push notification to {endpoint} failed: {error}', $context);
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
        unset($this->pap_response);
        unset($this->payload);
    }

    /**
     * Helper function for extracting the error info from the PAP response XML.
     *
     * @return mixed FALSE in case the xml response is unparsable,
     *               void otherwise
     */
    private function parse_pap_response()
    {
        // Start parsing response into XML data that we can read and output
        $p = xml_parser_create();

        xml_parse_into_struct($p, $this->result, $values);

        $xml_errorcode = xml_get_error_code($p);
        if ($xml_errorcode > 0)
        {
            $this->pap_response['code']    = $xml_errorcode;
            $this->pap_response['message'] = xml_error_string($xml_errorcode);
        }

        xml_parser_free($p);

        if (empty($this->pap_response))
        {
            // no errors in parsing the XML response

            if ($values[1]['tag'] == 'PUSH-RESPONSE')
            {
                // a XML response with the above tag in it is by default
                // a successful response, so the code in it will either be
                // 1000 or 1001 and we don't have to check that in set_status
                $this->pap_response['code'] = 0;
            }
            else
            {
                $this->pap_response['code']    = intval($values[1]['attributes']['CODE']);
                $this->pap_response['message'] = $values[1]['attributes']['DESC'];
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Set notification status information.
     *
     * @param string          $endpoint The notification endpoint that was used.
     * @param LoggerInterface $logger   Shared instance of a Logger.
     *
     * @return void
     */
    private function set_status($endpoint, $logger)
    {
        switch ($this->http_code)
        {
            case 200:
                if ($this->pap_response['code'] == 0)
                {
                    $this->status = PushNotificationStatus::SUCCESS;
                }
                else
                {
                    if ($this->pap_response['code'] == 2002)
                    {
                        $this->status = PushNotificationStatus::INVALID_ENDPOINT;
                    }
                    elseif ($this->pap_response['code'] < 4000)
                    {
                        $this->status = PushNotificationStatus::ERROR;
                    }
                    elseif ($this->pap_response['code'] <= 4502)
                    {
                        $this->status = PushNotificationStatus::TEMPORARY_ERROR;
                    }
                    else
                    {
                        $this->status = PushNotificationStatus::UNKNOWN;
                    }
                }

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
            $error_description = (isset($this->pap_response['message'])) ? $this->pap_response['message'] : $this->result;

            $context = [
                'endpoint'    => $endpoint,
                'code'        => $this->status,
                'description' => $error_description,
            ];

            $message  = 'Push notification delivery status for endpoint {endpoint}: ';
            $message .= 'failed with an error: {description}. Error #{code}';

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
