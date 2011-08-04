<?php

/**
 * This file contains the class M2DateTime, which is a collection
 * of commonly used Date and Time methods.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 *
 */

namespace Lunr\Libraries\Core;

/**
 * Date/Time related functions
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Jose Viso <jose@m2mobi.com>
 *
 */
class M2DateTime
{

    /**
     * Return today's date (YYYY-MM-DD).
     *
     * @return String Today's date
     */
    public static function today()
    {
        return date('Y-m-d');
    }

    /**
     * Return yesterday's date (YYYY-MM-DD).
     *
     * @return String Tomorrow's date
     */
    public static function yesterday()
    {
        return date('Y-m-d', strtotime('-1 day'));
    }

    /**
     * Return tomorrow's date (YYYY-MM-DD).
     *
     * @return String Tomorrow's date
     */
    public static function tomorrow()
    {
        return date('Y-m-d', strtotime('+1 day'));
    }

    /**
     * Return a date of a certain timeframe in the past/future.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return String Delayed date
     */
    public static function delayed_date($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return date('Y-m-d', strtotime($delay, $timestamp));
    }

    /**
     * Return a timestamp of a certain timeframe in the past/future.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return Integer Delayed timestamp
     */
    public static function delayed_timestamp($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return strtotime($delay, $timestamp);
    }

    /**
     * Return a delayed datetime string.
     *
     * @param String  $delay     Definition for a timeframe
     *                           ("+1 day", "-10 minutes")
     * @param Integer $timestamp Base timestamp, now by default (optional)
     *
     * @return String $return DateTime definition, format YYYY-MM-DD HH:MM:SS
     */
    public static function delayed_datetime($delay, $timestamp = 0)
    {
        if ($timestamp === 0)
        {
            $timestamp = time();
        }
        return date('Y-m-d H:i:s', strtotime($delay, $timestamp));
    }

    /**
     * Return the current time (HH:MM:SS).
     *
     * @return String current time
     */
    public static function now()
    {
        return strftime('%H:%M:%S', time());
    }

    /**
     * Return a date formatted as "MMM" (DEC).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public static function get_short_textmonth($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return strtoupper(strftime('%b', time()));
        }
        else
        {
            return strtoupper(strftime('%b', $timestamp));
        }
    }

    /**
     * Returns a MySQL compatible date definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp
     *
     * @return String $date Date as a string
     */
    public static function get_date($timestamp)
    {
        return date('Y-m-d', $timestamp);
    }

    /**
     * Returns a MySQL compatible time definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp
     *
     * @return String $time Time as a string
     */
    public static function get_time($timestamp)
    {
        return strftime('%H:%M:%S', $timestamp);
    }

    /**
     * Returns a MySQL compatible Date & Time definition.
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     *
     * @return String $datetime Date & Time as a string
     */
    public static function get_datetime($timestamp = FALSE)
    {
        if ($timestamp === FALSE)
        {
            return date('Y-m-d H:i', time());
        }
        else
        {
            return date('Y-m-d H:i', $timestamp);
        }
    }

    /**
     * Return a date formatted as "DD MMM" (eg 05 Dec).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public static function get_short_date($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return strtoupper(strftime('%d %b', time()));
        }
        else
        {
            return strtoupper(strftime('%d %b', $timestamp));
        }
    }

    /**
     * Return a date formatted as "DD Month, YYYY" (eg 04 August, 2011).
     *
     * @param Integer $timestamp PHP-like Unix Timestamp (optional)
     * @param String  $locale    The locale that should be used for the month
     *                           names (optional, en_US by default)
     *
     * @return String $date Date as a string
     */
    public static function get_text_date($timestamp = FALSE, $locale = 'en_US')
    {
        setlocale(LC_ALL, $locale);
        if ($timestamp === FALSE)
        {
            return ucwords(strftime('%d %B, %Y', time()));
        }
        else
        {
            return ucwords(strftime('%d %B, %Y', $timestamp));
        }
    }

    /**
     * Checks whether a given input string is a valid time definition.
     *
     * @param String $string Input String
     *
     * @return Boolean $return True if it is valid, False otherwise
     */
    public static function is_time($string)
    {
        // accepts HHH:MM:SS, e.g. 23:59:30 or 12:30 or 120:17
        if (preg_match('/^(\-)?[0-9]{1,3}(:[0-5][0-9]){1,2}$/', $string))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Checks whether a given input string is a valid date definition.
     *
     * @param String $string Input String
     *
     * @return Boolean $return True if it is a proper date String,
     *                         False otherwise
     */
    public static function is_date($string)
    {
        $feb    = '02[\- \/ \.](0[1-9]|1[0-9]|2[0-9])';
        $others = '(01|0[3-9]|1[012])[\- \/ \.](0[1-9]|[12][0-9]|3[01])';

        if (preg_match("/^(\d{1,4})[\- \/ \.]($others|$feb)$/", $string))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Compares two datetime strings and returns smaller or bigger.
     *
     * This function can be used for PHP's sorting functions.
     *
     * @param String $a DateTime String 1
     * @param String $b DateTime String 2
     *
     * @return Integer -1 if $a < $b, 1 otherwise
     */
    public static function sort_compare_datetime($a, $b)
    {
        $a = strtotime($a);
        $b = strtotime($b);

        if ($a == $b)
        {
            return 0;
        }
        else
        {
            return ($a < $b) ? -1 : 1;
        }
    }

}

?>
