<?php

/**
 * File logging class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

/**
 * Class for logging messages in files.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class FileLogger extends PHPLogger
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Filename of the logfile.
     * @var String
     */
    private $filename;

    /**
     * Constructor.
     *
     * @param String           $filename Filename of the target log-file.
     * @param DateTime         $datetime Instance of the DateTime class.
     * @param RequestInterface $request  Reference to the Request class.
     */
    public function __construct($filename, $datetime, $request)
    {
        parent::__construct($request);
        $this->datetime = $datetime;
        $this->datetime->set_datetime_format('%Y-%m-%d %H:%M:%S');
        $this->filename = $filename;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
        unset($this->filename);
        parent::__destruct();
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed  $level   Log level (severity)
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function log($level, $message, array $context = array())
    {
        $prefix = '[' . $this->datetime->get_datetime() . ']: ';

        $message = strtoupper($level) . ': ' . (string) $message;
        $msg     = $this->compose_message($message, $context);

        if (function_exists('xdebug_print_function_stack') === TRUE)
        {
            xdebug_print_function_stack($msg);
        }

        error_log($prefix . $msg . "\n", 3, $this->filename);
    }

}

?>
