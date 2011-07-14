<?php

/**
 * This file contains the implementation of the Timer Backend Factory.
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
 * Factory class for providing a timer backend
 *
 * @category   Libraries
 * @package    Profiling
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class TimerBackendFactory
{

    /**
     * Instance of the TimerBackend
     * @var TimerBackend
     */
    private static $backend;

    /**
     * Returns an instance of the requested timer backend.
     *
     * @param String $backend The requested backend
     *
     * @return L10nProvider $return Instance of the requested timer backend
     */
    public static function get_backend($backend)
    {
        switch ($backend)
        {
            case "file":
            default:
                if (!isset(self::$backend))
                {
                    self::$backend = new TimerBackendFile();
                }

                return self::$backend;
                break;
        }
    }

}

?>
