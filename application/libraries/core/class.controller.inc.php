<?php

/**
 * Base Controller class
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class Controller
{

    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * Destructor
     */
    public function __destruct()
    {

    }

    /**
     * Handle unimplemented calls
     * @param String $name Method name
     * @param array $arguments Arguments passed to the method
     * @return String JSON encoded error String
     */
    public function __call($name, $arguments)
    {
        return Json::error("not_implemented");
    }

    /**
     * Default method as defined in conf.application.inc.php
     */
    abstract public function index();

}

?>
