<?php

/**
 * This file contains the request parser class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use Lunr\Core\Configuration;
use Psr\Log\LogLevel;

/**
 * Request Parser.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 */
class RequestParser implements RequestParserInterface
{

    /**
     * Shared instance of the Configuration class.
     * @var Configuration
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     */
    public function __construct($configuration)
    {
        $this->config = $configuration;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->config);
    }

    /**
     * Store request related information and remove it from super globals where necessary.
     *
     * @return array Parsed Request values
     */
    public function parse_request()
    {
        $request = [];

        $request['sapi'] = PHP_SAPI;
        $request['host'] = gethostname();

        $request['application_path'] = $this->config['default_application_path'];

        $request['base_path'] = $this->config['default_webpath'];
        $request['protocol']  = $this->config['default_protocol'];
        $request['domain']    = $this->config['default_domain'];
        $request['port']      = $this->config['default_port'];
        $request['base_url']  = $this->config['default_url'];
        $request['action']    = HttpMethod::GET;

        // Preset with default values:
        $request['controller'] = $this->config['default_controller'];
        $request['method']     = $this->config['default_method'];
        $request['params']     = [];

        if (isset($request['controller'], $request['method']) === TRUE)
        {
            $request['call'] = $request['controller'] . '/' . $request['method'];
        }
        else
        {
            $request['call'] = NULL;
        }

        $request['device_useragent'] = NULL;
        $request['useragent']        = NULL;
        $request['verbosity']        = LogLevel::WARNING;

        $request['id'] = str_replace('-', '', uuid_create());

        return $request;
    }

    /**
     * Parse $_POST values into local variable.
     *
     * @return array Parsed HTTP header values
     */
    public function parse_server()
    {
        return [];
    }

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return array Parsed POST values
     */
    public function parse_post()
    {
        return [];
    }

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return array Parsed FILES values
     */
    public function parse_files()
    {
        return [];
    }

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return array Parsed GET values
     */
    public function parse_get()
    {
        return [];
    }

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return array Parsed Cookie values
     */
    public function parse_cookie()
    {
        return [];
    }

    /**
     * Parse php://stdin value.
     *
     * @return string Parsed php://stdin value
     */
    public function parse_raw_data()
    {
        return file_get_contents('php://stdin');
    }

    /**
     * Parse command line variables into local variable.
     *
     * @return array Parsed command line arguments
     */
    public function parse_command_line_arguments()
    {
        return [];
    }

    /**
     * Negotiate & retrieve the client's preferred content type.
     *
     * @param array $supported Array containing the supported content types
     *
     * @return mixed $return The best match of the preferred content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function parse_accept_format($supported = [])
    {
        return NULL;
    }

    /**
     * Negotiate & retrieve the clients preferred language.
     *
     * @param array $supported Array containing the supported languages
     *
     * @return mixed $return The best match of the preferred languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function parse_accept_language($supported = [])
    {
        return NULL;
    }

    /**
     * Negotiate & retrieve the clients preferred charset.
     *
     * @param array $supported Array containing the supported charsets
     *
     * @return mixed $return The best match of the preferred charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function parse_accept_charset($supported = [])
    {
        return NULL;
    }

}

?>
