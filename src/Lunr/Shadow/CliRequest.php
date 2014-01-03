<?php

/**
 * This file contains the CliRequest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

use Lunr\Corona\InterRequest;
use Lunr\Corona\RequestInterface;

/**
 * The CliRequest class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class CliRequest implements RequestInterface
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
     * "Abstract Syntax Tree" of the passed arguments
     * @var array
     */
    protected $ast;

    /**
     * Stored $_FILES values
     * @var array
     */
    protected $files;

     /**
     * Request parameters:
     *  'protocol'   The protocol used for the request
     *  'domain'     The domain used for the request
     *  'port'       The port used for the request
     *  'base_path'  The path on the server to the application
     *  'base_url'   All of the above combined
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
     * Constructor.
     *
     * @param Configuration      $configuration Shared instance of the Configuration class
     * @param CliParserInterface $parser        The CliParser of this request
     */
    public function __construct($configuration, $parser)
    {
        $this->ast     = $parser->parse();
        $this->post    = [];
        $this->get     = [];
        $this->cookie  = [];
        $this->request = [];
        $this->json    = [];
        $this->files   = [];

        $this->request['sapi'] = PHP_SAPI;
        $this->request['host'] = gethostname();

        $this->store_default($configuration);
        $this->store_request();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->ast);
        unset($this->post);
        unset($this->get);
        unset($this->cookie);
        unset($this->request);
        unset($this->json);
        unset($this->files);
    }

    /**
     * Store default controller, method, params and url values.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     *
     * @return void
     */
    protected function store_default($configuration)
    {
        $this->request['controller'] = $configuration['default_controller'];
        $this->request['method']     = $configuration['default_method'];
        $this->request['params']     = [];

        $this->request['base_path'] = $configuration['default_webpath'];
        $this->request['protocol']  = $configuration['default_protocol'];
        $this->request['domain']    = $configuration['default_domain'];
        $this->request['port']      = $configuration['default_port'];
        $this->request['base_url']  = $configuration['default_url'];

        if (isset($this->request['controller'], $this->request['method']) === TRUE)
        {
            $this->request['call'] = $this->request['controller'] . '/' . $this->request['method'];
        }
        else
        {
            $this->request['call'] = NULL;
        }
    }

    /**
     * Parse command line argument AST for request parameters.
     *
     * @return void
     */
    protected function store_request()
    {
        foreach([ 'controller', 'method', 'c', 'm' ] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $index = ($key === 'controller') || ($key === 'c') ? 'controller' : 'method';

                $this->request[$index] = $this->ast[$key][0];
                unset($this->ast[$key]);
            }
        }

        if (isset($this->request['controller'], $this->request['method']) === TRUE)
        {
            $this->request['call'] = $this->request['controller'] . '/' . $this->request['method'];
        }
        else
        {
            $this->request['call'] = NULL;
        }

        foreach (['params', 'param', 'p'] as $key)
        {
            if (array_key_exists($key, $this->ast))
            {
                $this->request['params'] = $this->ast[$key];
                unset($this->ast[$key]);
            }
        }

        foreach([ 'post', 'get', 'cookie' ] as $global)
        {
            if (array_key_exists($global, $this->ast))
            {
                parse_str($this->ast[$global][0], $this->{$global});
                unset($this->ast[$global]);
            }
        }
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
        switch ($name)
        {
            case 'protocol':
            case 'domain':
            case 'port':
            case 'base_path':
            case 'base_url':
            case 'controller':
            case 'method':
            case 'params':
            case 'sapi':
            case 'host':
            case 'call':
                return $this->request[$name];
                break;
            default:
                return NULL;
                break;
        }
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
        if(array_key_exists($key, $this->ast))
        {
            return $this->ast[$key];
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
        return array_keys($this->ast);
    }

    /**
     * Returns a new inter request object.
     *
     * @param array $params the parameters to set the inter request with
     *
     * @return InterRequest $request The set inter request object
     */
    public function get_new_inter_request_object($params)
    {
        return new InterRequest($this, $params);
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
        return isset($this->post[$key]) ? $this->post[$key] : NULL;
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
     * Retrieve a stored FILES value.
     *
     * @param mixed $key Key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_files_data($key)
    {
        return NULL;
    }

}

?>
