<?php

/**
 * This file contains the ConflictException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;
use Lunr\Corona\HttpCode;

/**
 * Exception for the Conflict HTTP error (409).
 */
class ConflictException extends HttpException
{

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $appCode  Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $appCode = 0, ?Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::CONFLICT, $appCode, $previous);
    }

}

?>
