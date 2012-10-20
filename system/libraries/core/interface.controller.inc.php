<?php

/**
 * This file contains the base controller interface.
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
 * Base Controller interface
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface ControllerInterface
{

    /**
     * Handle unimplemented calls.
     *
     * @param String $name      Method name
     * @param array  $arguments Arguments passed to the method
     *
     * @return mixed
     */
    public function __call($name, $arguments);

}

?>