<?php

/**
 * This file contains the request abstraction class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Request abstraction class.
 * Manages access to $_POST, $_GET values, as well as
 * the request URL parameters
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Request
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 */
class Request implements RequestInterface
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
     * Stored json enums
     * @var array
     */
    private $json_enums;

    /**
     * Constructor.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     */
    public function __construct($configuration)
    {
        $this->post       = array();
        $this->get        = array();
        $this->request    = array();
        $this->json_enums = array();

        $this->request['sapi'] = PHP_SAPI;
        $this->request['host'] = gethostname();

        $this->store_post();
        $this->store_get($configuration);
        $this->store_cookie();
        $this->store_url($configuration);
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
        unset($this->json_enums);
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
     * Store $_POST values locally and reset it globally.
     *
     * @return void
     */
    protected function store_post()
    {
        if (!is_array($_POST) || empty($_POST))
        {
            //reset global POST array
            $_POST = array();

            return;
        }

        foreach ($_POST as $key => $value)
        {
            $this->post[$key] = $value;
        }

        //reset global POST array
        $_POST = array();
    }

    /**
     * Store $_GET values locally and reset it globally.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     *
     * @return void
     */
    protected function store_get($configuration)
    {
        if (!is_array($_GET) || empty($_GET))
        {
            $this->request['controller'] = $configuration['default_controller'];
            $this->request['method']     = $configuration['default_method'];
            $this->request['params']     = array();

            if (isset($this->request['controller'], $this->request['method']) === TRUE)
            {
                $this->request['call'] = $this->request['controller'] . '/' . $this->request['method'];
            }
            else
            {
                $this->request['call'] = NULL;
            }

            //reset global GET array
            $_GET = array();

            return;
        }

        foreach ($_GET as $key => $value)
        {
            if (substr($key, 0, 5) == 'param')
            {
                $this->request['params'][] = $value;
            }
            elseif ($key == 'controller')
            {
                $this->request['controller'] = $value;
            }
            elseif ($key == 'method')
            {
                $this->request['method'] = $value;
            }
            else
            {
                $this->get[$key] = $value;
            }
        }

        if (!isset($this->request['controller']))
        {
            $this->request['controller'] = $configuration['default_controller'];
        }

        if (!isset($this->request['method']))
        {
            $this->request['method'] = $configuration['default_method'];
        }

        if (!isset($this->request['params']))
        {
            $this->request['params'] = array();
        }

        if (isset($this->request['controller'], $this->request['method']) === TRUE)
        {
            $this->request['call'] = $this->request['controller'] . '/' . $this->request['method'];
        }
        else
        {
            $this->request['call'] = NULL;
        }

        //reset global GET array
        $_GET = array();
    }

    /**
     * Store $_COOKIE values locally and reset it globally.
     *
     * @return void
     */
    protected function store_cookie()
    {
        if (!is_array($_COOKIE) || empty($_COOKIE))
        {
            //reset global COOKIE array
            $_COOKIE = array();

            return;
        }

        foreach ($_COOKIE as $key => $value)
        {
            $this->cookie[$key] = $value;
        }

        //reset global COOKIE array
        $_COOKIE = array();
    }

    /**
     * Store url request values locally.
     *
     * @param Configuration $configuration Shared instance of the Configuration class
     *
     * @return void
     */
    protected function store_url($configuration)
    {
        if ($this->request['sapi'] == 'cli')
        {
            $this->request['base_path'] = $configuration['default_webpath'];
            $this->request['protocol']  = $configuration['default_protocol'];
            $this->request['domain']    = $configuration['default_domain'];
            $this->request['port']      = $configuration['default_port'];
            $this->request['base_url']  = $configuration['default_url'];
        }
        else
        {
            $this->request['base_path'] = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);

            $this->request['protocol'] =
                (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') ? 'https' : 'http';

            $this->request['domain'] = $_SERVER['SERVER_NAME'];
            $this->request['port']   = $_SERVER['SERVER_PORT'];

            $baseurl = $this->request['protocol'] . '://' . $this->request['domain'];
            if ((($this->request['protocol'] == 'http') && ($this->request['port'] != 80))
                || (($this->request['protocol'] == 'https') && ($this->request['port'] != 443)))
            {
                $baseurl .= ':' . $this->request['port'];
            }

            $this->request['base_url'] = $baseurl . $this->request['base_path'];
        }
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
     * Retrieve a stored POST value using a json enum key.
     *
     * @param mixed $key Json enum key for the value to retrieve
     *
     * @return mixed $return The value of the key or NULL if not found
     */
    public function get_json_from_post($key)
    {
        if (empty($this->json_enums) || !isset($this->json_enums[$key]))
        {
            return NULL;
        }
        else
        {
            return $this->get_post_data($this->json_enums[$key]);
        }
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
        if (empty($this->json_enums) || !isset($this->json_enums[$key]))
        {
            return NULL;
        }
        else
        {
            return $this->get_get_data($this->json_enums[$key]);
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

}

?>
