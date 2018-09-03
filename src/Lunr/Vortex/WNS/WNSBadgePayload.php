<?php

/**
 * This file contains functionality to generate Windows Badge Push Notification payloads.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS;

/**
 * Windows Badge Push Notification Payload Generator.
 */
class WNSBadgePayload extends WNSPayload
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
        $xml = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        if (isset($this->elements['value']))
        {
            $xml .= '<badge value="' . $this->elements['value'] . '"/>';
        }

        return $xml;
    }

    /**
     * Set text for the Badge notification.
     *
     * @param string $value Value on the Badge
     *
     * @see https://msdn.microsoft.com/en-us/library/windows/apps/br212849.aspx
     *
     * @return WNSBadgePayload $self Self Reference
     */
    public function set_value($value)
    {
        $this->elements['value'] = $this->escape_string($value);

        return $this;
    }

}

?>
