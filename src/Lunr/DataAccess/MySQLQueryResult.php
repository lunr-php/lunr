<?php

/**
 * MySQL query result class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess;

use \MySQLi_Result;

/**
 * MySQL/MariaDB query result class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MySQLQueryResult implements DatabaseQueryResultInterface
{

    /**
     * The query string that was executed.
     * @var String
     */
    protected $query;

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
     * @param String  $query  Executed query
     * @param mixed   $result Query result
     * @param MySQLi  $mysqli Shared instance of the MySQLi class
     * @param Boolean $async  Whether this query was run asynchronous or not
     */
    public function __construct($query, $result, $mysqli, $async = FALSE)
    {
        if (is_object($result))
        {
            $this->success  = TRUE;
            $this->freed    = FALSE;
        }
        else
        {
            $this->success = $result;
            $this->freed   = TRUE;
        }

        $this->result = $result;
        $this->mysqli = $mysqli;
        $this->query  = $query;

        if ($async === FALSE)
        {
            $this->error_message = $mysqli->error;
            $this->error_number  = $mysqli->errno;
            $this->insert_id     = $mysqli->insert_id;
            $this->affected_rows = $mysqli->affected_rows;
            $this->num_rows      = is_object($this->result) ? $this->result->num_rows : $this->affected_rows;
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
     * @return Boolean $return TRUE if it failed, FALSE otherwise
     */
    public function has_failed()
    {
        return !$this->success;
    }

    /**
     * Get string description of the error, if there was one.
     *
     * @return String $message Error Message
     */
    public function error_message()
    {
        return $this->error_message;
    }

    /**
     * Get numerical error code of the error, if there was one.
     *
     * @return Integer $code Error Code
     */
    public function error_number()
    {
        return $this->error_number;
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
     * @return String $query The executed query
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
     * @return array $output Result set as array
     */
    public function result_array()
    {
        $output = array();

        if (!is_object($this->result))
        {
            return $output;
        }

        while ($row = $this->result->fetch_assoc())
        {
            $output[] = $row;
        }

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
        $output = is_object($this->result) ? $this->result->fetch_assoc() : array();

        $this->free_result();

        return $output;
    }

    /**
     * Get a specific column of the result set.
     *
     * @param String $column Column or Alias name
     *
     * @return array $output Result column as array
     */
    public function result_column($column)
    {
        $output = array();

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
     * @param String $column Column or Alias name
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

}

?>
