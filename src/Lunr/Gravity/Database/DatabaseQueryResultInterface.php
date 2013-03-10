<?php

/**
 * Database query result interface.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * Database query result interface.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface DatabaseQueryResultInterface
{

    /**
     * Check whether the query has failed or not.
     *
     * @return Boolean $return TRUE if it failed, FALSE otherwise
     */
    public function has_failed();

    /**
     * Get string description of the error, if there was one.
     *
     * @return String $message Error Message
     */
    public function error_message();

    /**
     * Get numerical error code of the error, if there was one.
     *
     * @return Integer $code Error Code
     */
    public function error_number();

    /**
     * Get autoincremented ID generated on last insert.
     *
     * @return mixed $id If the number is greater than maximal int value it's a String
     *                   otherwise an Integer
     */
    public function insert_id();

    /**
     * Get the executed query.
     *
     * @return String $query The executed query
     */
    public function query();

    /**
     * Returns the number of rows affected by the last query.
     *
     * @return mixed $number Number of rows in the result set.
     */
    public function affected_rows();

    /**
     * Returns the number of rows in the result set.
     *
     * @return mixed $number Number of rows in the result set.
     */
    public function number_of_rows();

    /**
     * Get the entire result set as an array.
     *
     * @return array $output Result set as array
     */
    public function result_array();

    /**
     * Get the first row of the result set.
     *
     * @return array $output First result row as array
     */
    public function result_row();

    /**
     * Get a specific column of the result set.
     *
     * @param String $column Column or Alias name
     *
     * @return array $output Result column as array
     */
    public function result_column($column);

    /**
     * Get a specific column of the first row of the result set.
     *
     * @param String $column Column or Alias name
     *
     * @return mixed $output NULL if it does not exist, the value otherwise
     */
    public function result_cell($column);

}

?>
