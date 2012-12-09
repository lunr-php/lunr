<?php

/**
 * This file contains the class Timer, which can be used
 * for all kinds of time measurements.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Profiling;

/**
 * Time / Performance measurements
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Timer
{

    /**
     * Instance of the Timer Backend in use
     * @var TimerBackend
     */
    private static $backend;

    /**
     * Type of the backend in use
     * @var String
     */
    private static $backend_type;

    /**
     * Start a new Timer.
     *
     * @param Mixed $id        Identifier of the Timer, Numeric by default
     * @param Float $threshold Threshold of the Timer. Depending on the backend.
     *
     * @return Mixed $return Returns the Specified ID, or the assigned numeric ID,
     *                       or FALSE if a Timer for the chosen ID already exists.
     */
    public static function start_new_timer($id, $threshold = 0.0)
    {
        if (!isset(self::$backend))
        {
            self::set_backend('file');
        }

        return self::$backend->start_new_timer($id, $threshold);
    }

    /**
     * Stop a specified Timer.
     *
     * @param Mixed $id Identifier of the Timer
     *
     * @return Boolean $return FALSE if the Timer doesn't exist, TRUE otherwise
     */
    public static function stop_timer($id)
    {
        return self::$backend->stop_timer($id);
    }

    /**
     * Stop all running Timers.
     *
     * @return void
     */
    public static function stop_all_timers()
    {
        self::$backend->stop_all_timers();
    }

    /**
     * Set a backend to use for the Timers.
     *
     * Used for calculation and result storage
     *
     * @param String $backend The backend you'd like to use
     *
     * @return Boolean $return TRUE if the specified backend is used,
     *                         FALSE otherwise;
     */
    public static function set_backend($backend)
    {
        if (!isset(self::$backend))
        {
            self::$backend      = TimerBackendFactory::get_backend($backend);
            self::$backend_type = $backend;
            return TRUE;
        }
        elseif (self::$backend_type == $backend)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

}

?>
