<?php

/**
 * This file contains the web request parser class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use http\Header;
use Lunr\Core\Configuration;
use Psr\Log\LogLevel;

/**
 * Web Request Parser.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 */
class WebRequestParser implements RequestParserInterface
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
     * Whether the request was parsed already or not,
     * @var bool
     */
    protected $request_parsed;

    /**
     * Constructor.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     * @param Header        $header        Shared instance of the Header class
     */
    public function __construct($configuration, $header)
    {
        $this->config         = $configuration;
        $this->header         = $header;
        $this->request_parsed = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->config);
        unset($this->header);
        unset($this->request_parsed);
    }

    /**
     * Store request related information and remove it from super globals where necessary.
     *
     * @return array Parsed Request values
     */
    public function parse_request()
    {
        if ($this->request_parsed === TRUE)
        {
            return [];
        }

        $request = [];

        $request['sapi'] = PHP_SAPI;
        $request['host'] = gethostname();

        if (array_key_exists('REQUEST_METHOD', $_SERVER))
        {
            $request['action'] = $_SERVER['REQUEST_METHOD'];
        }
        else
        {
            $request['action'] = HttpMethod::GET;
        }

        $request['application_path'] = dirname($_SERVER['SCRIPT_FILENAME']) . '/';

        $request['base_path'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']))
        {
            $request['protocol'] = $_SERVER['HTTP_X_FORWARDED_PROTO'];
        }
        else
        {
            $request['protocol'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';
        }

        $request['domain'] = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'];
        $request['port']   = $_SERVER['SERVER_PORT'];

        $baseurl = $request['protocol'] . '://' . $request['domain'];

        if ((($request['protocol'] == 'http') && ($request['port'] != 80))
            || (($request['protocol'] == 'https') && ($request['port'] != 443))
        )
        {
            $baseurl .= ':' . $request['port'];
        }

        $request['base_url'] = $baseurl . $request['base_path'];

        $request['device_useragent'] = NULL;
        $request['useragent']        = NULL;

        $keys = [
            'HTTP_X_DEVICE_USER_AGENT',
            'HTTP_X_ORIGINAL_USER_AGENT',
            'HTTP_X_OPERAMINI_PHONE_UA',
            'HTTP_X_SKYFIRE_PHONE',
            'HTTP_X_BOLT_PHONE_UA',
            'HTTP_DEVICE_STOCK_UA',
            'HTTP_X_UCBROWSER_DEVICE_UA',
        ];

        foreach ($keys as $key)
        {
            if (array_key_exists($key, $_SERVER))
            {
                $request['device_useragent'] = $_SERVER[$key];
                break;
            }
        }

        if (array_key_exists('HTTP_USER_AGENT', $_SERVER))
        {
            $request['useragent'] = $_SERVER['HTTP_USER_AGENT'];
        }

        $request['bearer_token'] = NULL;

        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER))
        {
            $matches = [];
            if (preg_match('/^Bearer ([^ ]+)$/', $_SERVER['HTTP_AUTHORIZATION'], $matches) === 1)
            {
                $request['bearer_token'] = $matches[1] ?? NULL;
            }
        }

        // Preset with default values:
        $request['controller'] = $this->config['default_controller'];
        $request['method']     = $this->config['default_method'];
        $request['params']     = [];
        $request['call']       = NULL;
        $request['verbosity']  = LogLevel::WARNING;

        if (array_key_exists('REQUEST_ID', $_SERVER))
        {
            $request['id'] = $_SERVER['REQUEST_ID'];
        }
        else
        {
            $request['id'] = str_replace('-', '', uuid_create());
        }

        if (!is_array($_GET) || empty($_GET))
        {
            if (isset($request['controller'], $request['method']) === TRUE)
            {
                $request['call'] = $request['controller'] . '/' . $request['method'];
            }

            $this->request_parsed = TRUE;

            return $request;
        }

        foreach ($_GET as $key => $value)
        {
            if (substr($key, 0, 5) == 'param')
            {
                $request['params'][] = trim($value, '/');
                unset($_GET[$key]);
            }
            elseif (in_array($key, [ 'controller', 'method' ]))
            {
                $request[$key] = trim($value, '/');
                unset($_GET[$key]);
            }
        }

        if (isset($request['controller'], $request['method']) === TRUE)
        {
            $request['call'] = $request['controller'] . '/' . $request['method'];
        }

        $this->request_parsed = TRUE;

        return $request;
    }

    /**
     * Parse super global variables.
     *
     * @param array $_VAR  Reference to a super global variable
     * @param bool  $reset Whether to reset the super global variable
     *
     * @return array $var Parsed variable
     */
    protected function parse_super_global(&$_VAR, $reset = TRUE)
    {
        if (!is_array($_VAR) || empty($_VAR))
        {
            //reset super global
            $_VAR = $reset === TRUE ? [] : $_VAR;

            return $_VAR;
        }

        $var = [];

        foreach ($_VAR as $key => $value)
        {
            $var[$key] = $value;
        }

        //reset super global
        $_VAR = $reset === TRUE ? [] : $_VAR;

        return $var;
    }

    /**
     * Store request related information and remove it from super globals where necessary.
     *
     * @return array Parsed HTTP header values
     */
    public function parse_server()
    {
        return $this->parse_super_global($_SERVER, FALSE);
    }

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return array Parsed POST values
     */
    public function parse_post()
    {
        return $this->parse_super_global($_POST);
    }

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return array Parsed FILES values
     */
    public function parse_files()
    {
        return $this->parse_super_global($_FILES);
    }

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return array Parsed GET values
     */
    public function parse_get()
    {
        return $this->parse_super_global($_GET);
    }

    /**
     * Parse php://input value.
     *
     * @return string Parsed php://input value
     */
    public function parse_raw_data()
    {
        return file_get_contents('php://input');
    }

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return array Parsed Cookie values
     */
    public function parse_cookie()
    {
        $cookie = $this->parse_super_global($_COOKIE);

        if (isset($cookie['PHPSESSID']))
        {
            $_COOKIE['PHPSESSID'] = $cookie['PHPSESSID'];
            unset($cookie['PHPSESSID']);
        }

        return $cookie;
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
        if (isset($_SERVER['HTTP_ACCEPT']))
        {
            $this->header->name  = 'Accept';
            $this->header->value = $_SERVER['HTTP_ACCEPT'];
            return $this->header->negotiate($supported);
        }

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
        if (isset($_SERVER['HTTP_ACCEPT_LANGUAGE']))
        {
            $this->header->name  = 'Accept-Language';
            $this->header->value = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

            return $this->header->negotiate($supported);
        }

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
        if (isset($_SERVER['HTTP_ACCEPT_CHARSET']))
        {
            $this->header->name  = 'Accept-Charset';
            $this->header->value = $_SERVER['HTTP_ACCEPT_CHARSET'];

            return $this->header->negotiate($supported);
        }

        return NULL;
    }

}

?>
