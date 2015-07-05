<?php

/**
 * This file contains functionality to dispatch Email Notifications.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

use Lunr\Vortex\PushNotificationDispatcherInterface;

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
     * Shared instance of the Mail class.
     * @var Mail
     */
    private $mail;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param Mail            $mail   Shared instance of the Mail class.
     * @param LoggerInterface $logger Shared instance of a Logger.
     */
    public function __construct($mail, $logger)
    {
        $this->source   = '';
        $this->endpoint = '';
        $this->payload  = '';
        $this->mail     = $mail;
        $this->logger   = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->source);
        unset($this->endpoint);
        unset($this->payload);
        unset($this->mail);
        unset($this->logger);
    }

    /**
     * Send the notification.
     *
     * @return EmailResponse $return Response object
     */
    public function push()
    {
        $this->mail->set_from($this->source);
        $this->mail->add_to($this->endpoint);

        $payload_array = json_decode($this->payload, TRUE);

        $this->mail->set_subject($payload_array['subject']);
        $this->mail->set_message($payload_array['body']);

        $response = $this->mail->send();

        $res = new EmailResponse($response, $this->logger, $this->endpoint);

        $this->endpoint = '';
        $this->payload  = '';

        return $res;
    }

    /**
     * Set the source for the email.
     *
     * @param String $source The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_source($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Set the endpoint for the email.
     *
     * @param String $endpoint The endpoint for the email
     *
     * @return EmailDispatcher $self Self reference
     */
    public function set_endpoint($endpoint)
    {
        $this->endpoint = $endpoint;

        return $this;
    }

    /**
     * Set the the payload to email.
     *
     * @param String &$payload The reference to the payload of the email
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
