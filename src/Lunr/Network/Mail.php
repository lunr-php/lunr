<?php

/**
 * This file contains a simple mail construction
 * and sending class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * Mail sender library
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Mail
{

    /**
     * Email address of the sender
     * @var String
     */
    private $from;

    /**
     * Email address(es) of the receiver
     * @var array
     */
    private $to;

    /**
     * Email addresses of the receiver (CC)
     * @var array
     */
    private $cc;

    /**
     * Email addresses of the receiver (BCC)
     * @var array
     */
    private $bcc;

    /**
     * Email message body
     * @var String
     */
    private $msg;

    /**
     * Email subject
     * @var String
     */
    private $subject;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->reset();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->from);
        unset($this->to);
        unset($this->cc);
        unset($this->bcc);
        unset($this->msg);
        unset($this->subject);
    }

    /**
     * Validate a given input String for a correct email format.
     *
     * @param String $email Email address to validate
     *
     * @return Boolean $return TRUE if it is an email, false otherwise
     */
    public function is_valid($email)
    {
        // filter_var accepts "username" as a valid email, since @domain.com
        // might be implied. So we check for a present domain by checking the
        // presence of the '@' character
        if((filter_var($email, FILTER_VALIDATE_EMAIL) === FALSE)
            || (strpos($email, '@') === FALSE))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Set sender email address.
     *
     * @param String $from Email address
     *
     * @return Mail $self Self reference
     */
    public function set_from($from)
    {
        if ($this->is_valid($from) === TRUE)
        {
            $this->from = $from;
        }

        return $this;
    }

    /**
     * Add an email address to the "TO:" header.
     *
     * @param String $to Email address
     *
     * @return Mail $self Self reference
     */
    public function add_to($to)
    {
        if ($this->is_valid($to) === TRUE)
        {
            $this->to[] = $to;
        }

        return $this;
    }

    /**
     * Add an email address to the "CC:" header.
     *
     * @param String $cc Email address
     *
     * @return Mail $self Self reference
     */
    public function add_cc($cc)
    {
        if ($this->is_valid($cc) === TRUE)
        {
            $this->cc[] = $cc;
        }

        return $this;
    }

    /**
     * Add an email address to the "BCC:" header.
     *
     * @param String $bcc Email address
     *
     * @return Mail $self Self reference
     */
    public function add_bcc($bcc)
    {
        if ($this->is_valid($bcc) === TRUE)
        {
            $this->bcc[] = $bcc;
        }

        return $this;
    }

    /**
     * Define the text that should be sent over email.
     *
     * @param String $msg The message
     *
     * @return Mail $self Self reference
     */
    public function set_message($msg)
    {
        $this->msg = $msg;
        return $this;
    }

    /**
     * Define the subject of the email.
     *
     * @param String $subject The subject
     *
     * @return Mail $self Self reference
     */
    public function set_subject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    /**
     * Send email.
     *
     * @return Boolean $return TRUE on success, FALSE if something went wrong
     */
    public function send()
    {
        $headers = $this->generate_headers();

        if (($headers === FALSE) || empty($this->to) || ($this->subject == ''))
        {
            return FALSE;
        }

        $ok = TRUE;
        foreach ($this->to AS $value)
        {
            $sent = mail($value, $this->subject, $this->msg, $headers);
            if ($sent !== TRUE)
            {
                $ok = FALSE;
            }
        }

        $this->reset();

        return $ok;
    }

    /**
     * Reset the values of the class without destroying it.
     *
     * @return void
     */
    protected function reset()
    {
        $this->from    = '';
        $this->to      = [];
        $this->cc      = [];
        $this->bcc     = [];
        $this->msg     = '';
        $this->subject = '';
    }

    /**
     * Generate Non-Default headers for sending the email.
     *
     * (FROM, CC, BCC, X-Mailer)
     *
     * @return mixed $header Headers on success, FALSE on failure
     */
    private function generate_headers()
    {
        if ($this->from == '')
        {
            return FALSE;
        }

        $header = 'From: ' . $this->from . "\r\n";

        $header .= $this->generate_carbon_copy_header();
        $header .= $this->generate_carbon_copy_header('bcc');

        $header .= 'X-Mailer: PHP/' . phpversion();
        return $header;
    }

    /**
     * Generate the (blind) carbon copy headers for a mail.
     *
     * @param String $type Type of carbon copy headers to generate, 'cc' or 'bcc'
     *
     * @return String $headers The generated header
     */
    private function generate_carbon_copy_header($type = 'cc')
    {
        $header = '';
        if ((($type == 'cc') || ($type == 'bcc')) && !empty($this->$type))
        {
            $header .= strtoupper($type) . ': ';
            $header .= implode(', ', $this->$type);
            $header .= "\r\n";
        }

        return $header;
    }

}

?>
