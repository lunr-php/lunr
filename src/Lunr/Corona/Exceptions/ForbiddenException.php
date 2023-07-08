<?php

/**
 * This file contains the ForbiddenException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Lunr\Corona\HttpCode;
use Exception;

/**
 * Exception for the Forbidden HTTP error (403).
 */
class ForbiddenException extends HttpException
{

    /**
     * Input data key.
     * @var string
     */
    protected string $key;

    /**
     * Input data value
     * @var mixed
     */
    protected $value;

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::FORBIDDEN, $app_code, $previous);
    }

    /**
     * Set input data that caused the forbidden request.
     *
     * @param string $key   Key/URL parameter name
     * @param mixed  $value Input value
     *
     * @return void
     */
    public function setData(string $key, $value): void
    {
        $this->key   = $key;
        $this->value = $value;
    }

    /**
     * Get the input data key.
     *
     * @return string Input data key
     */
    public function getDataKey(): string
    {
        return $this->key;
    }

    /**
     * Get the input data value.
     *
     * @return mixed Input data value
     */
    public function getDataValue()
    {
        return $this->value;
    }

    /**
     * Check whether input data was set or not.
     *
     * @return bool Input data was set or not.
     */
    public function isDataAvailable(): bool
    {
        return isset($this->key);
    }

}

?>
