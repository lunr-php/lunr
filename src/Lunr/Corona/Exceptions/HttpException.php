<?php

/**
 * This file contains the HttpException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;

/**
 * Exception for an HTTP result.
 */
class HttpException extends Exception
{

    /**
     * Application error code.
     * @var int
     */
    protected int $app_code;

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $code     Http code
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $code = 0, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message ?? '', $code, $previous);

        $this->app_code = $app_code !== 0 ? $app_code : $code;
    }

    /**
     * Gets the application error code.
     *
     * @return int application error code
     */
    final public function getAppCode(): int
    {
        return $this->app_code;
    }

}

?>
