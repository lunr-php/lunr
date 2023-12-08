<?php

/**
 * This file contains the FrontController class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use RegexIterator;

/**
 * Controller class
 */
class FrontController
{

    /**
     * Shared instance of the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Shared instance of the RequestResultHandler class.
     * @var RequestResultHandler
     */
    protected $handler;

    /**
     * Registered lookup paths.
     * @var array
     */
    protected $paths;

    /**
     * Registered routing rules.
     * @var array
     */
    protected $routes;

    /**
     * Constructor.
     *
     * @param Request              $request Instance of the Request class.
     * @param RequestResultHandler $handler Instance of the RequestResultHandler class.
     */
    public function __construct($request, $handler)
    {
        $this->request = $request;
        $this->handler = $handler;

        $this->paths  = [];
        $this->routes = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
        unset($this->handler);
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
     * @param string $src       Project subfolder to look for controllers in.
     * @param array  $list      List of controller names
     * @param bool   $blacklist Whether to use the controller list as blacklist or whitelist
     *
     * @return string $controller Fully qualified name of the responsible controller.
     */
    public function get_controller(string $src, array $list = [], bool $blacklist = TRUE): string
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

        if (!preg_match('/^[a-zA-Z0-9\-_]*$/', $name))
        {
            return '';
        }

        $name = str_replace('-', '', $name);

        $directory  = new RecursiveDirectoryIterator($src);
        $iterator   = new RecursiveIteratorIterator($directory);
        $candidates = new RegexIterator($iterator, "/^.+\/$name.php/i", RecursiveRegexIterator::GET_MATCH);

        $matches = array_keys(iterator_to_array($candidates));

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
        $this->handler->handle_request([ $controller, $this->request->method ], $this->request->params);
    }

}

?>
