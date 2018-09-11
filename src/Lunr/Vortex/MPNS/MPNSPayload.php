<?php

/**
 * This file contains functionality to generate Windows Phone Push Notification payloads.
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS;

use ReflectionClass;

/**
 * Windows Phone Push Notification Payload Generator.
 */
abstract class MPNSPayload
{

    /**
     * Array of Push Notification elements.
     * @var array
     */
    protected $elements;

    /**
     * Priority of the payload.
     * @var Integer
     */
    protected $priority = MPNSPriority::DEFAULT;

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
        unset($this->priority);
    }

    /**
     * Escape a string for use in the payload.
     *
     * @param string $string String to escape
     *
     * @return string $return Escaped string
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
     * @return string $return Payload
     */
    public abstract function get_payload();

    /**
     * Mark the notification priority.
     *
     * @param Integer $priority Notification priority value.
     *
     * @return MPNSPayload $self Self Reference
     */
    public function set_priority($priority)
    {
        $mpns = new ReflectionClass('\Lunr\Vortex\MPNS\MPNSPriority');
        if (in_array($priority, $mpns->getConstants()))
        {
            $this->priority = $priority;
        }

        return $this;
    }

    /**
     * Get the notification priority.
     *
     * @return mixed $return Notification priority.
     */
    public function get_priority()
    {
        return $this->priority;
    }

}

?>
