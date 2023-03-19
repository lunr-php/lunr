<?php
/**
 * This file contains the QueryException class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Exceptions;

use Lunr\Gravity\Database\DatabaseQueryResultInterface;

/**
 * Exception for a database query error.
 */
class QueryException extends DatabaseException
{

    /**
     * SQL query triggering the error.
     * @var string
     */
    private string $query;

    /**
     * Numerical error code for the error from the database system.
     * @var int
     */
    private int $database_error_code;

    /**
     * Error message from the database system.
     * @var string
     */
    private string $database_error_message;

    /**
     * Constructor.
     *
     * @param DatabaseQueryResultInterface $query_result The query result class
     * @param string                       $message      The exception message
     */
    public function __construct(DatabaseQueryResultInterface $query_result, string $message = 'Query Exception!')
    {
        $this->query = $query_result->query();

        $this->database_error_code    = $query_result->error_number();
        $this->database_error_message = $query_result->error_message();

        parent::__construct($message);
    }

    /**
     * Set a more specific error message for the exception.
     *
     * @param string $message Error message
     *
     * @return void
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * Gets the SQL query triggering the error.
     *
     * @return string SQL query
     */
    final public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * Gets the database error code for the error.
     *
     * @return int Error code
     */
    final public function getDatabaseErrorCode(): int
    {
        return $this->database_error_code;
    }

    /**
     * Gets the database error message for the error.
     *
     * @return string Error message
     */
    final public function getDatabaseErrorMessage(): string
    {
        return $this->database_error_message;
    }

}

?>
