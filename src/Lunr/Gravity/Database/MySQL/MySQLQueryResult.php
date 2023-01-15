<?php

/**
 * MySQL query result class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseQueryResultInterface;
use MySQLi;
use MySQLi_Result;

/**
 * MySQL/MariaDB query result class.
 */
class MySQLQueryResult implements DatabaseQueryResultInterface
{
    /**
     * The MySQL error code for transaction deadlock.
     * @var Integer
     */
    private const DEADLOCK_ERR_CODE = 1213;

    /**
     * The MySQL error code for transaction lock timeout.
     * @var Integer
     */
    private const LOCK_TIMEOUT_ERR_CODE = 1205;

    /**
     * The query string that was executed.
     * @var String
     */
    protected $query;

    /**
     * The canonicalized query string that was executed.
     * @var String
     */
    protected $canonical_query;

    /**
     * Return value from mysqli->query().
     * @var mixed
     */
    protected $result;

    /**
     * Shared instance of the mysqli class.
     * @var MySQLi
     */
    protected $mysqli;

    /**
     * Flag whether the query was successful or not.
     * @var Boolean
     */
    protected $success;

    /**
     * Flag whether the memory has been freed or not.
     * @var Boolean
     */
    protected $freed;

    /**
     * Description of the error.
     * @var String
     */
    protected $error_message;

    /**
     * Error code.
     * @var Integer
     */
    protected $error_number;

    /**
     * Warnings from Mysqli or NULL if no warnings
     * @var ?array
     */
    protected $warnings;

    /**
     * Autoincremented ID generated on last insert.
     * @var mixed
     */
    protected $insert_id;

    /**
     * Number of affected rows.
     * @var Integer
     */
    protected $affected_rows;

    /**
     * Number of rows in the result set.
     * @var Integer
     */
    protected $num_rows;

    /**
     * Constructor.
     *
     * @param string $query  Executed query
     * @param mixed  $result Query result
     * @param MySQLi $mysqli Shared instance of the MySQLi class
     * @param bool   $async  Whether this query was run asynchronous or not
     */
    public function __construct($query, $result, $mysqli, $async = FALSE)
    {
        if (is_object($result))
        {
            $this->success = TRUE;
            $this->freed   = FALSE;
        }
        else
        {
            $this->success = $result;
            $this->freed   = TRUE;
        }

        $this->result          = $result;
        $this->mysqli          = $mysqli;
        $this->query           = $query;
        $this->canonical_query = NULL;

        if ($async === FALSE)
        {
            $this->error_message = $mysqli->error;
            $this->error_number  = $mysqli->errno;
            $this->insert_id     = $mysqli->insert_id;
            $this->affected_rows = mysqli_affected_rows($mysqli);
            $this->num_rows      = is_object($this->result) ? mysqli_num_rows($result) : $this->affected_rows;

            $this->set_warnings();
        }
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->free_result();

        unset($this->mysqli);
        unset($this->result);
        unset($this->success);
        unset($this->freed);
        unset($this->error_message);
        unset($this->error_number);
        unset($this->insert_id);
        unset($this->query);
        unset($this->warnings);
        unset($this->canonical_query);
    }

    /**
     * Free memory associated with a result.
     *
     * @return void
     */
    protected function free_result()
    {
        if ($this->freed === FALSE)
        {
            $this->result->free();
            $this->freed = TRUE;
        }
    }

    /**
     * Check whether the query has failed or not.
     *
     * @return bool $return TRUE if it failed, FALSE otherwise
     */
    public function has_failed()
    {
        return !$this->success;
    }

    /**
     * Check whether the query has a deadlock or not.
     *
     * @return bool $return TRUE if it failed, FALSE otherwise
     */
    public function has_deadlock()
    {
        return ($this->error_number == self::DEADLOCK_ERR_CODE) ? TRUE : FALSE;
    }

    /**
     * Check whether the query has a lock timeout or not.
     *
     * @return bool the timeout lock status for the query
     */
    public function has_lock_timeout()
    {
        return $this->error_number == self::LOCK_TIMEOUT_ERR_CODE;
    }

    /**
     * Get string description of the error, if there was one.
     *
     * @return string $message Error Message
     */
    public function error_message()
    {
        return $this->error_message;
    }

    /**
     * Get numerical error code of the error, if there was one.
     *
     * @return int $code Error Code
     */
    public function error_number()
    {
        return $this->error_number;
    }

    /**
     * Get array of mysqli_warning, if there are any
     *
     * @return ?array $warnings If there are warnings it's an array of mysqli_warning
     *                         otherwise its NULL
     */
    public function warnings()
    {
        return $this->warnings;
    }

    /**
     * Set the warnings property
     *
     * @return void
     */
    protected function set_warnings()
    {
        $mysqli_warnings = $this->mysqli->get_warnings();

        if ($mysqli_warnings == FALSE)
        {
            $this->warnings = NULL;
            return;
        }

        do
        {
            $warning['message']  = $mysqli_warnings->message;
            $warning['sqlstate'] = $mysqli_warnings->sqlstate;
            $warning['errno']    = $mysqli_warnings->errno;

            $this->warnings[] = $warning;
        }
        while ($mysqli_warnings->next());
    }

    /**
     * Get autoincremented ID generated on last insert.
     *
     * @return mixed $id If the number is greater than maximal int value it's a String
     *                   otherwise an Integer
     */
    public function insert_id()
    {
        return $this->insert_id;
    }

    /**
     * Get the executed query.
     *
     * @return string $query The executed query
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * Returns the number of rows affected by the last query.
     *
     * @return mixed $number Number of rows in the result set.
     *                       This is usually an integer, unless the number is > MAXINT.
     *                       Then it is a string.
     */
    public function affected_rows()
    {
        return $this->affected_rows;
    }

    /**
     * Returns the number of rows in the result set.
     *
     * @return mixed $number Number of rows in the result set.
     *                       This is usually an integer, unless the number is > MAXINT.
     *                       Then it is a string.
     */
    public function number_of_rows()
    {
        return $this->num_rows;
    }

    /**
     * Get the entire result set as an array.
     *
     * @param bool $associative TRUE for returning rows as associative arrays,
     *                          FALSE for returning rows as enumerated arrays
     *
     * @return array $output Result set as array
     */
    public function result_array($associative = TRUE)
    {
        $output = [];

        $return_type = $associative ? MYSQLI_ASSOC : MYSQLI_NUM;

        if (!is_object($this->result))
        {
            return $output;
        }

        $output = $this->result->fetch_all($return_type);

        $this->free_result();

        return $output;
    }

    /**
     * Get the first row of the result set.
     *
     * @return array $output First result row as array
     */
    public function result_row()
    {
        $output = is_object($this->result) ? $this->result->fetch_assoc() : [];

        $this->free_result();

        return $output;
    }

    /**
     * Get a specific column of the result set.
     *
     * @param string $column Column or Alias name
     *
     * @return array $output Result column as array
     */
    public function result_column($column)
    {
        $output = [];

        if (!is_object($this->result))
        {
            return $output;
        }

        while ($row = $this->result->fetch_assoc())
        {
            $output[] = $row[$column];
        }

        $this->free_result();

        return $output;
    }

    /**
     * Get a specific column of the first row of the result set.
     *
     * @param string $column Column or Alias name
     *
     * @return mixed $output NULL if it does not exist, the value otherwise
     */
    public function result_cell($column)
    {
        if (!is_object($this->result))
        {
            return NULL;
        }

        $line = $this->result->fetch_assoc();

        $this->free_result();

        return isset($line[$column]) ? $line[$column] : NULL;
    }

    /**
     * Get the executed query canonicalized.
     *
     * @return string $canonicalized_query The executed query canonicalized
     */
    public function canonical_query(): string
    {
        if ($this->canonical_query !== NULL)
        {
            return $this->canonical_query;
        }

        $this->canonical_query = new MySQLCanonicalQuery($this->query());

        return $this->canonical_query;
    }

}

?>
