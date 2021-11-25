<?php
/**
 * This file contains the UnprocessableEntityException class.
 *
 * @package   Lunr\Corona\Exceptions
 * @author    David Mendes <d.mendes@m2mobi.com>
 * @copyright 2021, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions;

use \Lunr\Corona\HttpCode;
use \Exception;

/**
 * Exception for the Unprocessable Entity HTTP error (422).
 */
class UnprocessableEntityException extends HttpException
{

    /**
     * Constructor.
     *
     * @param string|null    $message  The Exception message to throw.
     * @param int            $app_code The Exception code.
     * @param Exception|null $previous The previous exception used for the exception chaining.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::UNPROCESSABLE_ENTITY, $app_code, $previous);
    }

}

?>
