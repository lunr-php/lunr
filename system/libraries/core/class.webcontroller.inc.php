<?php

/**
 * This file contains an abstract WebController class,
 * containing methods specifically targeted for the
 * Web Usage.
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
 * Web Controller class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class WebController
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Handle unimplemented calls
     *
     * @param String $name      Method name
     * @param array  $arguments Arguments passed to the method
     *
     * @return String JSON encoded error String
     */
    public function __call($name, $arguments)
    {
        return "<h1>Not implemented</h1>";
    }

    /**
     * Default method as defined in conf.application.inc.php
     *
     * @return void
     */
    abstract public function index();

}

?>
