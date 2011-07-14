<?php

/**
 * This file contains the abstract definition for a
 * Timer Backend. A Timer Backend is a class to handle
 * actual timer measurement as well as result storage.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Profiling;

/**
 * Abstract Timer Backend class
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class TimerBackend
{

    /**
     * Constructor.
     */
    abstract public function __construct();

    /**
     * Destructor.
     */
    abstract public function __destruct();

}

?>
