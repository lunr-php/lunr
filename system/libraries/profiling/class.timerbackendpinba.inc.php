<?php

/**
 * This file contains the pinba backend for the Timer class.
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
 * Pinba Backend for the Timer class.
 * Pinba is a combination of a php extension and a
 * MySQL storage engine. It measure the time using
 * it's own API and sends the data via UDP to the
 * database which stores the results.
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class TimerBackendPinba extends TimerBackend
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

}

?>
