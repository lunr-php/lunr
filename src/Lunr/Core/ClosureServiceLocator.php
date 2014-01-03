<?php

/**
 * This file contains an imlementation of the ServiceLocator
 * design pattern. It allows to transparently request class
 * instances without having to care about the instantiation
 * details or sharing.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * Class Locator
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class ClosureServiceLocator
{

    /**
     * Registry for storing shared objects.
     * @var array
     */
    protected $registry;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->registry = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->registry);
    }

    /**
     * Store a new closure to get an object from a class.
     *
     * @param String   $id      ID of the closure
     * @param callable $closure Closure to store
     *
     * @return void
     */
    public function __set($id, $closure)
    {
        if (is_callable($closure))
        {
            $this->registry[$id] = $closure;
        }
    }

    /**
     * Instantiate a new object by closure ID.
     *
     * @param String $id        ID of the closure
     * @param Array  $arguments Arguments passed to the closure
     *
     * @return Mixed $return new Object, NULL if the ID is unknown.
     */
    public function __call($id, $arguments)
    {
        if (isset($this->registry[$id]) === FALSE)
        {
            return NULL;
        }

        return call_user_func_array($this->registry[$id], $arguments);
    }

    /**
     * Treat the object instantiated by a closure as singleton.
     *
     * @param callable $closure The closure
     *
     * @return callable $return Closure creating a singleton object
     */
    public function as_singleton($closure)
    {
        if (is_callable($closure) === FALSE)
        {
            return NULL;
        }

        return function () use ($closure)
        {
            static $object;

            if (is_null($object))
            {
                $object = call_user_func_array($closure, func_get_args());
            }

            return $object;
        };
    }

}

?>
