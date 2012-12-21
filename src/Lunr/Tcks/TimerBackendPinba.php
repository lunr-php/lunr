<?php

/**
 * This file contains the pinba backend for the Timer class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Tcks
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Tcks;

/**
 * Pinba Backend for the Timer class.
 * Pinba is a combination of a php extension and a
 * MySQL storage engine. It measure the time using
 * it's own API and sends the data via UDP to the
 * database which stores the results.
 *
 * @category   Libraries
 * @package    Tcks
 * @subpackage Libraries
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

    /**
     * Start a new Timer.
     *
     * @param Mixed $id        Identifier of the Timer, Numeric by default
     * @param Float $threshold Threshold of the Timer. Ignored for Pinba
     *
     * @return Mixed $return Returns the Specified ID, or the assigned numeric ID,
     *                       or FALSE if a Timer for the chosen ID already exists.
     */
    public function start_new_timer($id = '', $threshold = 0.0)
    {
        return FALSE;
    }

    /**
     * Stop a specified Timer.
     *
     * @param Mixed $id Identifier of the Timer
     *
     * @return Boolean $return FALSE if the Timer doesn't exist, TRUE otherwise
     */
    public function stop_timer($id)
    {
        return FALSE;
    }

    /**
     * Stop all running Timers.
     *
     * @return void
     */
    public function stop_all_timers()
    {

    }

}

?>
