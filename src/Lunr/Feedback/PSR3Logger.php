<?php

/**
 * Abstract Logger implementing parts of PSR-3
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

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Abstract class implementing parts of the PSR-3 standard.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class PSR3Logger implements LoggerInterface
{

    /**
     * System is unusable.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function emergency($message, array $context = array())
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function alert($message, array $context = array())
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function critical($message, array $context = array())
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /**
     * Runtime errors.
     *
     * Example: Does not require immediate action but should typically
     * be logged and monitored.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function error($message, array $context = array())
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function warning($message, array $context = array())
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /**
     * Normal but significant events.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function notice($message, array $context = array())
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function info($message, array $context = array())
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /**
     * Detailed debug information.
     *
     * @param String $message Log Message
     * @param array  $context Additional meta-information for the log
     *
     * @return void
     */
    public function debug($message, array $context = array())
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

}

?>
