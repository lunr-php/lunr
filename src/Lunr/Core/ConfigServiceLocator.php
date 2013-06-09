<?php

/**
 * This file contains an imlementation of the ServiceLocator
 * design pattern. It allows to transparently request class
 * instances without having to care about the instantiation
 * details or sharing.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

use ReflectionClass;

/**
 * Class Locator
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class ConfigServiceLocator
{

    /**
     * Registry for storing shared objects.
     * @var array
     */
    protected $registry;

    /**
     * Class bootstrap config cache.
     * @var array
     */
    protected $cache;

    /**
     * Instance of the Configuration class.
     * @var Configuration
     */
    protected $config;

    /**
     * Constructor.
     *
     * @param Configuration $config Shared instance of the Configuration class.
     */
    public function __construct($config)
    {
        $this->registry = array();
        $this->cache    = array();

        $this->config = $config;

        $this->registry['config']  = $config;
        $this->registry['locator'] = $this;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->registry);
        unset($this->cache);
        unset($this->config);
    }

    /**
     * Instantiate a new object by ID.
     *
     * @param String $id        ID of the object to instantiate
     * @param Array  $arguments Arguments passed on call (Ignored)
     *
     * @return Mixed $return new Object, NULL if the ID is unknown.
     */
    public function __call($id, $arguments)
    {
        return $this->locate($id);
    }

    /**
     * Locate an object by ID.
     *
     * @param String $id ID of the object to locate.
     *
     * @return Mixed $return new Object, NULL if the ID is unknown.
     */
    protected function locate($id)
    {
        if (isset($this->registry[$id]) && is_object($this->registry[$id]))
        {
            return $this->registry[$id];
        }

        if (isset($this->cache[$id]))
        {
            return $this->get_instance($id);
        }

        $this->load_recipe($id);

        if (isset($this->cache[$id]))
        {
            return $this->process_new_instance($id, $this->get_instance($id));
        }

        return NULL;
    }

    /**
     * Load recipe for instantiating a given ID.
     *
     * @param String $id ID of the object to load the recipe for.
     *
     * @return void
     */
    protected function load_recipe($id)
    {
        $file   = 'locator/locate.' . $id . '.inc.php';
        $recipe = '';

        if (stream_resolve_include_path($file))
        {
            include_once $file;
        }

        if (isset($recipe[$id]) && is_array($recipe[$id]) && is_array($recipe[$id]['params']))
        {
            $this->cache[$id] = $recipe[$id];
        }
    }

    /**
     * Check whether we need to do something special with a newly created object.
     *
     * @param String $id       ID of the object instantiated
     * @param mixed  $instance Newly created object instance
     *
     * @return mixed $instance The passed object instance.
     */
    protected function process_new_instance($id, $instance)
    {
        if (isset($this->cache[$id]['singleton']) && ($this->cache[$id]['singleton'] === TRUE))
        {
            $this->registry[$id] = $instance;
        }

        return $instance;
    }

    /**
     * Get a new object instance for a given ID.
     *
     * @param String $id ID of the object to instantiate.
     *
     * @return mixed $return new Object on success, NULL on error.
     */
    protected function get_instance($id)
    {
        $reflection = new ReflectionClass($this->cache[$id]['name']);

        if ($reflection->isInstantiable() !== TRUE)
        {
            return NULL;
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor))
        {
            return $reflection->newInstance();
        }

        $number_of_total_parameters    = $constructor->getNumberOfParameters();
        $number_of_required_parameters = $constructor->getNumberOfRequiredParameters();

        if (count($this->cache[$id]['params']) < $number_of_required_parameters)
        {
            return NULL;
        }

        if ($number_of_total_parameters > 0)
        {
            return $reflection->newInstanceArgs($this->get_parameters($this->cache[$id]['params']));
        }
        else
        {
            return $reflection->newInstance();
        }
    }

    /**
     * Prepare the parameters in the recipe for object instantiation.
     *
     * @param array $params Array of parameters according to the recipe.
     *
     * @return array $processed_params Array of processed parameters ready for instantiation.
     */
    protected function get_parameters($params)
    {
        $processed_params = array();

        foreach ($params as $value)
        {
            $tmp = $this->locate($value);

            if (is_null($tmp))
            {
                $processed_params[] = $value;
            }
            else
            {
                $processed_params[] = $tmp;
            }
        }

        return $processed_params;
    }

}

?>
