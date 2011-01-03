<?php

/**
 * Web Controller class
 * @author M2Mobi, Heinz Wiesinger
 */
abstract class WebController
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
        return "<h1>Not implemented</h1>";
    }

    /**
     * Default method as defined in conf.application.inc.php
     */
    abstract public function index();

}

?>
