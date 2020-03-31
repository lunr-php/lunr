<?php

/**
 * This file contains functionality to dispatch Email Notifications.
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationMultiDispatcherInterface;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * Email Notification Dispatcher.
 */
class EmailDispatcher implements PushNotificationMultiDispatcherInterface
{
    /**
     * Email Notification source.
     * @var string
     */
    private $source;

    /**
     * Shared instance of the mail transport class.
     * @var \PHPMailer\PHPMailer\PHPMailer
     */
    private $mail_transport;

    /**
     * Shared instance of a Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param \PHPMailer\PHPMailer\PHPMailer $mail_transport Shared instance of the mail transport class.
     * @param \Psr\Log\LoggerInterface       $logger         Shared instance of a Logger.
     */
    public function __construct($mail_transport, $logger)
    {
        $this->source = '';
        $this->logger = $logger;

        $this->mail_transport = $mail_transport;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->source);
        unset($this->mail_transport);
        unset($this->logger);
    }

    /**
     * Get a cloned instance of the mail transport class.
     *
     * @return \PHPMailer\PHPMailer\PHPMailer Cloned instance of the PHPMailer class
     */
    private function clone_mail()
    {
        return clone $this->mail_transport;
    }

    /**
     * Send the notification.
     *
     * @param EmailPayload $payload   Payload object
     * @param array        $endpoints Endpoints to send to in this batch
     *
     * @return EmailResponse Response object
     */
    public function push($payload, &$endpoints)
    {
        $payload_array = json_decode($payload->get_payload(), TRUE);

        // PHPMailer is not reentrant, so we have to clone it before we can do endpoint specific configuration.
        $mail_transport = $this->clone_mail();
        $mail_transport->setFrom($this->source);
        $mail_transport->Subject = $payload_array['subject'];
        $mail_transport->Body    = $payload_array['body'];

        $mail_results = [];

        foreach ($endpoints as $endpoint)
        {
            try
            {
                $mail_transport->addAddress($endpoint);

                $mail_transport->send();

                $mail_results[$endpoint] = [
                    'is_error'      => $mail_transport->isError(),
                    'error_message' => $mail_transport->ErrorInfo,
                ];
            }
            catch (PHPMailerException $e)
            {
                $mail_results[$endpoint] = [
                    'is_error'      => $mail_transport->isError(),
                    'error_message' => $mail_transport->ErrorInfo,
                ];
            }
            finally
            {
                $mail_transport->clearAddresses();
            }
        }

        $response = new EmailResponse($mail_results, $this->logger);

        return $response;
    }

    /**
     * Set the source for the email.
     *
     * @param string $source The endpoint for the email
     *
     * @return EmailDispatcher Self reference
     */
    public function set_source($source)
    {
        $this->source = $source;

        return $this;
    }

}

?>
