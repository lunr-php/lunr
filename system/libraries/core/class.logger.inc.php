<?php

/**
 * Error/Notice logging class.
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
 * Class for logging errors or notices.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class Logger
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Reference to the Request class.
     * @var Request
     */
    private $request;

    /**
     * Constructor.
     *
     * @param DateTime $datetime Instance of the DateTime class.
     * @param Request  &$request Reference to the Request class.
     */
    public function __construct($datetime, &$request)
    {
        $this->datetime = $datetime;
        $this->datetime->set_datetime_format('%Y-%m-%d %H:%M:%S');

        $this->request =& $request;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
        $this->request = NULL;
    }

    /**
     * Construct an error message according to the input.
     *
     * @param String $info The error string that should be printed
     *
     * @return array $msg The error message, once with prefix, and once without
     */
    private function construct_error_message($info)
    {
        $prefix = '[' . $this->datetime->get_datetime() . ']: ';

        if (($this->request->controller != NULL) && ($this->request->method != NULL))
        {
            $infix = $this->request->controller . '/' . $this->request->method . ': ';
        }
        else
        {
            $infix = '';
        }

        $msg = array();
        $msg[0] = $infix . $info;
        $msg[1] = $prefix . $msg[0];

        return $msg;
    }

    /**
     * Trigger a PHP warning.
     *
     * @param String $info The error string that should be printed
     * @param String $file The log file the error should be logged to (optional)
     *
     * @return void
     */
    public function log_error($info, $file = '')
    {
        $msg = $this->construct_error_message($info);

        if ($file == '')
        {
            trigger_error($msg[0], E_USER_WARNING);
        }
        else
        {
            if (function_exists('xdebug_print_function_stack') === TRUE)
            {
                xdebug_print_function_stack($msg[0]);
            }
            error_log($msg[1], 3, $file);
        }
    }

    /**
     * Trigger a PHP warning (with linebreak at the end).
     *
     * @param String $info The error string that should be printed
     * @param String $file The log file the error should be logged to (optional)
     *
     * @return void
     */
    public function log_errorln($info, $file = '')
    {
        $this->log_error($info . "\n", $file);
    }

}

?>