<?php

/**
 * This file contains the MethodNotAllowedException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;
use Lunr\Corona\HttpCode;

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
    public function __construct(
        string $message = 'The used HTTP method is not supported for this resource!',
        int $app_code = 0,
        Exception $previous = NULL
    )
    {
        parent::__construct($message, HttpCode::METHOD_NOT_ALLOWED, $app_code, $previous);
    }

}

?>
