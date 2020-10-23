<?php

/**
 * This file contains functionality to generate JPush Message payloads.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush;

/**
 * JPush Message Payload Generator.
 */
class JPushMessagePayload extends JPushPayload
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
     * @return array JPushPayload
     */
    public function get_payload()
    {
        $elements = $this->elements;

        unset($elements['notification']);

        return $elements;
    }

}

?>
