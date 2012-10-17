<?php

/**
 * This file contains an abstract definition for a JSON helper class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * Abstract definition for a Json wrapper
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface JsonInterface
{

    /**
     * Decode a JSON string into an array.
     *
     * @param String $json The JSON string
     *
     * @return array Decoded Array
     */
    public static function decode($json);

    /**
     * Return a json encoded error.
     *
     * @param String $error Error to output
     * @param mixed  $info  Additional information about the error
    *                       (optional)
     *
     * @return String $return json encoded error
     */
    public static function error($error, $info = '');

    /**
     * Return a json encoded internal server error.
     *
     * This also leaves a note about it in the error log.
     *
     * @param String $info Error information
     *
     * @return String $return json encoded error
     */
    public static function server_error($info);

    /**
     * Return a json encoded invalid input error.
     *
     * This also leaves a note about it in the error log.
     *
     * @param String $info Error information
     *
     * @return String $return json encoded error
     */
    public static function invalid_input($info);

    /**
     * Return a json encoded (partial) result (not everything worked fine).
     *
     * @param mixed $info Additional information about the error (optional)
     * @param array $data The return data
     *
     * @return String $return json encoded return value
     */
    public static function partial_result($info, $data);

    /**
     * Return a json encoded (full) result (everything worked fine).
     *
     * @param array $data The return data
     *
     * @return String $return json encoded return value
     */
    public static function result($data);

}

?>
