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
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Profiling;

/**
 * Abstract Timer Backend class
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
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

    /**
     * Start a new Timer.
     *
     * @param Mixed $id        Identifier of the Timer, Numeric by default
     * @param Float $threshold Threshold of the Timer. Depending on the backend.
     *
     * @return Mixed $return Returns the Specified ID, or the assigned numeric ID,
     *                       or FALSE if a Timer for the chosen ID already exists.
     */
    abstract public function start_new_timer($id = '', $threshold = 0.0);

    /**
     * Stop a specified Timer.
     *
     * @param Mixed $id Identifier of the Timer
     *
     * @return Boolean $return FALSE if the Timer doesn't exist, TRUE otherwise
     */
    abstract public function stop_timer($id);

    /**
     * Stop all running Timers.
     *
     * @return void
     */
    abstract public function stop_all_timers();

}

?>
