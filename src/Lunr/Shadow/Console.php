<?php

/**
 * This file contains the Console class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow;

use DateTime;

/**
 * The Console class provides function to immediately
 * output strings. Though this is certainly not a usecase
 * restricted to the console environment, this is where
 * it's primary usecase lies.
 */
class Console
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * DateTime format.
     * @var string
     */
    private $time_format;

    /**
     * Constructor.
     *
     * @param DateTime $datetime    Instance of the DateTime class.
     * @param string   $time_format Datetime pattern
     */
    public function __construct($datetime, $time_format = 'Y-m-d H:m:s')
    {
        $this->datetime    = $datetime;
        $this->time_format = $time_format;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->time_format);
        unset($this->datetime);
    }

    /**
     * Print given message immediately.
     *
     * @param string $msg Message to print
     *
     * @return void
     */
    public function cli_print($msg)
    {
        echo $this->build_cli_output($msg);
    }

    /**
     * Print given message immediately and break the line afterwards.
     *
     * @param string $msg Message to print
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
     * @param string $msg Message to print
     *
     * @return string $return Generated String
     */
    private function build_cli_output($msg)
    {
        $time_string = $this->datetime->setTimestamp(time())
                                      ->format($this->time_format);
        return $time_string . ': ' . $msg;
    }

    /**
     * Print status information ([ok] or [failed]).
     *
     * @param bool $bool Whether to print a good or bad status
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
