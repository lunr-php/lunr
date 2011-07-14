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
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 *
 */

namespace Lunr\Libraries\Profiling;

/**
 * Time / Performance measurements
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 *
 */
class Timer
{

    private static $backend;

    private static $backend_type;

    public static function start_new_timer()
    {

    }

    public static function stop_timer()
    {

    }

    public static function stop_all_timers()
    {

    }

    public static function set_backend($backend)
    {
        if (!isset(self::$backend))
        {
            self::$backend = TimerBackendFactory::get_backend($backend);
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
