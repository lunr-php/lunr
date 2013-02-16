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

use MySQLi_Result;

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
     * Constructor.
     *
     * @param mixed  $result Query result
     * @param MySQLi $mysqli Shared instance of the MySQLi class
     */
    public function __construct($result, $mysqli)
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

        $this->result = $result;
        $this->mysqli = $mysqli;
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
     * Returns the number of rows affected by the last query.
     *
     * @return mixed $number Number of rows in the result set.
     *                       This is usually an integer, unless the number is > MAXINT.
     *                       Then it is a string.
     */
    public function affected_rows()
    {
        return $this->mysqli->affected_rows;
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
        if (is_object($this->result))
        {
            return $this->result->num_rows;
        }
        else
        {
            return $this->mysqli->affected_rows;
        }
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
