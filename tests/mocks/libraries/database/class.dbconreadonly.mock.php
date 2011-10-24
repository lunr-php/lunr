<?php

/**
 * This file contains a Mock class for Lunr's DBCon Class
 * used by the Unit tests.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Mocks\Libraries\Database;
use Lunr\Libraries\Database\DBCon;

/**
 * DBCon Mock class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockDBConReadonly extends DBCon
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct(TRUE);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Establishes a connection to the defined database-server.
     *
     * @return void
     */
    public function connect()
    {
        return;
    }

    /**
     * Disconnects from database-server.
     *
     * @return void
     */
    public function disconnect()
    {
        return;
    }

    /**
     * Returns last database error.
     *
     * @return String Error message
     */
    public function last_error()
    {
        return '';
    }

    /**
     * Returns last database error number.
     *
     * @return Integer Error number
     */
    public function last_error_number()
    {
        return 0;
    }

    /**
     * Returns the last executed query.
     *
     * @return String SQL Query
     */
    public function last_query()
    {
        return '';
    }

    /**
     * Returns the id given for the last insert statement.
     *
     * @return Mixed Insert ID
     */
    public function last_id()
    {
        return '';
    }

    /**
     * Get the calculated amount of total rows for the last executed query.
     *
     * @return mixed $return The amount of rows on success, False on failure
     */
    public function found_rows()
    {
        return 0;
    }

    /**
     * Executes a defined SQL query.
     *
     * @param String  $sql_command Predefined SQL query
     * @param Boolean $return      Return a Query Result
     *
     * @return Mixed $result Query Result, TRUE on successful query or
     *                       FALSE on connection failure/failed query
     */
    public function query($sql_command, $return = TRUE)
    {
        return FALSE;
    }

    /**
     * Execute the defined SQL query and return the result set.
     *
     * @param String $from Where to get the data from
     *
     * @return Query Query result, or False on connection failure
     */
    public function get($from)
    {
        return FALSE;
    }

    /**
     * Define a SELECT statement.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public function select($select, $escape = TRUE)
    {
        return;
    }

    /**
     * Select columns as hex values.
     *
     * If no column name is specified the original column name minus
     * the surrounding HEX() is taken.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public function select_hex($select, $escape = TRUE)
    {
        return;
    }

    /**
     * Define a special SELECT statement.
     *
     * WARNING: This overwrites previously defined select criterias
     *
     * @param String $select  The columns to select
     * @param String $special The special criteria for the select statement
     * @param String $escape  Whether to escape the select statement or not.
     *                        Default to "TRUE"
     *
     * @return void
     */
    public function select_special($select, $special, $escape = TRUE)
    {
        return;
    }

    /**
     * SELECT a row for a subsequent UPDATE, locking the row.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public function select_for_update($select, $escape = TRUE)
    {
        return;
    }

    /**
     * Define a JOIN clause.
     *
     * @param String $table The table name to join with
     * @param String $on    Base information on what the join should be done
     * @param String $sort  Sort of JOIN operation to be done
     *                      (INNER JOIN by default)
     *
     * @return void
     */
    public function join($table, $on, $sort = 'INNER')
    {
        return;
    }

    /**
     * Start a WHERE clause group.
     *
     * @param String $connector Logical connector to use
     *                          (optional, empty by default)
     *
     * @return void
     */
    public function start_where_group($connector ='')
    {
        return;
    }

    /**
     * End a where group.
     *
     * @return void
     */
    public function end_where_group()
    {
        return;
    }

    /**
     * Define a WHERE clause.
     *
     * @param String $col      Column name
     * @param String $val      Value that should be matched
     * @param String $operator Comparison operator that should be used
     *                         (optional, '=' by default)
     * @param String $collate  Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function where($col, $val, $operator = '=', $collate = '')
    {
        return;
    }

    /**
     * Define a WHERE clause, which deals with hex->binary.
     *
     * @param String $col      Column name
     * @param String $val      Value that should be matched
     * @param String $operator Comparison operator that should be used
     *                         (optional, '=' by default)
     * @param String $collate  Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function where_hex($col, $val, $operator = '=', $collate = '')
    {
        return;
    }

    /**
     * Define a OR WHERE clause.
     *
     * @param String $col      Column name
     * @param String $val      Value that should be matched
     * @param String $operator Comparison operator that should be used
     *                         (optional, '=' by default)
     * @param String $collate  Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function or_where($col, $val, $operator = '=', $collate = '')
    {
        return;
    }

    /**
     * Define a OR WHERE clause, which deals with hex->binary.
     *
     * @param String $col      Column name
     * @param String $val      Value that should be matched
     * @param String $operator Comparison operator that should be used
     *                         (optional, '=' by default)
     * @param String $collate  Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function or_where_hex($col, $val, $operator = '=', $collate = '')
    {
        return;
    }

    /**
     * Define a LIKE clause.
     *
     * @param String $col     Column name
     * @param String $val     Value that should be matched
     * @param String $match   Side of the $val where '%' should be placed
     *                        (optional, both by default)
     * @param String $collate Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function like($col, $val, $match = 'both', $collate = '')
    {
        return;
    }

    /**
     * Define an alternative LIKE clause.
     *
     * @param String $col     Column name
     * @param String $val     Value that should be matched
     * @param String $match   Side of the $val where '%' should be placed
     *                        (optional, both by default)
     * @param String $collate Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function or_like($col, $val, $match = 'both', $collate = '')
    {
        return;
    }

    /**
     * Define a NOT LIKE clause.
     *
     * @param String $col     Column name
     * @param String $val     Value that should be matched
     * @param String $match   Side of the $val where '%' should be placed
     *                        (optional, both by default)
     * @param String $collate Specific collate used for comparison (optional)
     *
     * @return void
     */
    public function not_like($col, $val, $match = 'both', $collate = '')
    {
        return;
    }

    /**
     * Define a WHERE IN clause.
     *
     * @param String $col    Column name
     * @param Mixed  $values Values that should be matched
     *
     * @return void
     */
    public function where_in($col, $values)
    {
        return;
    }

    /**
     * Define a WHERE IN clause that deals with hex->binary conversion.
     *
     * @param String $col    Column name
     * @param Mixed  $values Values that should be matched
     *
     * @return void
     */
    public function where_in_hex($col, $values)
    {
        return;
    }

    /**
     * Define a ORDER BY clause.
     *
     * @param String $col   Column name
     * @param String $order Order ASCending or DESCending
     *
     * @return void
     */
    public function order_by($col, $order = 'ASC')
    {
        return;
    }

    /**
     * Define a GROUP BY clause.
     *
     * @param String $group Column to group
     *
     * @return void
     */
    public function group_by($group)
    {
        return;
    }

    /**
     * Define a LIMIT clause.
     *
     * @param String $count The amount of elements to retrieve
     * @param String $start Start retrieving elements from a sepcific index
     *
     * @return void
     */
    public function limit($count, $start = '')
    {
        return;
    }

    /**
     * Define a UNION statement.
     *
     * @param String $from table name to select from for the first query
     *
     * @return void
     */
    public function union($from)
    {
        return;
    }

    /**
     * Define an INSERT statement.
     *
     * @param String $table The table to insert into
     * @param Mixed  $data  The data to insert
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function insert($table, $data)
    {
        return FALSE;
    }

    /**
     * Define a REPLACE statement.
     *
     * @param String $table The table to insert into
     * @param Mixed  $data  The data to insert
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function replace($table, $data)
    {
        return FALSE;
    }

    /**
     * Define an UPDATE statement.
     *
     * @param String $table The table to update
     * @param Mixed  $data  The updated data
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function update($table, $data)
    {
        return FALSE;
    }

    /**
     * Define a DELETE statement.
     *
     * @param String $table The table to update
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public function delete($table)
    {
        return FALSE;
    }

    /**
     * Start Transaction mode by disabling autocommit.
     *
     * @return Boolean True on success and false on failure
     */
    public function begin_transaction()
    {
        return FALSE;
    }

    /**
     * Commit previous queries of a transaction.
     *
     * @return Boolean True on success and False on failure
     */
    public function commit()
    {
        return FALSE;
    }

    /**
     * Rollback to the state of the database.
     *
     * This is usually the beginning of the transaction.
     *
     * @return Boolean True on success and False on failure
     */
    public function rollback()
    {
        return FALSE;
    }

    /**
     * End Transaction, commit remaining uncommitted queries.
     *
     * @return Boolean True on success and False on failure
     */
    public function end_transaction()
    {
        return FALSE;
    }

    /**
     * Change the default database for the current connection.
     *
     * @param String $db New default database
     *
     * @return Boolean True on success, False on Failure
     */
    public function change_database($db)
    {
        return FALSE;
    }

    /**
     * Delete a view in the database.
     *
     * @param String $view Name of the view
     *
     * @return Boolean TRUE on successful query or FALSE on connection failure
     */
    public function drop_view($view)
    {
        return FALSE;
    }

    /**
     * Alter a view in the database.
     *
     * @param String $name Name of the view
     * @param String $from Name of the first table used in the from clause for
     *                     the view definition
     *
     * @return Boolean TRUE on successful query or FALSE on connection failure
     */
    public function alter_view($name, $from)
    {
        return FALSE;
    }

    /**
     * Create a view in the database.
     *
     * @param String $name Name of the view
     * @param String $from Name of the first table used in the from clause for
     *                     the view definition
     *
     * @return Boolean TRUE on successful query or FALSE on connection failure
     */
    public function create_view($name, $from)
    {
        return FALSE;
    }

     /**
     * Generate and return UUID.
     *
     * @return Mixed $return hex UUID on success, FALSE on failure
     */
    public function generate_uuid()
    {
        return FALSE;
    }

    /**
     * Escape a string to be used in a SQL query.
     *
     * @param String $string The string to escape
     *
     * @return Mixed the escaped string, False on connection error
     */
    protected function escape_string($string)
    {
        return addslashes($string);
    }

}

?>
