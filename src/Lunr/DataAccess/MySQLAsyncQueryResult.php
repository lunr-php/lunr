<?php

/**
 * MySQL asynchronous query result class.
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
 * MySQL/MariaDB asynchronous query result class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
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
     * @param MySQLi $mysqli Shared instance of the MySQLi class
     */
    public function __construct($mysqli)
    {
        parent::__construct(FALSE, $mysqli);
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
