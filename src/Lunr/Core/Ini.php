<?php

/**
 * This file contains the Ini class, an object wrapper around php.ini handling.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * php.ini handling wrapper class.
 */
class Ini
{

    /**
     * php.ini section
     * @var String
     */
    protected $section;

    /**
     * Constructor.
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
     * @param String $name  php.ini configuration option.
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
     * @param String $name  php.ini configuration option.
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
     * @param String $name php.ini configuration option.
     *
     * @return void
     */
    public function __unset($name)
    {
        ini_restore(is_null($this->section) ? $name : $this->section . '.' . $name);
    }

}

?>
