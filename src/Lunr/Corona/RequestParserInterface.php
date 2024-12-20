<?php

/**
 * This file contains the request parser interface.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

/**
 * Request Parser Interface.
 * Manages access to request related information in a uniform way.
 */
interface RequestParserInterface
{

    /**
     * Store request related information and remove it from super globals where necessary.
     *
     * @return array Parsed Request values
     */
    public function parse_request();

    /**
     * Store $_SERVER header values into local variables and reset it globally.
     *
     * @return mixed
     */
    public function parse_server();

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return array Parsed POST values
     */
    public function parse_post();

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return array Parsed FILES values
     */
    public function parse_files();

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return array Parsed GET values
     */
    public function parse_get();

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return array Parsed Cookie values
     */
    public function parse_cookie();

    /**
     * Parse php://input values into local variable.
     *
     * @return string|false Parsed php://input values
     */
    public function parse_raw_data();

    /**
     * Parse command line variables into local variable.
     *
     * @return array Parsed command line arguments
     */
    public function parse_command_line_arguments();

    /**
     * Negotiate & retrieve the client's preferred content type.
     *
     * @param array $supported Array containing the supported content types
     *
     * @return mixed $return The best match of the preferred content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function parse_accept_format($supported = []);

    /**
     * Negotiate & retrieve the clients preferred language.
     *
     * @param array $supported Array containing the supported languages
     *
     * @return mixed $return The best match of the preferred languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function parse_accept_language($supported = []);

    /**
     * Negotiate & retrieve the clients preferred charset.
     *
     * @param array $supported Array containing the supported charsets
     *
     * @return mixed $return The best match of the preferred charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function parse_accept_charset($supported = []);

}

?>
