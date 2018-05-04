<?php
/**
 * This file contains the PreconditionFailedException class.
 *
 * PHP Version 7.0
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
 * Exception for the Precondition Failed HTTP error (412).
 */
class PreconditionFailedException extends HttpException
{

    /**
     * Constructor.
     */
    public function __construct($message = NULL, $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::PRECONDITION_FAILED, $app_code, $previous);
    }

}

?>
