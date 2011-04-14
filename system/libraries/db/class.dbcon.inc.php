<?php

/**
 * Abtract database connection class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */

/**
 * This class defines abstract database access.
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */
abstract class DBCon
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        // Nothing to do yet
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        // Nothing to do yet
    }

    /**
     * Return information whether we use a readonly or a read-write connection.
     *
     * @return Boolean $readonly
     */
    public abstract function is_readonly();

    /**
     * Establishes a connection to the defined database-server.
     *
     * @return void
     */
    public abstract function connect();

    /**
     * Disconnects from database-server.
     *
     * @return void
     */
    public abstract function disconnect();

    /**
     * Returns last database error.
     *
     * @return String Error message
     */
    public abstract function last_error();

    /**
     * Returns last database error number.
     *
     * @return Integer Error number
     */
    public abstract function last_error_number();

    /**
     * Returns the last executed query.
     *
     * @return String SQL Query
     */
    public abstract function last_query();

    /**
     * Returns the id given for the last insert statement.
     *
     * @return Mixed Insert ID
     */
    public abstract function last_id();

    /**
     * Get the calculated amount of total rows for the last executed query.
     *
     * @return mixed $return The amount of rows on success, False on failure
     */
    public abstract function found_rows();

    /**
     * Return the preliminary query.
     *
     * Query like it would be executed by query() at this point
     * **DEBUG**
     *
     * @param String $from Where to get the data from
     *
     * @return String SQL query
     */
    public abstract function preliminary_query($from);

    /**
     * Executes a defined SQL query.
     *
     * @param String  $sql_command Predefined SQL query
     * @param Boolean $return      Return a Query Result
     *
     * @return Mixed $result Query Result, TRUE on successful query or
     *                       FALSE on connection failure/failed query
     */
    public abstract function query($sql_command, $return = TRUE);

    /**
     * Execute the defined SQL query and return the result set.
     *
     * @param String $from Where to get the data from
     *
     * @return Query Query result, or False on connection failure
     */
    public abstract function get($from);

    /**
     * Define a SELECT statement.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public abstract function select($select, $escape = TRUE);

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
    public abstract function select_hex($select, $escape = TRUE);

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
    public abstract function select_special($select, $special, $escape = TRUE);

    /**
     * SELECT a row for a subsequent UPDATE, locking the row.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public abstract function select_for_update($select, $escape = TRUE);

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
    public abstract function join($table, $on, $sort = "INNER");

    /**
     * Start a WHERE clause group.
     *
     * @param String $connector Logical connector to use
     *                          (optional, empty by default)
     *
     * @return void
     */
    public abstract function start_where_group($connector = "");

    /**
     * End a where group.
     *
     * @return void
     */
    public abstract function end_where_group();

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
    public abstract function where($col, $val, $operator = "=", $collate = "");

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
    public abstract function where_hex($col, $val, $operator = "=", $collate = "");

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
    public abstract function or_where($col, $val, $operator = "=", $collate = "");

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
    public abstract function or_where_hex($col, $val, $operator = "=", $collate = "");

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
    public abstract function like($col, $val, $match = "both", $collate = "");

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
    public abstract function or_like($col, $val, $match = "both", $collate = "");

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
    public abstract function not_like($col, $val, $match = "both", $collate = "");

    /**
     * Define a WHERE IN clause.
     *
     * @param String $col    Column name
     * @param Mixed  $values Values that should be matched
     *
     * @return void
     */
    public abstract function where_in($col, $values);

    /**
     * Define a WHERE IN clause that deals with hex->binary conversion.
     *
     * @param String $col    Column name
     * @param Mixed  $values Values that should be matched
     *
     * @return void
     */
    public abstract function where_in_hex($col, $values);

    /**
     * Define a ORDER BY clause.
     *
     * @param String $col   Column name
     * @param String $order Order ASCending or DESCending
     *
     * @return void
     */
    public abstract function order_by($col, $order = "ASC");

    /**
     * Define a GROUP BY clause.
     *
     * @param String $group Column to group
     *
     * @return void
     */
    public abstract function group_by($group);

    /**
     * Define a LIMIT clause.
     *
     * @param String $count The amount of elements to retrieve
     * @param String $start Start retrieving elements from a sepcific index
     *
     * @return void
     */
    public abstract function limit($count, $start = "");

    /**
     * Define a UNION statement.
     *
     * @param String $from table name to select from for the first query
     *
     * @return void
     */
    public abstract function union($from);

    /**
     * Define an INSERT statement.
     *
     * @param String $table The table to insert into
     * @param Mixed  $data  The data to insert
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public abstract function insert($table, $data);

    /**
     * Define a REPLACE statement.
     *
     * @param String $table The table to insert into
     * @param Mixed  $data  The data to insert
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public abstract function replace($table, $data);

    /**
     * Define an UPDATE statement.
     *
     * @param String $table The table to update
     * @param Mixed  $data  The updated data
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public abstract function update($table, $data);

    /**
     * Define a DELETE statement.
     *
     * @param String $table The table to update
     *
     * @return Boolean $return TRUE on success, FALSE on failure
     */
    public abstract function delete($table);

    /**
     * Start Transaction mode by disabling autocommit.
     *
     * @return Boolean True on success and false on failure
     */
    public abstract function begin_transaction();

    /**
     * Commit previous queries of a transaction.
     *
     * @return Boolean True on success and False on failure
     */
    public abstract function commit();

    /**
     * Rollback to the state of the database.
     *
     * This is usually the beginning of the transaction.
     *
     * @return Boolean True on success and False on failure
     */
    public abstract function rollback();

    /**
     * End Transaction, commit remaining uncommitted queries.
     *
     * @return Boolean True on success and False on failure
     */
    public abstract function end_transaction();

    /**
     * Change the default database for the current connection.
     *
     * @param String $db New default database
     *
     * @return Boolean True on success, False on Failure
     */
    public abstract function change_database($db);

    /**
     * Delete a view in the database.
     *
     * @param String $view Name of the view
     *
     * @return Boolean TRUE on successful query or FALSE on connection failure
     */
    public abstract function drop_view($view);

    /**
     * Create a view in the database.
     *
     * @param String $name Name of the view
     * @param String $from Name of the first table used in the from clause for
     *                     the view definition
     *
     * @return Boolean TRUE on successful query or FALSE on connection failure
     */
    public abstract function create_view($name, $from);

     /**
     * Generate and return UUID.
     *
     * @return Mixed $return hex UUID on success, FALSE on failure
     */
    public abstract function generate_uuid();

}

?>
