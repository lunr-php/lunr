<?php

/**
 * This file contains a network error trait.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Network;

/**
 * Network Error Trait.
 *
 * @category   Libraries
 * @package    Network
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
trait NetworkErrorTrait
{

    /**
     * Network error number
     * @var Integer
     */
    protected $error_number;

    /**
     * Network error message
     * @var String
     */
    protected $error_message;

    /**
     * Return the last error message.
     *
     * @return String $error Error message
     */
    public function get_network_error_message()
    {
        return $this->error_message;
    }

    /**
     * Return the last error number.
     *
     * @return String $errno Error number
     */
    public function get_network_error_number()
    {
        return $this->error_number;
    }

}

?>
