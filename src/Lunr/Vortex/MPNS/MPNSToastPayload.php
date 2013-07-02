<?php

/**
 * This file contains functionality to generate Windows Phone Toast Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @category   Payload
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

/**
 * Windows Phone Toast Push Notification Payload Generator.
 *
 * @category   Payload
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MPNSToastPayload extends MPNSPayload
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
        $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n"
                . "<wp:Notification xmlns:wp=\"WPNotification\">\n"
                . "<wp:Toast>\n";

        if (isset($this->elements['title']))
        {
            $xml .= "<wp:Text1>" . $this->elements['title'] . "</wp:Text1>\n";
        }

        if (isset($this->elements['message']))
        {
            $xml .= "<wp:Text2>" . $this->elements['message'] . "</wp:Text2>\n";
        }

        if (isset($this->elements['deeplink']))
        {
            $xml .= "<wp:Param>" . $this->elements['deeplink'] . "</wp:Param>\n";
        }

        $xml .= "</wp:Toast>\n</wp:Notification>\n";

        return $xml;
    }

    /**
     * Set title for the toast notification.
     *
     * @param String $title Title
     *
     * @return MPNSToastPayload $self Self Reference
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
     * @return MPNSToastPayload $self Self Reference
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
     * @return MPNSToastPayload $self Self Reference
     */
    public function set_deeplink($deeplink)
    {
        $deeplink = $this->escape_string($deeplink);

        if (strlen($deeplink) > 256)
        {
            $deeplink = substr($deeplink, 0, 256);
            $this->logger->notice('Deeplink for Windows Phone Toast Notification too long. Truncated.');
        }

        $this->elements['deeplink'] = $deeplink;

        return $this;
    }

}

?>
