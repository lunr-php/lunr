<?php

/**
 * This file contains a PHP Class autoloader.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * PHP Class Autoloader, which on class instantiation tries
 * to load the required source file automatically without the
 * need to explicitely use a "require" or "include" statement.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Autoloader
{

    /**
     * List of controller prefixes of abstract controllers
     * that extend from the base Controller class.
     * @var array
     */
    private $controllers;

    /**
     * List of included files.
     * @var array
     */
    private $loaded;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->controllers = array();
        $this->loaded      = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->controllers);
        unset($this->loaded);
    }

    /**
     * Try to load the given class file from the include path.
     *
     * @param String $class The Class name of the Class to load
     *
     * @return void
     */
    public function load($class)
    {
        $file = $this->get_legacy_class_filepath($class);

        if (!in_array($file, $this->loaded))
        {
            include_once $file;
            $this->loaded[] = $file;
        }
    }

    /**
     * Add a path to the include path.
     *
     * @param String $path New path that should be added to the include path
     *
     * @return void
     */
    public function add_include_path($path)
    {
        set_include_path(
            get_include_path() . ':' .
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
    public function register_project_controller($controller)
    {
        $this->controllers[] = strtolower($controller);
    }

    /**
     * Convert namespaced classname to filepath.
     *
     * @param String $class namespaced classname
     *
     * @return String $filepath Path and filename
     */
    private function get_legacy_class_filepath($class)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        $path  = strtolower(dirname($class));
        $path  = substr($path, strpos($path, DIRECTORY_SEPARATOR) + 1);
        $path  = empty($path) ? '' : $path . DIRECTORY_SEPARATOR;
        $class = basename($class);

        return $path . $this->get_legacy_class_filename($class);
    }

    /**
     * Construct the expected filename for a class.
     *
     * @param String $class Classname
     *
     * @return String $filename Expected filename
     */
    private function get_legacy_class_filename($class)
    {
        $normalized_name = trim(preg_replace('/([a-z0-9])?([A-Z])/', '$1 $2', $class));
        $split_name      = explode(' ', $normalized_name);

        if ($split_name[0] == 'Mock')
        {
            $class = strtolower(str_replace('Mock', '', $class));
            return "class.$class.mock.php";
        }

        $index = sizeof($split_name) - 1;

        if ($index == 0)
        {
            $class = strtolower($class);
            return "class.$class.inc.php";
        }

        switch ($split_name[$index])
        {
            case 'Controller':
                $class = strtolower(str_replace($split_name[$index], '', $class));
                if (in_array($class, $this->controllers))
                {
                    return "class.${class}controller.inc.php";
                }
                else
                {
                    return "controller.$class.inc.php";
                }
                break;
            case 'Model':
            case 'View':
            case 'Interface':
                $class = strtolower(str_replace($split_name[$index], '', $class));
                return strtolower($split_name[$index]) . ".$class.inc.php";
                break;
            case 'Test':
                $class = strtolower(str_replace('Test', '', $class));
                return "class.$class.test.php";
                break;
            default:
                $class = strtolower($class);
                return "class.$class.inc.php";
                break;
        }
    }

}

?>