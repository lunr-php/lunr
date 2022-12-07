<?php
/**
 * This file contains the RequestedRangeNotSatisfiableException class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions;

use \Lunr\Corona\HttpCode;
use \Exception;

/**
 * Exception for the Requested Range Not Satisfiable HTTP error (416).
 */
class RequestedRangeNotSatisfiableException extends HttpException
{

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::REQUESTED_RANGE_NOT_SATISFIABLE, $app_code, $previous);
    }

}

?>
