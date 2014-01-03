<?php

/**
 * This file contains a class holding authentication data for Spark modules.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage CAS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark;

/**
 * Central Authentication Data Store for Spark modules.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage CAS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class CentralAuthenticationStore
{

    /**
     * Data store.
     * @var array
     */
    protected $store;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->store = [];
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->store);
    }

    /**
     * Add an item to the data store.
     *
     * @param String $module Module identifier (e.g. 'facebook')
     * @param String $key    Identifier for the item (e.g. 'app_id')
     * @param String $value  Item value
     *
     * @return void
     */
    public function add($module, $key, $value)
    {
        if (isset($this->store[$module]) === FALSE)
        {
            $this->store[$module] = [];
        }

        $this->store[$module][$key] = $value;
    }

    /**
     * Delete an item from the data store.
     *
     * @param String $module Module identifier (e.g. 'facebook')
     * @param String $key    Identifier for the item (e.g. 'app_id')
     *
     * @return void
     */
    public function delete($module, $key)
    {
        if (isset($this->store[$module]))
        {
            unset($this->store[$module][$key]);
        }
    }

    /**
     * Get an item from the data store.
     *
     * @param String $module Module identifier (e.g. 'facebook')
     * @param String $key    Identifier for the item (e.g. 'app_id')
     *
     * @return mixed $value Item value
     */
    public function get($module, $key)
    {
        if (isset($this->store[$module]) === FALSE)
        {
            return NULL;
        }

        if (isset($this->store[$module][$key]))
        {
            return $this->store[$module][$key];
        }
        else
        {
            return NULL;
        }
    }

}

?>
