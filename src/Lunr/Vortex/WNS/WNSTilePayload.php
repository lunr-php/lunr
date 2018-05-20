<?php

/**
 * This file contains functionality to generate Windows Tile Push Notification payloads.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
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
     * @return string $return Payload
     */
    public function get_payload()
    {
        $inner_xml = '';
        foreach ($this->elements['image'] as $key => $value)
        {
            $inner_xml .= '            <image id="' . ($key + 1) . '" src="' . $value . "\"/>\r\n";
        }

        foreach ($this->elements['text'] as $key => $value)
        {
            $inner_xml .= '            <text id="' . ($key + 1) . '">' . $value . "</text>\r\n";
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";

        foreach ($this->elements['template'] as $key => $template)
        {
            $xml .= '<tile>' . "\r\n";
            $xml .= '    <visual version="2">' . "\r\n";
            $xml .= '        <binding template="' . $template . '">' . "\r\n";
            $xml .= $inner_xml;
            $xml .= '        </binding>' . "\r\n";
            $xml .= '    </visual>' . "\r\n";
            $xml .= '</tile>';
            $xml .= ($key < (count($this->elements['template']) - 1)) ? "\r\n\r\n" : "\r\n";
        }

        return $xml;
    }

    /**
     * Set text for the tile notification.
     *
     * @param String[]|string $text Text on the tile
     *
     * @param integer         $line The line on which to add the text
     *
     * @return WNSTilePayload $self Self Reference
     */
    public function set_text($text, $line = 0)
    {
        if (!is_array($text))
        {
            $this->elements['text'][$line] = $this->escape_string($text);
            return $this;
        }

        foreach ($text as $key => $value)
        {
            $this->elements['text'][$key] = $this->escape_string($value);
        }

        return $this;
    }

    /**
     * Set image for the tile notification.
     *
     * @param String[]|string $image Image on the tile
     *
     * @param integer         $line  The line on which to add the text
     *
     * @return WNSTilePayload $self Self Reference
     */
    public function set_image($image, $line = 0)
    {
        if (!is_array($image))
        {
            $this->elements['image'][$line] = $this->escape_string($image);
            return $this;
        }

        foreach ($image as $key => $value)
        {
            $this->elements['image'][$key] = $this->escape_string($value);
        }

        return $this;
    }

    /**
     * Set template for the tile notification.
     *
     * @param String[]|string $templates Template(s) for notification
     *
     *
     * @see https://msdn.microsoft.com/en-us/library/windows/apps/windows.ui.notifications.tiletemplatetype
     *
     * @return WNSTilePayload $self Self Reference
     */
    public function set_templates($templates)
    {
        if (!is_array($templates))
        {
            $templates = [ $templates ];
        }

        foreach ($templates as $key => $template)
        {
            $this->elements['templates'][$key] = $this->escape_string($template);
        }

        return $this;
    }

}

?>
