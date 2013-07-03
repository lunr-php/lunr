<?php

/**
 * PHP Error/Notice logging class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

use Psr\Log\LogLevel;

/**
 * Class for logging messages as PHP errors/notices.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class PHPLogger extends PSR3Logger
{

    /**
     * Reference to the Request class.
     * @var Request
     */
    protected $request;

    /**
     * Constructor.
     *
     * @param Request $request Reference to the Request class.
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->request);
    }

    /**
     * Compose message string.
     *
     * @param String $message Base message with placeholders
     * @param array  $context Additional meta-information for the log
     *
     * @return String $msg Log Message String
     */
    protected function compose_message($message, $context)
    {
        if ($this->request->call != NULL)
        {
            $infix = $this->request->call . ': ';
        }
        else
        {
            $infix = '';
        }

        if (!empty($context['file']) && !empty($context['line']))
        {
            $suffix = ' (' . $context['file'] . ': ' . $context['line'] . ')';
        }
        else
        {
            $suffix = '';
        }

        return $infix . $this->interpolate_message($message, $context) . $suffix;
    }

    /**
     * Replace placeholders in log message according to PSR-3.
     *
     * @param String $message Base message with placeholders
     * @param array  $context Additional meta-information for the log
     *
     * @return String $message Interpolated message
     */
    protected function interpolate_message($message, $context)
    {
        $replace = array();

        foreach ($context as $key => $val)
        {
            $replace['{' . $key . '}'] = $val;
        }

        return strtr($message, $replace);
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
        switch ($level)
        {
            case LogLevel::EMERGENCY:
            case LogLevel::ALERT:
            case LogLevel::CRITICAL:
            case LogLevel::ERROR:
                $error_level = E_USER_ERROR;
                break;
            case LogLevel::WARNING:
                $error_level = E_USER_WARNING;
                break;
            case LogLevel::NOTICE:
            case LogLevel::INFO:
            case LogLevel::DEBUG:
            default:
                $error_level = E_USER_NOTICE;
                break;
        }

        $message = (string) $message;
        $msg     = $this->compose_message($message, $context);

        trigger_error($msg, $error_level);
    }

}

?>
