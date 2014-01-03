<?php

/**
 * This file contains the request abstraction class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spawn;

use Lunr\Corona\InterRequest;
use Lunr\Corona\RequestInterface;

/**
 * Request abstraction class.
 *
 * @category   Libraries
 * @package    Spawn
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class ResqueRequest implements RequestInterface
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
     * Stored $_FILES values
     * @var array
     */
    protected $files;

    /**
     * Constructor.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     */
    public function __construct($configuration)
    {
        $this->post    = [];
        $this->get     = [];
        $this->cookie  = [];
        $this->request = [];
        $this->json    = [];
        $this->files   = [];

        $this->request['protocol']  = 'resque';
        $this->request['domain']    = $configuration['default_domain'];
        $this->request['port']      = $configuration['default_port'];
        $this->request['base_path'] = $configuration['default_webpath'];
        $this->request['base_url']  = $configuration['default_url'];

        $this->request['sapi'] = PHP_SAPI;
        $this->request['host'] = gethostname();

        $this->request['controller'] = 'resque';
        $this->request['method']     = '';
        $this->request['params']     = [];
        $this->request['call']       = 'resque/';

    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->post);
        unset($this->get);
        unset($this->cookie);
        unset($this->request);
        unset($this->json);
        unset($this->files);
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
     * Set the resque job name.
     *
     * @param String $name The resque job name
     *
     * @return void
     */
    public function set_job_name($name)
    {
        $this->request['method'] = $name;
        $this->request['call']   = $this->request['controller'] . '/' . $name;
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

}

?>
