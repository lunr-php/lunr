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
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

use Lunr\Corona\InterRequest;

/**
 * The CliRequest class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class CliRequest
{

    /**
     * Stored $_POST values
     * @var array
     */
    private $post;

    /**
     * Stored $_GET values
     * @var array
     */
    private $get;

    /**
     * Stored $_COOKIE values
     * @var array
     */
    private $cookie;

    /**
     * "Abstract Syntax Tree" of the passed arguments
     * @var array
     */
    private $ast;

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
     *
     * @var array
     */
    private $request;

    /**
     * Stored json enums
     * @var array
     */
    private $json_enums;

    /**
     * Constructor.
     *
     * @param Configuration      $configuration Shared instance of the Configuration class
     * @param CliParserInterface $parser        The CliParser of this request
     */
    public function __construct($configuration, $parser)
    {
        $this->ast        = $parser->parse();
        $this->post       = array();
        $this->get        = array();
        $this->cookie     = array();
        $this->request    = array();
        $this->json_enums = array();

        $this->request['sapi'] = PHP_SAPI;
        $this->request['host'] = gethostname();

        $this->store_default($configuration);
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
        unset($this->json_enums);
    }

    /**
     * Store default controller, method, params and url values.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     *
     * @return void
     */
    private function store_default($configuration)
    {
        $this->request['controller'] = $configuration['default_controller'];
        $this->request['method']     = $configuration['default_method'];
        $this->request['params']     = array();

        $this->request['base_path'] = $configuration['default_webpath'];
        $this->request['protocol']  = $configuration['default_protocol'];
        $this->request['domain']    = $configuration['default_domain'];
        $this->request['port']      = $configuration['default_port'];
        $this->request['base_url']  = $configuration['default_url'];
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
     * Store a set of json enums.
     *
     * @param array &$enums An array of json enums
     *
     * @return void
     */
    public function set_json_enums(&$enums)
    {
        $this->json_enums =& $enums;
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
        return NULL;
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
        return NULL;
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
        return NULL;
    }

    /**
     * Retrieve a stored POST value using a json enum key.
     *
     * @param mixed $key Json enum key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_json_from_post($key)
    {
        return NULL;
    }

    /**
     * Retrieve a stored GET value using a json enum key.
     *
     * @param mixed $key Json enum key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_json_from_get($key)
    {
        return NULL;
    }

}

?>
