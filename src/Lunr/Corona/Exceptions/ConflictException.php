<?php
/**
 * This file contains the ConflictException class.
 *
 * PHP Version 7.0
 *
 * @package   Lunr\Corona\Exceptions
 * @author    Damien Tardy-Panis <damien@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Exceptions;

use \Lunr\Corona\HttpCode;
use \Exception;

/**
 * Exception for the Conflict HTTP error (409).
 */
class ConflictException extends HttpException
{

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::CONFLICT, $app_code, $previous);
    }

}

?>
