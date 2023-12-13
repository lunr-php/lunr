<?php

/**
 * This file contains the ClientDataHttpException class.
 *
 * SPDX-FileCopyrightText: Copyright 2023 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Exceptions;

use Exception;

/**
 * Exception for a client data HTTP result.
 */
abstract class ClientDataHttpException extends HttpException
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
     * @param int            $code     Http code
     * @param int            $app_code Application error code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $code = 0, int $app_code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $app_code, $previous);
    }

    /**
     * Set input data that caused the request.
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
     * Set report data about the request.
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
     * Set report data about the request.
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
