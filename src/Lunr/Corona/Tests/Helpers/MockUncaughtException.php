<?php

/**
 * This file contains the MockUncaughtException class.
 *
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests\Helpers;

use Exception;

/**
 * Mock uncaught exception.
 */
class MockUncaughtException extends Exception
{

    /**
     * Constructor.
     *
     * @param string|null    $message  The exception message
     * @param int            $code     The exception code
     * @param Exception|null $previous The previously thrown exception
     */
    public function __construct(?string $message = NULL, int $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message ?? '', $code, $previous);
    }

    /**
     * Set name for the file the exception was thrown in.
     *
     * @param string $file File name
     *
     * @return void
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    /**
     * Set line number the exception was thrown in.
     *
     * @param int $line Line number
     *
     * @return void
     */
    public function setLine(int $line): void
    {
        $this->line = $line;
    }

}

?>
