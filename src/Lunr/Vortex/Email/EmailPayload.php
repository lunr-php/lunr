<?php

/**
 * This file contains functionality to generate Email Notification payloads.
 *
 * @package    Lunr\Vortex\Email
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\Email;

/**
 * Email Notification Payload Generator.
 */
class EmailPayload
{

    /**
     * Array of Email Notification message elements.
     * @var array
     */
    protected $elements;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->elements = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->elements);
    }

    /**
     * Construct the payload for the email notification.
     *
     * @return string $return The Email Payload
     */
    public function get_payload()
    {
        return json_encode($this->elements);
    }

    /**
     * Sets the email body of the payload.
     *
     * @param string $body The body of the email
     *
     * @return EmailPayload $self Self Reference
     */
    public function set_body($body)
    {
        $this->elements['body'] = $body;

        return $this;
    }

    /**
     * Sets the email body of the payload.
     *
     * @param string $subject The subject of the email
     *
     * @return EmailPayload $self Self Reference
     */
    public function set_subject($subject)
    {
        $this->elements['subject'] = $subject;

        return $this;
    }

}

?>
