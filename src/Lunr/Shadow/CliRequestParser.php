<?php

/**
 * This file contains the cli request parser class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow;

use http\Header;
use Lunr\Core\Configuration;
use Lunr\Corona\HttpMethod;
use Lunr\Corona\RequestParserInterface;
use Psr\Log\LogLevel;

/**
 * Cli Request Parser.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 */
class CliRequestParser implements RequestParserInterface
{

    /**
     * Shared instance of the Configuration class.
     * @var Configuration
     */
    protected $config;

    /**
     * Shared instance of the Header class.
     * @var Header
     */
    protected $header;

    /**
     * "Abstract Syntax Tree" of the passed arguments on the command line
     * @var array
     */
    protected $ast;

    /**
     * Constructor.
     *
     * @param Configuration      $configuration Shared instance of the Configuration class
     * @param CliParserInterface $parser        The CliParser of this request
     * @param Header             $header        Shared instance of the Header class
     */
    public function __construct($configuration, $parser, $header)
    {
        $this->config = $configuration;
        $this->header = $header;
        $this->ast    = $parser->parse();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->config);
        unset($this->header);
        unset($this->ast);
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

        $request['application_path'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/';

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

        $request['device_useragent'] = NULL;
        $request['useragent']        = NULL;
        $request['bearer_token']     = NULL;

        foreach ([ 'action', 'x' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $request['action'] = $this->ast[$key][0];
            }
        }

        foreach ([ 'device_useragent', 'device-useragent' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $request['device_useragent'] = $this->ast[$key][0];
            }
        }

        if (array_key_exists('useragent', $this->ast))
        {
            $request['useragent'] = $this->ast['useragent'][0];
        }

        if (array_key_exists('bearer-token', $this->ast))
        {
            $request['bearer_token'] = $this->ast['bearer-token'][0];
        }

        foreach ([ 'controller', 'method', 'c', 'm' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $index = ($key === 'controller') || ($key === 'c') ? 'controller' : 'method';

                $request[$index] = trim($this->ast[$key][0], '/');
                unset($this->ast[$key]);
            }
        }

        if (isset($request['controller'], $request['method']) === TRUE)
        {
            $request['call'] = $request['controller'] . '/' . $request['method'];
        }
        else
        {
            $request['call'] = NULL;
        }

        foreach ([ 'params', 'param', 'p' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $request['params'] = array_map(function ($val) { return trim($val, '/'); }, $this->ast[$key]);
                unset($this->ast[$key]);
            }
        }

        $request['verbosity'] = LogLevel::WARNING;

        foreach ([ 'verbose', 'v' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $count = count($this->ast[$key]);

                if ($count <= 1)
                {
                    $request['verbosity'] = LogLevel::NOTICE;
                }
                elseif ($count == 2)
                {
                    $request['verbosity'] = LogLevel::INFO;
                }
                else
                {
                    $request['verbosity'] = LogLevel::DEBUG;
                }

                unset($this->ast[$key]);
            }
        }

        $request['id'] = str_replace('-', '', uuid_create());

        return $request;
    }

    /**
     * Parse super global variables.
     *
     * @param string $index String index of the super global
     *
     * @return array $var Parsed variable
     */
    protected function parse_super_global($index)
    {
        $var = [];

        if (array_key_exists($index, $this->ast))
        {
            parse_str($this->ast[$index][0], $var);
            unset($this->ast[$index]);
        }

        return $var;
    }

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return array Parsed POST values
     */
    public function parse_post()
    {
        return $this->parse_super_global('post');
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
     * Parse $_SERVER values into local variable.
     *
     * @return array Parsed SERVER values
     */
    public function parse_server()
    {
        $server = [];

        foreach ($_SERVER as $key => $value)
        {
            $server[$key] = $value;
        }

        return $server;
    }

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return array Parsed GET values
     */
    public function parse_get()
    {
        return $this->parse_super_global('get');
    }

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return array Parsed Cookie values
     */
    public function parse_cookie()
    {
        $cookie = $this->parse_super_global('cookie');

        if (isset($cookie['PHPSESSID']))
        {
            $_COOKIE['PHPSESSID'] = $cookie['PHPSESSID'];
            unset($cookie['PHPSESSID']);
        }

        return $cookie;
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
        $ast = $this->ast;

        unset($ast['controller'], $ast['c']);
        unset($ast['method'], $ast['m']);
        unset($ast['params'], $ast['param'], $ast['p']);
        unset($ast['post'], $ast['get'], $ast['files'], $ast['cookie']);
        unset($ast['accept-format']);
        unset($ast['accept-language']);
        unset($ast['accept-charset']);

        return $ast;
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
        $this->header->name  = 'Accept';
        $this->header->value = array_key_exists('accept-format', $this->ast) ? $this->ast['accept-format'][0] : NULL;

        return $this->header->negotiate($supported);
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
        $this->header->name  = 'Accept-Language';
        $this->header->value = array_key_exists('accept-language', $this->ast) ? $this->ast['accept-language'][0] : NULL;

        return $this->header->negotiate($supported);
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
        $this->header->name  = 'Accept-Charset';
        $this->header->value = array_key_exists('accept-charset', $this->ast) ? $this->ast['accept-charset'][0] : NULL;

        return $this->header->negotiate($supported);
    }

}

?>
