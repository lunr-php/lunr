<?php

/**
 * This file contains the Ini class, an object wrapper around php.ini handling.
 *
 * SPDX-FileCopyrightText: Copyright 2016 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Core;

/**
 * php.ini handling wrapper class.
 */
class Ini
{

    /**
     * php.ini section
     * @var string|null
     */
    protected $section;

    /**
     * Constructor.
     *
     * @param string|null $section Ini section to wrap
     */
    public function __construct($section = NULL)
    {
        $this->section = $section;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->section);
    }

    /**
     * Set a new value for an ini configuration option.
     *
     * @param string $name  The php.ini configuration option.
     * @param mixed  $value New value
     *
     * @return void
     */
    public function __set($name, $value)
    {
        ini_set(is_null($this->section) ? $name : $this->section . '.' . $name, $value);
    }

    /**
     * Get the current value for an ini configuration option.
     *
     * @param string $name The php.ini configuration option.
     *
     * @return mixed $value The current value of the configuration option.
     */
    public function __get($name)
    {
        return ini_get(is_null($this->section) ? $name : $this->section . '.' . $name);
    }

    /**
     * Reset a ini configuration option.
     *
     * @param string $name The php.ini configuration option.
     *
     * @return void
     */
    public function __unset($name)
    {
        ini_restore(is_null($this->section) ? $name : $this->section . '.' . $name);
    }

    /**
     * Convert a human readable memory limit string into an integer.
     *
     * @param string $val Human readable memory limit
     *
     * @return int $val Integer memory limit in bytes
     */
    public function get_integer_for_shorthand_bytes($val)
    {
        $val  = trim($val);
        $last = strtolower($val[ strlen($val) - 1 ]);

        $val = intval($val);

        switch ($last)
        {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
            default:
                break;
        }

        return (int) $val;
    }

}

?>
