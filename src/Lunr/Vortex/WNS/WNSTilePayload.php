<?php

/**
 * This file contains functionality to generate Windows Tile Push Notification payloads.
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
 * Windows Tile Push Notification Payload Generator.
 */
class WNSTilePayload extends WNSPayload
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return String $return Payload
     */
    public function get_payload()
    {
        $xml  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $xml .= "<tile>\n";
        $xml .= "<visual>\n";
        $xml .= "<binding template=\"TileSquareText04\">\n";

        if (isset($this->elements['text']) === TRUE)
        {
            $xml .= '<text id="1">' . $this->elements['text'] . "</text>\n";
        }

        $xml .= "</binding>\n";
        $xml .= "<binding template=\"TileWideText03\">\n";

        if (isset($this->elements['text']) === TRUE)
        {
            $xml .= '<text id="1">' . $this->elements['text'] . "</text>\n";
        }

        $xml .= "</binding>\n";
        $xml .= "</visual>\n";
        $xml .= "</tile>\n";

        return $xml;
    }

    /**
     * Set text for the tile notification.
     *
     * @param String $text Text on the tile
     *
     * @return WNSTilePayload $self Self Reference
     */
    public function set_text($text)
    {
        $this->elements['text'] = $this->escape_string($text);

        return $this;
    }

}

?>
