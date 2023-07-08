<?php

/**
 * This file contains the RequestedRangeNotSatisfiableException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Lunr\Corona\HttpCode;
use Exception;

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
    public function __construct(?string $message = NULL, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::REQUESTED_RANGE_NOT_SATISFIABLE, $app_code, $previous);
    }

}

?>
