<?php
/**
 * This file contains the MethodNotAllowedException class.
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
 * Exception for the Method Not Allowed HTTP error (405).
 */
class MethodNotAllowedException extends HttpException
{

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct($message = 'The used HTTP method is not supported for this resource!', $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::METHOD_NOT_ALLOWED, $app_code, $previous);
    }

}

?>
