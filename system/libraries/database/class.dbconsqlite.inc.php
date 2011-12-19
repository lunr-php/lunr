<?php

/**
 * This file contains database access methods for accessing
 * a Sqlite database
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */

namespace Lunr\Libraries\Database;

/**
 * Sqlite database access class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */
class DBConSqlite extends DBCon
{

    /**
     * SQLite3 database resource class
     * @var SQLite3
     */
    protected $res;

    /**
     * Path to sqlite database file
     * @var string
     */
    private $db_file;

    /**
     * Constructor.
     *
     * Automatically sets up mysql server-vars
     *
     * @param array   $db       Database access information
     * @param Boolean $readonly Whether the database access should
     *                          be established readonly
     */
    public function __construct($db, $readonly = TRUE)
    {
        parent::__construct($readonly);
        $this->db_file = dirname(__FILE__) . '/../../../' . $db['file'];

        /*$this->last_query = '';
        $this->where_group = FALSE;
        $this->transaction = FALSE;
        $this->for_update = FALSE;
        $this->gen_uuid_hex = 'REPLACE(UUID(),'-','')';*/
    }

    /**
     * Destructor.
     *
     * closes database connection if there is still one established
     */
    public function __destruct()
    {
        if ($this->connected)
        {
            $this->disconnect();
        }

        unset($this->db_file);
        unset($this->res);
        /*unset($this->transaction);
        unset($this->last_query);
        unset($this->where_group);
        unset($this->for_update);
        unset($this->gen_uuid_hex);
        unset($this->socket);*/
        parent::__destruct();
    }

    /**
     * Open defined sqlite database.
     *
     * @return void
     */
    public function connect()
    {
        if ($this->readonly)
        {
            $flag = SQLITE3_OPEN_READONLY;
        }
        else
        {
            $flag = SQLITE3_OPEN_READWRITE;
        }

        $this->res = new SQLite3(
            $this->db_file,
            $flag
        );

        if (is_a($this->res, 'SQLite3'))
        {
            $this->connected = TRUE;
        }
    }

    /**
     * Close sqlite database.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->connected)
        {
            $this->res->close();
            $this->connected = FALSE;
        }
    }

    /**
     * Returns last sqlite error.
     *
     * @return String Error message
     */
    public function last_error()
    {
        return $this->res->lastErrorMsg();
    }

    /**
     * Returns last sqlite error number.
     *
     * @return Integer Error number
     */
    public function last_error_number()
    {
        return $this->res->lastErrorCode();
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
        return FALSE;
    }

    /**
     * Get the calculated amount of total rows for the last executed query.
     *
     * @return mixed $return The amount of rows on success, False on failure
     */
    public function found_rows()
    {
        return FALSE;
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
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected)
        {
            $sql_command .= $this->construct_query('', TRUE, TRUE);

            $this->last_query = $sql_command;

            if (substr($sql_command, 0, 6) == 'SELECT')
            {
                if ($this->readonly === TRUE)
                {
                    return FALSE;
                }

                $cmd = 'query';
            }
            else
            {
                $cmd = 'exec';
            }

            $output = $this->res->{$cmd}($sql_command);

            if ($return)
            {
                if (is_bool($output))
                {
                    Output::error($this->last_query());
                    Output::error($this->last_error());
                }
                return new QuerySqlite($output, $this->res);
            }
            else
            {
                return $output;
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Execute the defined SQL query and return the result set.
     *
     * @param String $from Where to get the data from
     *
     * @return QueryMySQL $result Query result, or False on connection failure
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

    }

    /**
     * Start a WHERE clause group.
     *
     * @param String $connector Logical connector to use
     *                          (optional, empty by default)
     *
     * @return void
     */
    public function start_where_group($connector = '')
    {

    }

    /**
     * End a where group.
     *
     * @return void
     */
    public function end_where_group()
    {

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

    }

    /**
     * Define a ORDER BY clause.
     *
     * @param String $col   Column name
     * @param String $order Order ASCending or DESCending
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public function order_by($col, $order = 'ASC', $escape = TRUE)
    {

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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql  = "INSERT INTO `$table` ";
            $sql .= $this->prepare_data($data, 'keys');
            $sql .= 'VALUES ';
            $sql .= $this->prepare_data($data, 'values');
            $sql .= ';';
            return $this->query($sql, FALSE);
        }
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
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected)
        {
            if (is_array($string))
            {
                $input = print_r($string, TRUE);
                $msg = 'Wrong input for escape_string()! Array given: ' . $input;
                Output::error($msg);
                return FALSE;
            }
            return $this->res->escapeString($string);
        }
        else
        {
            return FALSE;
        }
    }

}

?>
