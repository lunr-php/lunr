<?php

/**
 * This file contains the UnprocessableEntityException class.
 *
 * SPDX-FileCopyrightText: Copyright 2021 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;
use Lunr\Corona\HttpCode;
use Throwable;

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
    public function __construct(?string $message = NULL, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::UNPROCESSABLE_ENTITY, $app_code, $previous);
    }

}

?>
