<?php

/**
 * This file contains a PHP Class autoloader, which
 * on class instantiation tries to load the required
 * source file automatically without the need to
 * explicitely use a "require" or "include" statement
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

/**
 * PHP Class Autoloader
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Autoloader
{

    /**
     * The include path used for class lookup
     * @var String
     */
    private static $include_path;

    /**
     * List of controller prefixes of abstract controllers
     * that extend from the base Controller class.
     * @var array
     */
    private static $controllers = array(
        "web",
        "scripts",
        "cli"
    );

    /**
     * Try to load the given class file from the include path.
     *
     * @param String $class The Class name of the Class to load
     *
     * @return void
     */
    public static function load($class)
    {
        if (strpos($class, "Controller") !== FALSE
            && $class !== "Controller")
        {
            $controller = strtolower(str_replace("Controller", "", $class));
            if (in_array($controller, self::$controllers))
            {
                require_once "class.${controller}controller.inc.php";
            }
            else
            {
                require_once "controller.$controller.inc.php";
            }
        }
        elseif (strpos($class, "Model") !== FALSE
            && $class !== "Model")
        {
            $class = strtolower(str_replace("Model", "", $class));
            require_once "model.$class.inc.php";
        }
        elseif (strpos($class, "View") !== FALSE
            && $class !== "View")
        {
            $class = strtolower(str_replace("View", "", $class));
            require_once "view.$class.inc.php";
        }
        elseif (strpos($class, "Interface") !== FALSE
            && $class !== "Interface")
        {
            $class = strtolower(str_replace("Interface", "", $class));
            require_once "interface.$class.inc.php";
        }
        else
        {
            $class = strtolower($class);
            require_once "class.$class.inc.php";
        }
    }

    /**
     * Add a path to the include path.
     *
     * @param String $path New path that should be added to the include path
     *
     * @return void
     */
    public static function add_include_path($path)
    {
        set_include_path(
            get_include_path() . ":" .
            $path
        );
    }

    /**
     * Register a project specific controller.
     *
     * @param String $controller Controller Prefix
     *
     * @return void
     */
    public static function register_project_controller($controller)
    {
        self::$controllers[] = strtolower($controller);
    }

}

?>