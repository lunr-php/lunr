<?php
/**
 * This file contains the MockUncaughtException class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2022, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests\Helpers;

use \Exception;

/**
 * Mock uncaught exception.
 */
class MockUncaughtException extends Exception
{

    /**
     * Constructor.
     *
     * @param ?string    $message  The exception message
     * @param int        $code     The exception code
     * @param \Exception $previous The previously thrown exception
     */
    public function __construct($message = NULL, $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }

    /**
     * Set name for the file the exception was thrown in.
     *
     * @param string $file File name
     *
     * @return void
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Set line number the exception was thrown in.
     *
     * @param int $line Line number
     *
     * @return void
     */
    public function setLine($line)
    {
        $this->line = $line;
    }

}

?>
