<?php

/**
 * This file contains the TemporarilyDisabledException class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;

/**
 * Exception for the Temporarily Disabled HTTP error (540).
 */
class TemporarilyDisabledException extends HttpException
{

    /**
     * Constructor.
     *
     * @param string         $message  Error message
     * @param int            $appCode  Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(string $message = 'The requested API is temporarily disabled', int $appCode = 0, ?Exception $previous = NULL)
    {
        parent::__construct($message, 540, $appCode, $previous);
    }

}

?>
