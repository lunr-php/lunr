<?php

/**
 * This file contains the implementation of the Timer Backend Factory.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Tcks
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Tcks;

/**
 * Factory class for providing a timer backend
 *
 * @category   Libraries
 * @package    Tcks
 * @subpackage Libraries
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
            case 'file':
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
