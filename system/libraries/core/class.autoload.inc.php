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
class Autoload
{

    /**
     * The include path used for class lookup
     * @var String
     */
    private static include_path;

    /**
     * Try to load the given class file from the include path
     *
     * @param String $class The Class name of the Class to load
     *
     * @return void
     */
    public static function load($class)
    {

    }

    /**
     * Add a path to the include path
     *
     * @param String $path New path that should be added to the include path
     *
     * @return void
     */
    public static function add_include_path($path)
    {

    }

}

?>