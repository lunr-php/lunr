<?php

/**
 * This file contains the web request parser class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Web Request Parser.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class WebRequestParser implements RequestParserInterface
{

    /**
     * Shared instance of the Configuration class.
     * @var \Lunr\Core\Configuration
     */
    protected $config;

    /**
     * Shared instance of the Header class.
     * @var \http\Header
     */
    protected $header;

    /**
     * Whether the request was parsed already or not,
     * @var Boolean
     */
    protected $request_parsed;

    /**
     * Constructor.
     *
     * @param \Lunr\Core\Configuration $configuration Shared instance of the Configuration class
     * @param \http\Header             $header        Shared instance of the Header class
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
     * @return Array Parsed Request values
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

        $request['base_path'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

        $request['protocol'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

        $request['domain'] = $_SERVER['SERVER_NAME'];
        $request['port']   = $_SERVER['SERVER_PORT'];

        $baseurl = $request['protocol'] . '://' . $request['domain'];

        if ((($request['protocol'] == 'http') && ($request['port'] != 80))
            || (($request['protocol'] == 'https') && ($request['port'] != 443)))
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
            'HTTP_X_UCBROWSER_DEVICE_UA'
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

        // Preset with default values:
        $request['controller'] = $this->config['default_controller'];
        $request['method']     = $this->config['default_method'];
        $request['params']     = [];
        $request['call']       = NULL;

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
     * @param Array &$_VAR Reference to a super global variable
     *
     * @return Array $var Parsed variable
     */
    protected function parse_super_global(&$_VAR)
    {
        if (!is_array($_VAR) || empty($_VAR))
        {
            //reset super global
            $_VAR = [];

            return $_VAR;
        }

        $var = [];

        foreach ($_VAR as $key => $value)
        {
            $var[$key] = $value;
        }

        //reset super global
        $_VAR = [];

        return $var;
    }

    /**
     * Parse $_POST values into local variable and reset it globally.
     *
     * @return Array Parsed POST values
     */
    public function parse_post()
    {
        return $this->parse_super_global($_POST);
    }

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return Array Parsed FILES values
     */
    public function parse_files()
    {
        return $this->parse_super_global($_FILES);
    }

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return Array Parsed GET values
     */
    public function parse_get()
    {
        return $this->parse_super_global($_GET);
    }

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return Array Parsed Cookie values
     */
    public function parse_cookie()
    {
        $cookie = $this->parse_super_global($_COOKIE);

        if(isset($cookie['PHPSESSID']))
        {
            $_COOKIE['PHPSESSID'] = $cookie['PHPSESSID'];
            unset($cookie['PHPSESSID']);
        }

        return $cookie;
    }

    /**
     * Parse command line variables into local variable.
     *
     * @return Array Parsed command line arguments
     */
    public function parse_command_line_arguments()
    {
        return [];
    }

    /**
     * Negotiate & retrieve the client's prefered content type.
     *
     * @param Array $supported Array containing the supported content types
     *
     * @return Mixed $return The best match of the prefered content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function parse_accept_format($supported = [])
    {
        $this->header->name  = "Accept";
        $this->header->value = $_SERVER['HTTP_ACCEPT'];

        return $this->header->negotiate($supported);
    }

    /**
     * Negotiate & retrieve the clients prefered language.
     *
     * @param Array $supported Array containing the supported languages
     *
     * @return Mixed $return The best match of the prefered languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function parse_accept_language($supported = [])
    {
        $this->header->name  = "Accept-Language";
        $this->header->value = $_SERVER['HTTP_ACCEPT_LANGUAGE'];

        return $this->header->negotiate($supported);
    }

    /**
     * Negotiate & retrieve the clients prefered charset.
     *
     * @param Array $supported Array containing the supported charsets
     *
     * @return Mixed $return The best match of the prefered charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function parse_accept_charset($supported = [])
    {
        $this->header->name  = "Accept-Charset";
        $this->header->value = $_SERVER['HTTP_ACCEPT_CHARSET'];

        return $this->header->negotiate($supported);
    }

}

?>
