<?php

/**
 * This file contains the Console class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * The Console class provides function to immediatly
 * output strings. Though this is certainly not a usecase
 * restricted to the console environment, this is where
 * it's primary usecase lies.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Console
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Constructor.
     */
    public function __construct($datetime)
    {
        $this->datetime = $datetime;
        $this->datetime->set_datetime_format('%Y-%m-%d %H-%M-%S');
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
    }

    /**
     * Print given message immediatly.
     *
     * @param String $msg Message to print
     *
     * @return void
     */
    public function cli_print($msg)
    {
        echo $this->build_cli_output($msg);
    }

    /**
     * Print given message immediatly and break the line afterwards.
     *
     * @param String $msg Message to print
     *
     * @return void
     */
    public function cli_println($msg)
    {
        echo $this->build_cli_output($msg) . "\n";
    }

    /**
     * Generate a string to output.
     *
     * @param String $msg Message to print
     *
     * @return String $return Generated String
     */
    private function build_cli_output($msg)
    {
        return $this->datetime->get_datetime() . ': ' . $msg;
    }

    /**
     * Print status information ([ok] or [failed]).
     *
     * @param Boolean $bool Whether to print a good or bad status
     *
     * @return void
     */
    public function cli_print_status($bool)
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

}

?>
