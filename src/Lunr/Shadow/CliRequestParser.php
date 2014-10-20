<?php

/**
 * This file contains the cli request parser class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

use Lunr\Corona\RequestParserInterface;

/**
 * Cli Request Parser.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class CliRequestParser implements RequestParserInterface
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
     * "Abstract Syntax Tree" of the passed arguments on the command line
     * @var array
     */
    protected $ast;

    /**
     * Constructor.
     *
     * @param \Lunr\Core\Configuration        $configuration Shared instance of the Configuration class
     * @param \Lunr\Shadow\CliParserInterface $parser        The CliParser of this request
     * @param \http\Header                    $header        Shared instance of the Header class
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
     * @return Array Parsed Request values
     */
    public function parse_request()
    {
        $request = [];

        $request['sapi'] = PHP_SAPI;
        $request['host'] = gethostname();

        $request['base_path'] = $this->config['default_webpath'];
        $request['protocol']  = $this->config['default_protocol'];
        $request['domain']    = $this->config['default_domain'];
        $request['port']      = $this->config['default_port'];
        $request['base_url']  = $this->config['default_url'];

        // Preset with default values:
        $request['controller'] = $this->config['default_controller'];
        $request['method']     = $this->config['default_method'];
        $request['params']     = [];

        $request['device_useragent'] = NULL;
        $request['useragent']        = NULL;

        if (array_key_exists('device_useragent', $this->ast))
        {
            $request['device_useragent'] = $this->ast['device_useragent'][0];
        }

        if (array_key_exists('useragent', $this->ast))
        {
            $request['useragent'] = $this->ast['useragent'][0];
        }

        foreach([ 'controller', 'method', 'c', 'm' ] as $key)
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

        foreach (['params', 'param', 'p'] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $request['params'] = array_map(function ($val){ return trim($val, '/'); }, $this->ast[$key]);
                unset($this->ast[$key]);
            }
        }

        return $request;
    }

    /**
     * Parse super global variables.
     *
     * @param String $index String index of the super global
     *
     * @return Array $var Parsed variable
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
     * @return Array Parsed POST values
     */
    public function parse_post()
    {
        return $this->parse_super_global('post');
    }

    /**
     * Parse $_FILES values into local variable and reset it globally.
     *
     * @return Array Parsed FILES values
     */
    public function parse_files()
    {
        return [];
    }

    /**
     * Parse $_GET values into local variable and reset it globally.
     *
     * @return Array Parsed GET values
     */
    public function parse_get()
    {
        return $this->parse_super_global('get');
    }

    /**
     * Parse $_COOKIE values into local variable and reset it globally.
     *
     * @return Array Parsed Cookie values
     */
    public function parse_cookie()
    {
        $cookie = $this->parse_super_global('cookie');

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
        $this->header->value = $this->ast['accept-format'][0];

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
        $this->header->value = $this->ast['accept-language'][0];

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
        $this->header->value = $this->ast['accept-charset'][0];

        return $this->header->negotiate($supported);
    }

}

?>
