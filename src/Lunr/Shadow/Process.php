<?php

/**
 * This file contains the Process class, which contains helper
 * methods to handle external processes or ease script-internal
 * process handling.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2010-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow;

/**
 * Process control class
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Process
{

    /**
     * Run a system command from inside PHP.
     *
     * @param String  $cmd            The command to run
     * @param String  $out            The location where output should
     *                                be redirected too
     * @param Boolean $append         Whether to append to the output
     *                                location, or to replace it
     * @param Boolean $error_redirect Whether to redirect STDERR to STDOUT
     *
     * @return String $return Last line of the STDOUT output of the command
     */
    public static function run($cmd, $out = '', $append = FALSE, $error_redirect = TRUE)
    {
        if ($error_redirect === TRUE)
        {
            $cmd .= ' 2>&1';
        }

        if ($out != '')
        {
            if ($append === TRUE)
            {
                $cmd .= " >> $out";
            }
            else
            {
                $cmd .= " > $out";
            }
        }

        return exec($cmd);
    }

    /**
     * Run a system command from inside PHP in background.
     *
     * @param String  $cmd            The command to run
     * @param String  $out            The location where output should
     *                                be redirected too
     * @param Boolean $append         Whether to append to the output
     *                                location, or to replace it
     * @param Boolean $error_redirect Whether to redirect STDERR to STDOUT
     *
     * @return void
     */
    public static function run_bg($cmd, $out = '', $append = FALSE, $error_redirect = TRUE)
    {
        if ($out == '')
        {
            $out = '/dev/null';
        }

        if (($append === TRUE) && ($out != '/dev/null'))
        {
            $cmd .= " >> $out";
        }
        elseif ($error_redirect === TRUE)
        {
            $cmd .= " 1 > $out";
            $cmd .= " 2 > $out";
        }
        else
        {
            $cmd .= " > $out";
        }

        // run in background
        $cmd .= ' &';

        exec($cmd);
    }

    /**
     * Start multiple parallel child processes.
     *
     * WARNING: make sure to not reuse an already existing DB-Connection
     * established by the parent in the children. Best would be to not
     * establish a DB-Connection in the parent at all.
     * WARNING: Do NOT use this for a web process!!!!
     *
     * @param Integer $number Amount of child processes to start
     * @param Mixed   $call   The call that should be executed by the child
     *                        processes either "function" or
     *                        "array('class','method')"
     * @param Array   &$data  Prepared array of data to be processed by the
     *                        child processes this array should be size() =
     *                        $number
     *
     * @return Mixed $result Either false if run out of CLI context or an
     *                       array of child process statuses
     */
    public static function fork($number, $call, &$data)
    {
        global $cli;
        if ($cli)
        {
            for($i = 0; $i < $number; ++$i)
            {
                $pids[$i] = pcntl_fork();

                if(!$pids[$i])
                {
                    // child process
                    if (is_array($data[$i]))
                    {
                        call_user_func_array($call, $data[$i]);
                    }
                    elseif (is_object($data[$i])
                        && ($data[$i] instanceof \SplFixedArray))
                    {
                        call_user_func_array($call, $data[$i]->toArray());
                    }
                    else
                    {
                        call_user_func($call, $data[$i]);
                    }

                    exit();
                }
            }

            $result = new \SplFixedArray($number);

            for($i = 0; $i < $number; ++$i)
            {
                pcntl_waitpid($pids[$i], $status, WUNTRACED);
                $result[$i] = $status;
            }

            return $result;
        }
        else
        {
            return FALSE;
        }
    }

}

?>
