<?php

/**
 * This file contains an output abstraction class, making
 * it easy to output errors without worrying where they
 * will land.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core;

/**
 * Output library
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Output
{

    /**
     * Print given message immediatly.
     *
     * @param String $msg Message to print
     *
     * @return void
     */
    public static function cli_print($msg)
    {
        $datetime = new DateTime();
        echo $datetime->set_datetime_format('%Y-%m-%d %H-%M-%S')->get_datetime() . ': ' . $msg;
    }

    /**
     * Print status information ([ok] or [failed]).
     *
     * @param Boolean $bool Whether to print a good or bad status
     *
     * @return void
     */
    public static function cli_print_status($bool)
    {
        if ($bool === TRUE)
        {
            echo "[ok]\n";
        }
        else
        {
            echo "[failed]\n";
        }
    }

    /**
     * Print given message immediatly.
     *
     * @param String $msg Message to print
     *
     * @return void
     */
    public static function cli_println($msg)
    {
        $datetime = new DateTime();
        echo $datetime->set_datetime_format('%Y-%m-%d %H-%M-%S')->get_datetime() . ': ' . $msg . "\n";
    }

    /**
     * Trigger a PHP error.
     *
     * @param String $info The error string that should be printed
     * @param String $file The log file the error should be logged to (optional)
     *
     * @return void
     */
    public static function error($info, $file = '')
    {
        $datetime = new DateTime();
        if (isset($_GET['controller']) && isset($_GET['method']))
        {
            if ($file == '')
            {
                trigger_error(
                    $_GET['controller'] . '/' . $_GET['method'] . ': ' . $info
                );
            }
            else
            {
                $prefix = '[' . $datetime->set_datetime_format('%Y-%m-%d %H-%M-%S')->get_datetime() . ']: ';
                error_log(
                    $prefix . $_GET['controller'] . '/' . $_GET['method']
                    . ': ' . $info, 3, $file
                );
            }
        }
        else
        {
            if ($file == '')
            {
                trigger_error($info);
            }
            else
            {
                $prefix = '[' . $datetime->set_datetime_format('%Y-%m-%d %H-%M-%S')->get_datetime() . ']: ';
                error_log($prefix . $info, 3, $file);
            }
        }
    }

    /**
     * Trigger a PHP error (with linebreak at the end).
     *
     * @param String $info The error string that should be printed
     * @param String $file The log file the error should be logged to (optional)
     *
     * @return void
     */
    public static function errorln($info, $file = '')
    {
        return static::error($info . "\n", $file);
    }

}

?>
