<?php

/**
 * This file contains a class holding authentication data for Spark modules.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Spark;

/**
 * Central Authentication Data Store for Spark modules.
 *
 * @deprecated Use `Psr\Cache\CacheItemPoolInterface` instead
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
     * @param string $module Module identifier (e.g. 'facebook')
     * @param string $key    Identifier for the item (e.g. 'app_id')
     * @param string $value  Item value
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
     * @param string $module Module identifier (e.g. 'facebook')
     * @param string $key    Identifier for the item (e.g. 'app_id')
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
     * @param string $module Module identifier (e.g. 'facebook')
     * @param string $key    Identifier for the item (e.g. 'app_id')
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
