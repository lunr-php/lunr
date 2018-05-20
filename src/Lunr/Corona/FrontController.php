<?php

/**
 * This file contains the FrontController class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona;

/**
 * Controller class
 */
class FrontController
{

    /**
     * Instance of the Request class.
     * @var RequestInterface
     */
    protected $request;

    /**
     * Instance of the FilesystemAccessObject class.
     * @var FilesystemAccessObjectInterface
     */
    protected $fao;

    /**
     * Registered lookup paths.
     * @var Array
     */
    protected $paths;

    /**
     * Registered routing rules.
     * @var Array
     */
    protected $routes;

    /**
     * Constructor.
     *
     * @param RequestInterface                $request Instance of the Request class.
     * @param FilesystemAccessObjectInterface $fao     Instance of the FilesystemAccessObject class.
     */
    public function __construct($request, $fao)
    {
        $this->request = $request;
        $this->fao     = $fao;

        $this->paths  = [];
        $this->routes = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->fao);
        unset($this->paths);
        unset($this->routes);
    }

    /**
     * Register a path for controller lookup
     *
     * @param string $identifier Path identifier
     * @param string $path       Path specification
     *
     * @return void
     */
    public function register_lookup_path($identifier, $path)
    {
        $this->paths[$identifier] = $path;
    }

    /**
     * Add a static routing rule for specific calls.
     *
     * @param string $call  Request call identifier (either call or controller name)
     * @param mixed  $route Routing rule. Use NULL for blacklisting, an empty array for whitelisting
     *                      or an array of path identifiers to limit the lookup search to those paths.
     *
     * @return void
     */
    public function add_routing_rule($call, $route = [])
    {
        $this->routes[$call] = $route;
    }

    /**
     * Get the controller responsible for the request.
     *
     * @param string  $src       Project subfolder to look for controllers in.
     * @param array   $list      List of controller names
     * @param boolean $blacklist Whether to use the controller list as blacklist or whitelist
     *
     * @return string $controller Fully qualified name of the responsible controller.
     */
    public function get_controller($src, $list = [], $blacklist = TRUE)
    {
        $name = $this->request->controller . 'controller';

        if ($name == 'controller')
        {
            return '';
        }

        if (($blacklist === TRUE) && in_array($this->request->controller, $list))
        {
            return '';
        }
        elseif (($blacklist === FALSE) && !in_array($this->request->controller, $list))
        {
            return '';
        }

        $matches = $this->fao->find_matches("/^.+\/$name.php/i", $src);

        if (empty($matches) === TRUE)
        {
            return '';
        }

        $search  = [ '.php', $src, '/' ];
        $replace = [ '', '', '\\' ];

        return ltrim(str_replace($search, $replace, $matches[0]), '\\');
    }

    /**
     * Lookup the controller in the registered paths.
     *
     * @param string ...$paths Identifiers for the paths to use for the lookup
     *
     * @return string $controller Fully qualified name of the responsible controller.
     */
    public function lookup(...$paths)
    {
        if (empty($this->paths))
        {
            return '';
        }

        $paths = empty($paths) ? array_keys($this->paths) : $paths;

        $controller = '';

        foreach ($paths as $id)
        {
            if (array_key_exists($id, $this->paths))
            {
                $controller = $this->get_controller($this->paths[$id]);
            }

            if ($controller != '')
            {
                break;
            }
        }

        return $controller;
    }

    /**
     * Find the controller name for the request made.
     *
     * @return string $controller Fully qualified name of the responsible controller.
     */
    public function route()
    {
        foreach ([ 'call', 'controller' ] as $id)
        {
            $key = $this->request->$id;

            if (array_key_exists($key, $this->routes))
            {
                if ($this->routes[$key] === NULL)
                {
                    return '';
                }
                else
                {
                    return $this->lookup(...$this->routes[$key]);
                }
            }
        }

        return $this->lookup();
    }

    /**
     * Dispatch to the found controller.
     *
     * @param Controller $controller Instance of the responsible Controller class.
     *
     * @return void
     */
    public function dispatch($controller)
    {
        call_user_func_array([ $controller, $this->request->method ], $this->request->params);
    }

}

?>
