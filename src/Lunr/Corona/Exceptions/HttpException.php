<?php
/**
 * This file contains the HttpException class.
 *
 * PHP Version 7.0
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions;

use \Exception;

/**
 * Exception for an HTTP result.
 */
class HttpException extends Exception
{

    /**
     * Application error code.
     * @var int
     */
    protected $app_code;

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $code = 0, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);

        $this->app_code = $app_code !== 0 ? $app_code : $code;
    }

    /**
     * Gets the application error code.
     *
     * @return int application error code
     */
    final public function getAppCode()
    {
        return $this->app_code;
    }
}

?>
