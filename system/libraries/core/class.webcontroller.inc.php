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
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * Web Controller class
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class WebController implements ControllerInterface
{

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * Destructor.
     */
    public function __destruct()
    {

    }

    /**
     * Handle unimplemented calls.
     *
     * @param String $name      Method name
     * @param array  $arguments Arguments passed to the method
     *
     * @return String JSON encoded error String
     */
    public function __call($name, $arguments)
    {
        return '<h1>Not implemented</h1>';
    }

}

?>
