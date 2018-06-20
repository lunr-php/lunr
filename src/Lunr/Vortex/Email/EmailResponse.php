<?php

/**
 * This file contains an abstraction for the response from the Email service.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @author     Koen Woortman <k.woortman@m2mobi.com
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationStatus;
use Lunr\Vortex\PushNotificationResponseInterface;

/**
 * Email notification response wrapper.
 */
class EmailResponse implements PushNotificationResponseInterface
{

    /**
     * Push notification statuses per endpoint.
     * @var array
     */
    private $statuses;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param array                    $mail_results Contains endpoints with corresponding PHPMailer results.
     * @param \Psr\Log\LoggerInterface $logger       Shared instance of a Logger.
     */
    public function __construct($mail_results, $logger)
    {
        $this->logger   = $logger;
        $this->statuses = [];

        $this->handle_sent_notifications($mail_results);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->statuses);
        unset($this->logger);
    }

    /**
     * Get notification delivery status for an endpoint.
     *
     * @param string $endpoint Endpoint
     *
     * @return PushNotificationStatus $status Delivery status for the endpoint
     */
    public function get_status($endpoint)
    {
        if (!array_key_exists($endpoint, $this->statuses))
        {
            return PushNotificationStatus::UNKNOWN;
        }

        return $this->statuses[$endpoint];
    }

    /**
     * Store the results per endpoint in the statuses property
     *
     * @param array $mail_results Array containing is_error and a possible error message per endpoint
     *
     * @return void
     */
    private function handle_sent_notifications($mail_results)
    {
        foreach ($mail_results as $endpoint => $result_array)
        {
            if ($result_array['is_error'] === FALSE)
            {
                $this->statuses[$endpoint] = PushNotificationStatus::SUCCESS;
            }
            else
            {
                $this->statuses[$endpoint] = PushNotificationStatus::ERROR;

                $context = [ 'endpoint' => $endpoint, 'message' => $result_array['error_message'] ];

                $this->logger->warning('Sending email notification to {endpoint} failed: {message}', $context);
            }
        }
    }

}

?>
