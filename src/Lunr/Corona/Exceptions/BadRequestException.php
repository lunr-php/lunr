<?php

/**
 * This file contains the BadRequestException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Lunr\Corona\HttpCode;
use Exception;

/**
 * Exception for the Bad Request HTTP error (400).
 */
class BadRequestException extends HttpException
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
     * Report data
     * @var string
     */
    protected string $report;

    /**
     * Constructor.
     *
     * @param string|null    $message  Error message
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, HttpCode::BAD_REQUEST, $app_code, $previous);
    }

    /**
     * Set input data that caused the bad request.
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
     * Set report data about the bad request.
     *
     * @param string $data Report data
     *
     * @return void
     */
    public function setReport(string $data): void
    {
        if ($data === '')
        {
            return;
        }

        $this->report = $data;
    }

    /**
     * Set report data about the bad request.
     *
     * @param array $failures Failure messages per key
     *
     * @return void
     */
    public function setArrayReport(array $failures): void
    {
        if ($failures === [])
        {
            return;
        }

        $this->report = '';

        foreach ($failures as $key => $messages)
        {
            foreach ($messages as $message)
            {
                $this->report .= "$key: $message\n";
            }
        }
    }

    /**
     * Get the input data key.
     *
     * @return string|null Input data key
     */
    public function getDataKey(): ?string
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
     * Get the detailed input data report.
     *
     * @return string Detailed input data report
     */
    public function getReport(): ?string
    {
        return $this->report;
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

    /**
     * Check whether a detailed input data report was set or not.
     *
     * @return bool Input data report was set or not.
     */
    public function isReportAvailable(): bool
    {
        return isset($this->report);
    }

}

?>
