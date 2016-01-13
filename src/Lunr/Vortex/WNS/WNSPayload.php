<?php

/**
 * This file contains functionality to generate Windows Push Notification payloads.
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
 * Windows Push Notification Payload Generator.
 */
abstract class WNSPayload
{

    /**
     * Array of Push Notification elements.
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
     * Escape a string for use in the payload.
     *
     * @param String $string String to escape
     *
     * @return String $return Escaped string
     */
    protected function escape_string($string)
    {
        $search  = [ '&', '<', '>', '‘', '“' ];
        $replace = [ '&amp;', '&lt;', '&gt;', '&apos;', '&quot;' ];

        return str_replace($search, $replace, $string);
    }

    /**
     * Construct the payload for the push notification.
     *
     * @return String $return Payload
     */
    public abstract function get_payload();

}

?>
