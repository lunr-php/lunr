<?php

/**
 * This file contains functionality to generate Windows Phone Push Notification payloads.
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
 * Windows Phone Push Notification Payload Generator.
 *
 * @category   Payload
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class MPNSPayload
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
