<?php

/**
 * This file contains functionality to generate Windows Toast Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS;

/**
 * Windows Toast Push Notification Payload Generator.
 */
class WNSToastPayload extends WNSPayload
{

    /**
     * Shared instance of a Logger.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Constructor.
     *
     * @param LoggerInterface $logger Shared instance of a logger
     */
    public function __construct($logger)
    {
        parent::__construct();

        $this->logger = $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->logger);

        parent::__destruct();
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return String $return Payload
     */
    public function get_payload()
    {
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if (isset($this->elements['deeplink']))
        {
            $xml .= '<toast launch="' . $this->elements['deeplink'] . "\">\n";
        }
        else
        {
            $xml .= "<toast>\n";
        }

        $xml .= "<visual>\n";
        $xml .= "<binding template=\"ToastGeneric\">\n";

        if (isset($this->elements['title']))
        {
            $xml .= '<text id="1">' . $this->elements['title'] . "</text>\n";
        }

        if (isset($this->elements['message']))
        {
            $xml .= '<text id="2">' . $this->elements['message'] . "</text>\n";
        }

        $xml .= "</binding>\n";
        $xml .= "</visual>\n";
        $xml .= "</toast>\n";

        return $xml;
    }

    /**
     * Set title for the toast notification.
     *
     * @param String $title Title
     *
     * @return WNSToastPayload $self Self Reference
     */
    public function set_title($title)
    {
        $this->elements['title'] = $this->escape_string($title);

        return $this;
    }

    /**
     * Set message for the toast notification.
     *
     * @param String $message Message
     *
     * @return WNSToastPayload $self Self Reference
     */
    public function set_message($message)
    {
        $this->elements['message'] = $this->escape_string($message);

        return $this;
    }

    /**
     * Set deeplink for the toast notification.
     *
     * @param String $deeplink Deeplink
     *
     * @return WNSToastPayload $self Self Reference
     */
    public function set_deeplink($deeplink)
    {
        $deeplink = $this->escape_string($deeplink);

        if (strlen($deeplink) > 256)
        {
            $deeplink = substr($deeplink, 0, 256);
            $this->logger->notice('Deeplink for Windows Toast Notification too long. Truncated.');
        }

        $this->elements['deeplink'] = $deeplink;

        return $this;
    }

}

?>
