<?php

/**
 * This file contains the request parser interface.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Request Parser Interface.
 * Manages access to request related information in a uniform way.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface RequestParserInterface
{

    /**
     * Store request related information and remove it from super globals where necessary.
     *
     * @return Array Parsed Request values
     */
    public function parse_request();

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return Array Parsed POST values
     */
    public function parse_post();

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return Array Parsed FILES values
     */
    public function parse_files();

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return Array Parsed GET values
     */
    public function parse_get();

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return Array Parsed Cookie values
     */
    public function parse_cookie();

    /**
     * Parse command line variables into local variable.
     *
     * @return Array Parsed command line arguments
     */
    public function parse_command_line_arguments();

    /**
     * Negotiate & retrieve the client's prefered content type.
     *
     * @param Array $supported Array containing the supported content types
     *
     * @return Mixed $return The best match of the prefered content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function parse_accept_format($supported = []);

    /**
     * Negotiate & retrieve the clients prefered language.
     *
     * @param Array $supported Array containing the supported languages
     *
     * @return Mixed $return The best match of the prefered languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function parse_accept_language($supported = []);

    /**
     * Negotiate & retrieve the clients prefered charset.
     *
     * @param Array $supported Array containing the supported charsets
     *
     * @return Mixed $return The best match of the prefered charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function parse_accept_charset($supported = []);

}

?>
