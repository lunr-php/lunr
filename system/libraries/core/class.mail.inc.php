<?php

/**
 * This file contains a simple mail construction
 * and sending class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * Mail sender library
 *
 * @category   Libraries
 * @package    Core
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
        $this->from = '';
        $this->to = array();
        $this->cc = array();
        $this->bcc = array();
        $this->msg = '';
        $this->subject = '';
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
    public static function validate_email($email)
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
     * @return void
     */
    public function set_from($from)
    {
        $this->from = $from;
    }

    /**
     * Add an email address to the "TO:" header.
     *
     * @param String $to Email address
     *
     * @return void
     */
    public function add_to($to)
    {
        $this->to[] = $to;
    }

    /**
     * Add an email address to the "CC:" header.
     *
     * @param String $cc Email address
     *
     * @return void
     */
    public function add_cc($cc)
    {
        $this->cc[] = $cc;
    }

    /**
     * Add an email address to the "BCC:" header.
     *
     * @param String $bcc Email address
     *
     * @return void
     */
    public function add_bcc($bcc)
    {
        $this->bcc[] = $bcc;
    }

    /**
     * Define the text that should be sent over email.
     *
     * @param String $msg The message
     *
     * @return void
     */
    public function set_message($msg)
    {
        $this->msg = $msg;
    }

    /**
     * Define the subject of the email.
     *
     * @param String $subject The subject
     *
     * @return void
     */
    public function set_subject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * Send email.
     *
     * @return Boolean $return TRUE on success, FALSE if something went wrong
     */
    public function send()
    {
        $headers = $this->headers();
        if ($headers && !empty($this->to) && ($this->subject != ''))
        {
            $ok = TRUE;
            foreach ($this->to AS $value)
            {
                $sent = mail($value, $this->subject, $this->msg, $headers);
                if (!$sent)
                {
                    $ok = FALSE;
                }
            }
            return $ok;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Generate Non-Default headers for sending the email.
     *
     * (FROM, CC, BCC, X-Mailer)
     *
     * @return mixed $header Headers on success, FALSE on failure
     */
    private function headers()
    {
        if ($this->from != '')
        {
            $header  = 'From: ' . $this->from . "\r\n";

            if (!empty($this->cc))
            {
                $header .= 'CC: ';
                foreach ($this->cc as $key=>$value)
                {
                    $header .= $value;
                    if (isset($this->cc[$key + 1]))
                    {
                        $header .= ', ';
                    }
                    else
                    {
                        $header .= "\r\n";
                    }
                }
            }

            if (!empty($this->bcc))
            {
                $header .= 'BCC: ';
                foreach ($this->bcc as $key=>$value)
                {
                    $header .= $value;
                    if (isset($this->bcc[$key + 1]))
                    {
                        $header .= ', ';
                    }
                    else
                    {
                        $header .= "\r\n";
                    }
                }
            }

            $header .= 'X-Mailer: PHP/' . phpversion();
            return $header;
        }
        else
        {
            return FALSE;
        }
    }

}

?>
