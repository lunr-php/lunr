<?php

/**
 * A class for logging messages to the command line.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Feedback
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Feedback;

/**
 * A class for logging messages to the command line.
 */
class ConsoleLogger extends AbstractLogger
{

    /**
     * Shared instance of the Console class.
     * @var \Lunr\Shadow\Console
     */
    protected $console;

    /**
     * Constructor.
     *
     * @param \Lunr\Corona\RequestInterface $request Shared instance of the Request class.
     * @param \Lunr\Shadow\Console          $console Shared instance of the Console class.
     */
    public function __construct($request, $console)
    {
        parent::__construct($request);

        $this->console = $console;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->console);

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
        $message = strtoupper($level) . ': ' . (string) $message;
        $msg     = $this->compose_message($message, $context);

        $this->console->cli_println($msg);
    }

}

?>
