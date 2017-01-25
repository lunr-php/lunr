<?php

/**
 * This file contains the request abstraction class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Request abstraction class.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 */
class Request
{

    /**
     * Stored $_POST values
     * @var array
     */
    protected $post;

    /**
     * Stored $_GET values
     * @var array
     */
    protected $get;

    /**
     * Stored $_COOKIE values
     * @var array
     */
    protected $cookie;

    /**
     * Stored $_SERVER values
     * @var array
     */
    protected $server;

    /**
     * Request parameters:
     *  'protocol'   The protocol used for the request
     *  'domain'     The domain used for the request
     *  'port'       The port used for the request
     *  'base_path'  The path on the server to the application
     *  'base_url'   All of the above combined
     *
     *  'device_useragent' The device specific user agent sent with the request
     *  'useragent'        The user agent sent with the request
     *
     *  'sapi'       The PHP SAPI invoking the code
     *  'host'       The hostname of the server the script is running on
     *
     *  'controller' The controller requested
     *  'method'     The method requested of that controller
     *  'params'     The parameters for that method
     *  'call'       The call identifier, combining controller and method
     *
     * @var array
     */
    protected $request;

    /**
     * Stored $_FILES values
     * @var array
     */
    protected $files;

    /**
     * Stored php://input values
     * @var string
     */
    protected $raw_data;

    /**
     * Stored command line arguments
     * @var array
     */
    protected $cli_args;

    /**
     * Shared instance of the request parser.
     * @var RequestParserInterface
     */
    protected $parser;

    /**
     * The request values to mock.
     * @var array
     */
    private $mock;

    /**
     * Constructor.
     *
     * @param RequestParserInterface $parser Shared instance of a Request Parser class
     */
    public function __construct($parser)
    {
        $this->parser = $parser;

        $this->request  = $parser->parse_request();
        $this->server   = $parser->parse_server();
        $this->post     = $parser->parse_post();
        $this->get      = $parser->parse_get();
        $this->cookie   = $parser->parse_cookie();
        $this->files    = $parser->parse_files();
        $this->cli_args = $parser->parse_command_line_arguments();
        $this->raw_data = NULL;

        $this->mock = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->post);
        unset($this->get);
        unset($this->server);
        unset($this->cookie);
        unset($this->request);
        unset($this->files);
        unset($this->parser);
        unset($this->mock);
        unset($this->raw_data);
    }

    /**
     * Get access to certain private attributes.
     *
     * This gives access to the request keys.
     *
     * @param String $name Attribute name
     *
     * @return mixed $return Value of the chosen attribute
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->request))
        {
            if (array_key_exists($name, $this->mock))
            {
                return $this->mock[$name];
            }
            else
            {
                return $this->request[$name];
            }
        }
        else
        {
            return NULL;
        }
    }

    /**
     * Override request values detected from the request parser.
     *
     * @param Array $values Array of key value pairs holding mocked request values
     *
     * @return void
     */
    public function set_mock_values($values)
    {
        if (!is_array($values))
        {
            return;
        }

        $this->mock = $values;
    }

    /**
     * Returns a CLI option array of value(s).
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_option_data($key)
    {
        if(array_key_exists($key, $this->cli_args))
        {
            return $this->cli_args[$key];
        }

        return NULL;
    }

    /**
     * Returns all CLI options.
     *
     * @return array $return The option and the arguments of the request
     */
    public function get_all_options()
    {
        return array_keys($this->cli_args);
    }

    /**
     * Negotiate & retrieve the client's prefered content type.
     *
     * @param Array $supported Array containing the supported content types
     *
     * @return Mixed $return The best match of the prefered content types or NULL
     *                       if there are no supported types or the header is not set
     */
    public function get_accept_format($supported = [])
    {
        return $this->parser->parse_accept_format($supported);
    }

    /**
     * Negotiate & retrieve the clients prefered language.
     *
     * @param Array $supported Array containing the supported languages
     *
     * @return Mixed $return The best match of the prefered languages or NULL if
     *                       there are no supported languages or the header is not set
     */
    public function get_accept_language($supported = [])
    {
        return $this->parser->parse_accept_language($supported);
    }

    /**
     * Negotiate & retrieve the clients prefered charset.
     *
     * @param Array $supported Array containing the supported charsets
     *
     * @return Mixed $return The best match of the prefered charsets or NULL if
     *                       there are no supported charsets or the header is not set
     */
    public function get_accept_charset($supported = [])
    {
        return $this->parser->parse_accept_charset($supported);
    }

    /**
     * Retrieve a stored GET value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_get_data($key)
    {
        if (array_key_exists('get', $this->mock)
            && array_key_exists($key, $this->mock['get'])
        )
        {
            return $this->mock['get'][$key];
        }

        return isset($this->get[$key]) ? $this->get[$key] : NULL;
    }

    /**
     * Retrieve a stored POST value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_post_data($key)
    {
        if (array_key_exists('post', $this->mock)
            && array_key_exists($key, $this->mock['post'])
        )
        {
            return $this->mock['post'][$key];
        }

        return isset($this->post[$key]) ? $this->post[$key] : NULL;
    }

    /**
     * Retrieve a stored SERVER value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_server_data($key)
    {
        return isset($this->server[$key]) ? $this->server[$key] : NULL;
    }

    /**
     * Retrieve a stored HTTP Header from the SERVER value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_http_header_data($key)
    {
        $http_key = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        return isset($this->server[$http_key]) ? $this->server[$http_key] : NULL;
    }

    /**
     * Retrieve a stored COOKIE value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_cookie_data($key)
    {
        return isset($this->cookie[$key]) ? $this->cookie[$key] : NULL;
    }

    /**
     * Retrieve a stored FILE value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_files_data($key)
    {
        return isset($this->files[$key]) ? $this->files[$key] : NULL;
    }

    /**
     * Retrieve raw request data.
     *
     * @return String $return The raw request data as string
     */
    public function get_raw_data()
    {
        $input = $this->parser->parse_raw_data();
        if (!empty($input))
        {
            $this->raw_data = $input;
        }

        return $this->raw_data;
    }

}

?>
