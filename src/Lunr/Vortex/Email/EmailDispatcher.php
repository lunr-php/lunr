<?php

/**
 * This file contains functionality to dispatch Email Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationDispatcherInterface;
use PHPMailer\PHPMailer\Exception as PHPMailerException;

/**
 * Email Notification Dispatcher.
 */
class EmailDispatcher implements PushNotificationDispatcherInterface
{
    /**
     * Email Notification source.
     * @var String
     */
    private $source;

    /**
     * Email Notification endpoint.
     * @var String
     */
    private $endpoint;

    /**
     * Email Notification payload to send.
     * @var String
     */
    private $payload;

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
        $this->source   = '';
        $this->endpoint = '';
        $this->payload  = '';
        $this->logger   = $logger;

        $this->mail_transport = $mail_transport;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->source);
        unset($this->endpoint);
        unset($this->payload);
        unset($this->mail_transport);
        unset($this->logger);
    }

    /**
     * Get a cloned instance of the mail transport class.
     *
     * @return \PHPMailer\PHPMailer\PHPMailer $mail_transport Cloned instance of the PHPMailer class
     */
    private function clone_mail()
    {
        return clone $this->mail_transport;
    }

    /**
     * Send the notification.
     *
     * @return EmailResponse $return Response object
     */
    public function push()
    {
        // PHPMailer is not reentrant, so we have to clone it before we can do endpoint specific configuration.
        $mail_transport = $this->clone_mail();

        try
        {
            $mail_transport->setFrom($this->source);
            $mail_transport->addAddress($this->endpoint);

            $payload_array = json_decode($this->payload, TRUE);

            $mail_transport->Subject = $payload_array['subject'];
            $mail_transport->Body    = $payload_array['body'];

            $mail_transport->send();

            $res = new EmailResponse($mail_transport, $this->logger, $this->endpoint);
        }
        catch (PHPMailerException $e)
        {
            $res = new EmailResponse($mail_transport, $this->logger, $this->endpoint);
        }

        $this->endpoint = '';
        $this->payload  = '';

        return $res;
    }

    /**
     * Set the source for the email.
     *
     * @param string $source The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set the endpoints for the email.
     *
     * @param array|string $endpoints The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_endpoints($endpoints)
    {
        if (is_array($endpoints))
        {
            $this->endpoint = empty($endpoints) ? '' : $endpoints[0];
        }
        else
        {
            $this->endpoint = $endpoints;
        }

        return $this;
    }

    /**
     * Set the the payload to email.
     *
     * @param string $payload The reference to the payload of the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_payload(&$payload)
    {
        $this->payload =& $payload;

        return $this;
    }

}

?>
