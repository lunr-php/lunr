<?php

/**
 * MySQL asynchronous query result class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use \MySQLi_Result;

/**
 * MySQL/MariaDB asynchronous query result class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MySQLAsyncQueryResult extends MySQLQueryResult
{

    /**
     * Flag whether the result was fetched or not.
     * @var Boolean
     */
    protected $fetched;

    /**
     * Constructor.
     *
     * @param String $query  Executed query
     * @param MySQLi $mysqli Shared instance of the MySQLi class
     */
    public function __construct($query, $mysqli)
    {
        parent::__construct($query, FALSE, $mysqli, TRUE);
        $this->fetched = FALSE;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->fetched);

        parent::__destruct();
    }

    /**
     * Retrieve results for an asynchronous query.
     *
     * @return void
     */
    protected function fetch_result()
    {
        if ($this->fetched === TRUE)
        {
            return;
        }

        $this->result = $this->mysqli->reap_async_query();

        if (is_object($this->result))
        {
            $this->success = TRUE;
            $this->freed   = FALSE;
        }
        else
        {
            $this->success = $this->result;
            $this->freed   = TRUE;
        }

        $this->fetched = TRUE;

        $this->error_message = $this->mysqli->error;
        $this->error_number  = $this->mysqli->errno;
        $this->insert_id     = $this->mysqli->insert_id;
        $this->affected_rows = $this->mysqli->affected_rows;
        $this->num_rows      = is_object($this->result) ? $this->result->num_rows : $this->affected_rows;
    }

    /**
     * Check whether the query has failed or not.
     *
     * @return Boolean $return TRUE if it failed, FALSE otherwise
     */
    public function has_failed()
    {
        $this->fetch_result();
        return parent::has_failed();
    }

    /**
     * Get string description of the error, if there was one.
     *
     * @return String $message Error Message
     */
    public function error_message()
    {
        $this->fetch_result();
        return parent::error_message();
    }

    /**
     * Get numerical error code of the error, if there was one.
     *
     * @return Integer $code Error Code
     */
    public function error_number()
    {
        $this->fetch_result();
        return parent::error_number();
    }

    /**
     * Get autoincremented ID generated on last insert.
     *
     * @return mixed $id If the number is greater than maximal int value it's a String
     *                   otherwise an Integer
     */
    public function insert_id()
    {
        $this->fetch_result();
        return parent::insert_id();
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
        $this->fetch_result();
        return parent::affected_rows();
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
        $this->fetch_result();
        return parent::number_of_rows();
    }

    /**
     * Get the entire result set as an array.
     *
     * @return array $output Result set as array
     */
    public function result_array()
    {
        $this->fetch_result();
        return parent::result_array();
    }

    /**
     * Get the first row of the result set.
     *
     * @return array $output First result row as array
     */
    public function result_row()
    {
        $this->fetch_result();
        return parent::result_row();
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
        $this->fetch_result();
        return parent::result_column($column);
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
        $this->fetch_result();
        return parent::result_cell($column);
    }

}

?>
