<?php

/**
 * This file contains an abstraction for the response from the Email service.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2017, M2Mobi BV, Amsterdam, The Netherlands
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
     * @param \PHPMailer\PHPMailer\PHPMailer $mail_transport Instance of the mail transport class.
     * @param \Psr\Log\LoggerInterface       $logger         Shared instance of a Logger.
     * @param String                         $email          The email address that the message was sent to.
     */
    public function __construct($mail_transport, $logger, $email)
    {
        $this->endpoint = $email;

        if ($mail_transport->isError() === FALSE)
        {
            $this->status = PushNotificationStatus::SUCCESS;
        }
        else
        {
            $this->status = PushNotificationStatus::ERROR;

            $context = [ 'endpoint' => $email, 'message' => $mail_transport->ErrorInfo ];
            $logger->warning('Sending email notification to {endpoint} failed: {message}', $context);
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->status);
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
