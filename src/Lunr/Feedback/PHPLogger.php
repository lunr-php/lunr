<?php

/**
 * PHP Error/Notice logging class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

use Psr\Log\LogLevel;

/**
 * Class for logging messages as PHP errors/notices.
 */
class PHPLogger extends AbstractLogger
{

    /**
     * Constructor.
     *
     * @param RequestInterface $request Reference to the Request class.
     */
    public function __construct($request)
    {
        parent::__construct($request);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
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
