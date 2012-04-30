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
 * @author     M2Mobi <info@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use MySQLi_Result;

/**
 * MySQL/MariaDB query result class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */
class MySQLQueryResult implements DatabaseQueryResultInterface
{

    /**
     * Return value from mysqli->query().
     * @var mixed
     */
    protected $result;

    /**
     * Reference to the mysqli class.
     * @var MySQLi
     */
    protected $mysqli;

    /**
     * Flag whether the query was successful or not.
     * @var Boolean
     */
    protected $success;

    /**
     * Constructor.
     *
     * @param mixed  $result  Query result
     * @param MySQLi &$mysqli Reference to the MySQLi class
     */
    public function __construct($result, &$mysqli)
    {
        if ($result instanceof MySQLi_Result)
        {
            $this->success = TRUE;
        }
        else
        {
            $this->success = $result;
        }

        $this->result =  $result;
        $this->mysqli =& $mysqli;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->mysqli = NULL;

        unset($this->result);
        unset($this->success);
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
        if (is_bool($this->result))
        {
            return $this->mysqli->affected_rows;
        }
        else
        {
            return $this->result->num_rows;
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

        if (is_bool($this->result))
        {
           return $output;
        }

        while ($row = $this->result->fetch_assoc())
        {
            $output[] = $row;
        }

        return $output;
    }

    /**
     * Get the first row of the result set.
     *
     * @return array $output First result row as array
     */
    public function result_row()
    {
        return is_bool($this->result) ? array() : $this->result->fetch_assoc();
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

        if (is_bool($this->result))
        {
           return $output;
        }

        while ($row = $this->result->fetch_assoc())
        {
            $output[] = $row[$column];
        }

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
        if (is_bool($this->result))
        {
            return NULL;
        }

        $line = $this->result->fetch_assoc();
        return isset($line[$column]) ? $line[$column] : NULL;
    }

}

?>
