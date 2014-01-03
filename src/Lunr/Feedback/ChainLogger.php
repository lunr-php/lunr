<?php

/**
 * A class for chain logging messages to multiple loggers.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

use Psr\Log\LoggerInterface;

/**
 * A class for chain logging messages to multiple loggers.
 *
 * @category   Libraries
 * @package    Feedback
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class ChainLogger extends PSR3Logger
{

    /**
     * PSR-3 compliant loggers.
     * @var array
     */
    protected $loggers;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->loggers = [];

        foreach(func_get_args() as $parameter)
        {
            if ($parameter instanceof LoggerInterface)
            {
                $this->loggers[] = $parameter;
            }
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->loggers);
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
        foreach ($this->loggers as $logger)
        {
            $logger->log($level, $message, $context);
        }
    }

}

?>
