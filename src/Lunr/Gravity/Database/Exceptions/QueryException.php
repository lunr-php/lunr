<?php
/**
 * This file contains the QueryException class.
 *
 * @package   Lunr\Gravity\Database\Exceptions
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Exceptions;

/**
 * Exception for a database query error.
 */
class QueryException extends DatabaseException
{

    /**
     * SQL query triggering the error.
     * @var string
     */
    private $query;

    /**
     * Numerical error code for the error from the database system.
     * @var int
     */
    private $database_error_code;

    /**
     * Error message from the database system.
     * @var string
     */
    private $database_error_message;

    /**
     * Constructor.
     *
     * @param \Lunr\Gravity\Database\DatabaseQueryResultInterface $query_result The query result class
     * @param string                                              $message      The exception message
     */
    public function __construct($query_result, $message = NULL)
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
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * Gets the SQL query triggering the error.
     *
     * @return string SQL query
     */
    final public function getQuery()
    {
        return $this->query;
    }

    /**
     * Gets the database error code for the error.
     *
     * @return int Error code
     */
    final public function getDatabaseErrorCode()
    {
        return $this->database_error_code;
    }

    /**
     * Gets the database error message for the error.
     *
     * @return string Error message
     */
    final public function getDatabaseErrorMessage()
    {
        return $this->database_error_message;
    }

}

?>
