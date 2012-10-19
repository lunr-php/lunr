<?php

/**
 * This file contains database access methods for accessing
 * a MySQL/MariaDB database
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 * @copyright  2009-2011, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2011, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://opensource.org/licenses/bsd-license BSD License
 */

namespace Lunr\Libraries\Database;
use Lunr\Libraries\Core\Output;

/**
 * MySQL/MariaDB database access class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 * @copyright  2009-2011, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2011, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://opensource.org/licenses/bsd-license BSD License
 */
class DBConMySQL extends DBCon
{

    /**
     * Hostname of the database server (read/write access)
     * @var String
     */
    private $rw_host;

    /**
     * Hostname of the database server (readonly access)
     * @var String
     */
    private $ro_host;

    /**
     * Username of the user used to connect to the database
     * @var String
     */
    private $user;

    /**
     * Password of the user used to connect to the database
     * @var String
     */
    private $pwd;

    /**
     * Database to connect to
     * @var String
     */
    private $db;

    /**
     * Path to the UNIX socket for localhost connection
     */
    private $socket;

    /**
     * Transaction status
     * @var Boolean
     */
    private $transaction;

    /**
     * Last executed query
     * @var String
     */
    private $last_query;

    /**
     * SQL Query part: Where () clause
     * @var Boolean
     */
    private $where_group;

    /**
     * Determine whether we are locking a table row or not
     * @var Boolean
     */
    private $for_update;

    /**
     * Command to generate an hexadecimal UUID
     * @var String
     */
    private $gen_uuid_hex;

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
        $this->rw_host = $db['rw_host'];
        $this->ro_host = $db['ro_host'];
        $this->user = $db['username'];
        $this->pwd = $db['password'];
        $this->db = $db['database'];

        if (isset($db['socket']))
        {
            $this->socket = $db['socket'];
        }
        else
        {
            $this->socket = ini_get('mysqli.default_socket');
        }

        $this->where_group = FALSE;
        $this->last_query = '';
        $this->transaction = FALSE;
        $this->for_update = FALSE;
        $this->gen_uuid_hex = "REPLACE(UUID(),'-','')";
    }

    /**
     * Destructor.
     *
     * closes database connection if there is still one established
     */
    public function __destruct()
    {
        if ($this->transaction)
        {
            $this->rollback();
        }
        if ($this->connected)
        {
            $this->disconnect();
        }
        unset($this->ro_host);
        unset($this->rw_host);
        unset($this->user);
        unset($this->pwd);
        unset($this->db);
        unset($this->transaction);
        unset($this->last_query);
        unset($this->where_group);
        unset($this->for_update);
        unset($this->gen_uuid_hex);
        unset($this->socket);
        parent::__destruct();
    }

    /**
     * Establishes a connection to the defined mysql-server.
     *
     * @return void
     */
    public function connect()
    {
        if ($this->readonly)
        {
            $this->res = mysqli_connect(
                $this->ro_host,
                $this->user,
                $this->pwd,
                $this->db,
                ini_get('mysqli.default_port'),
                $this->socket
            );
        }
        else
        {
            $this->res = mysqli_connect(
                $this->rw_host,
                $this->user,
                $this->pwd,
                $this->db,
                ini_get('mysqli.default_port'),
                $this->socket
            );
        }
        if ($this->res)
        {
            mysqli_set_charset($this->res, 'utf8');
            $this->connected = TRUE;
        }
    }

    /**
     * Disconnects from mysql-server.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->connected)
        {
            mysqli_close($this->res);
            $this->connected = FALSE;
        }
    }

    /**
     * Returns last mysql error.
     *
     * @return String Error message
     */
    public function last_error()
    {
        return mysqli_error($this->res);
    }

    /**
     * Returns last mysql error number.
     *
     * @return Integer Error number
     */
    public function last_error_number()
    {
        return mysqli_errno($this->res);
    }

    /**
     * Returns the last executed query.
     *
     * @return String SQL Query
     */
    public function last_query()
    {
        return $this->last_query;
    }

    /**
     * Returns the id given for the last insert statement.
     *
     * @return Mixed Insert ID
     */
    public function last_id()
    {
        return mysqli_insert_id($this->res);
    }

    /**
     * Get the calculated amount of total rows for the last executed query.
     *
     * @return mixed $return The amount of rows on success, False on failure
     */
    public function found_rows()
    {
        $sql = 'SELECT FOUND_ROWS() AS total;';
        $query = $this->query($sql, TRUE);
        if ($query)
        {
            return $query->field('total');
        }
        else
        {
            return FALSE;
        }
    }

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
    public function preliminary_query($from, $union = FALSE)
    {
        $sql_command = '';

        if ($this->union != '')
        {
            $sql_command .= $this->union;
        }

        if (($union === TRUE) || ($this->union != ''))
        {
            $sql_command .= '(';
        }

        if ($this->select != '')
        {
            $sql_command .= $this->select;
        }
        else
        {
            $sql_command .= 'SELECT * ';
        }

        $sql_command .= 'FROM ' . $this->escape_as($from);

        if ($this->join != '')
        {
            $sql_command .= $this->join;
        }

        if ($this->where != '')
        {
            $sql_command .= $this->where;
        }

        if ($this->group != '')
        {
            $sql_command .= $this->group;
        }

        if ($this->order != '')
        {
            $sql_command .= $this->order;
        }

        if ($this->limit != '')
        {
            $sql_command .= $this->limit;
        }

        if ($this->for_update)
        {
            $sql_command .= ' FOR UPDATE';
        }

        if (($union === TRUE) || ($this->union != ''))
        {
            $sql_command .= ')';
        }

        return $sql_command;
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
            if ($this->where != '')
            {
                $sql_command = $sql_command . $this->where;
                $this->where = '';
            }

            if ($this->order != '')
            {
                $sql_command = $sql_command . $this->order;
                $this->order = '';
            }

            if ($this->limit != '')
            {
                $sql_command = $sql_command . $this->limit;
                $this->limit = '';
            }

            $this->last_query = $sql_command;

            if ($return)
            {
                $output = mysqli_query($this->res, $sql_command);
                if (is_bool($output))
                {
                    Output::error($this->last_query());
                    Output::error($this->last_error());
                    return FALSE;
                }
                return new QueryMySQL($output, $this->res);
            }
            elseif ($this->readonly === TRUE)
            {
                return FALSE;
            }
            else
            {
                return mysqli_query($this->res, $sql_command);
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
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected)
        {
            $sql_command = '';

            if ($this->union != '')
            {
                $sql_command .= $this->union;
                $sql_command .= '(';
            }

            if ($this->select != '')
            {
                $sql_command .= $this->select;
                $this->select = '';
            }
            else
            {
                $sql_command .= 'SELECT * ';
            }

            $sql_command .= 'FROM ' . $this->escape_as($from);

            if ($this->join != '')
            {
                $sql_command .= $this->join;
                $this->join = '';
            }

            if ($this->where != '')
            {
                $sql_command .= $this->where;
                $this->where = '';
            }

            if ($this->group != '')
            {
                $sql_command .= $this->group;
                $this->group = '';
            }

            if ($this->order != '')
            {
                $sql_command .= $this->order;
                $this->order = '';
            }

            if ($this->limit != '')
            {
                $sql_command .= $this->limit;
                $this->limit = '';
            }

            if ($this->for_update)
            {
                $sql_command .= ' FOR UPDATE';
                $this->for_update = FALSE;
            }

            if ($this->union != '')
            {
                $sql_command .= ')';
                $this->union = '';
            }

            $this->last_query = $sql_command;

            $output = mysqli_query($this->res, $sql_command);
            if (is_bool($output))
            {
                Output::error($this->last_query());
                Output::error($this->last_error());
                return FALSE;
            }
            return new QueryMySQL($output, $this->res);
        }
        else
        {
            return FALSE;
        }
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
        if ($this->select == '')
        {
            $this->select = 'SELECT ';
        }
        else
        {
            $this->select .= ', ';
        }

        if ($escape)
        {
            $this->select .= $this->escape_as($select);
        }
        else
        {
            $this->select .= $select . ' ';
        }
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
        if ($this->select == '')
        {
            $this->select = 'SELECT ';
        }
        else
        {
            $this->select .= ', ';
        }

        if ($escape)
        {
            $this->select .= $this->escape_as($select, TRUE);
        }
        else
        {
            $this->select .= $select . ' ';
        }
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
        $this->select = 'SELECT ' . $special . ' ';

        if ($escape)
        {
            $this->select .= $this->escape_as($select);
        }
        else
        {
            $this->select .= $select . ' ';
        }
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
        $this->select($select, $escape);
        if ($this->transaction)
        {
            $this->for_update = TRUE;
        }
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
        $this->join .= "$sort JOIN " . $this->escape_as($table) . ' ';

        if (substr($sort, 0, 7) != 'NATURAL')
        {
            $this->join .= 'ON ' . $this->escape_on($on) . ' ';
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ( ';
        }
        else
        {
            $this->where .= " $connector ( ";
        }
        $this->where_group = TRUE;
    }

    /**
     * End a where group.
     *
     * @return void
     */
    public function end_where_group()
    {
        $this->where .= ' ) ';
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        if (substr($val, 0, 3) == 'IS ')
        {
            $this->where .= $this->escape_columns($col) . ' ' . $base_charset;
            $this->where .= $this->escape_string($val) . $collate;
        }
        else
        {
            $this->where .= $this->escape_columns($col) . $operator . ' ';
            $this->where .= $base_charset;
            $this->where .= "'" . $this->escape_string($val) . "'" . $collate;
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        $this->where .= $this->escape_columns($col) . $operator . ' ';
        $this->where .= $base_charset;
        $this->where .= "UNHEX('" . $this->escape_string($val) . "')";
        $this->where .= $collate;
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' OR ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        if (substr($val, 0, 2) == 'IS')
        {
            $this->where .= $this->escape_columns($col) . $operator . ' ';
            $this->where .= $base_charset . $this->escape_string($val);
            $this->where .= $collate;
        }
        else
        {
            $this->where .= $this->escape_columns($col) . $operator . ' ';
            $this->where .= $base_charset;
            $this->where .= "'" . $this->escape_string($val) . "'" . $collate;
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' OR ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        $this->where .= $this->escape_columns($col) . $operator . ' ';
        $this->where .= $base_charset . "UNHEX('";
        $this->where .= $this->escape_string($val) . "')" . $collate;
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case 'forward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
            case 'backward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' OR ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case 'forward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
            case 'backward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }

        if ($collate == '')
        {
            $base_charset = '';
        }
        else
        {
            $base_charset = '_utf8 ';
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case 'forward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
            case 'backward':
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col);
                $this->where .= ' LIKE '.$base_charset . "'%";
                $this->where .= $this->escape_string($val) . "%'" .$collate;
                break;
        }
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }
        $this->where .= $this->escape_columns($col) . 'IN ';
        $this->where .= $this->prepare_data($values, 'values');
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
        if ($this->where == '')
        {
            $this->where = ' WHERE ';
        }
        elseif ($this->where_group)
        {
            $this->where .= '';
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= ' AND ';
        }

        if (!is_array($values))
        {
            $values = array($values);
        }

        # prepare hex data for database
        foreach ($values AS &$value)
        {
            $value = "UNHEX('$value')";
        }
        unset($value);

        $this->where .= $this->escape_columns($col) . 'IN ';
        $this->where .= $this->prepare_data($values, 'values');
    }

    /**
     * Define a ORDER BY clause.
     *
     * @param String $col    Column name
     * @param String $order  Order ASCending or DESCending
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return void
     */
    public function order_by($col, $order = 'ASC', $escape = TRUE)
    {
        if ($this->order == '')
        {
            $this->order = ' ORDER BY ';
        }
        else
        {
            $this->order .= ', ';
        }

        if ($escape === TRUE)
        {
            $this->order .= $this->escape_columns($col) . $order;
        }
        else
        {
            $this->order .= $col . ' ' . $order;
        }
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
        if ($this->group == '')
        {
            $this->group = ' GROUP BY ';
        }
        else
        {
            $this->group .= ', ';
        }
        $this->group .= $this->escape_columns($group);
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
        if ($start == '')
        {
            $this->limit = " LIMIT $count";
        }
        else
        {
            $this->limit = " LIMIT $start,$count";
        }
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
        $this->union = $this->preliminary_query($from, TRUE) . ' UNION ';
        $this->limit = '';
        $this->where = '';
        $this->select = '';
        $this->order = '';
        $this->group = '';
        $this->join = '';
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql  = "REPLACE INTO `$table` ";
            $sql .= $this->prepare_data($data, 'keys');
            $sql .= 'VALUES ';
            $sql .= $this->prepare_data($data, 'values');
            $sql .= ';';
            return $this->query($sql, FALSE);
        }
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql = "UPDATE `$table` SET ";
            foreach ($data as $key => $value)
            {
                if (is_null($value))
                {
                    $sql .= "`$key` = NULL,";
                }
                else
                {
                    $sql .= "`$key` = '" . $this->escape_string($value) . "',";
                }
            }
            $sql = substr_replace($sql, ' ', strripos($sql, ','));
            return $this->query($sql, FALSE);
        }
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql = "DELETE FROM `$table`";
            return $this->query($sql, FALSE);
        }
    }

    /**
     * Start Transaction mode by disabling autocommit.
     *
     * @return Boolean True on success and false on failure
     */
    public function begin_transaction()
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_autocommit($this->res, FALSE))
        {
            $this->transaction = TRUE;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Commit previous queries of a transaction.
     *
     * @return Boolean True on success and False on failure
     */
    public function commit()
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_commit($this->res))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_rollback($this->res))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * End Transaction, commit remaining uncommitted queries.
     *
     * @return Boolean True on success and False on failure
     */
    public function end_transaction()
    {
        if ($this->commit() && mysqli_autocommit($this->res, TRUE))
        {
            $this->transaction = FALSE;
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_select_db($this->res, $db))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql = 'DROP VIEW IF EXISTS ' . $this->escape_string($view);
            return $this->query($sql, FALSE);
        }
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql = 'ALTER VIEW ' . $this->escape_string($name) . ' AS ';
            $sql .= $this->preliminary_query($from);
            return $this->query($sql, FALSE);
        }
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
        if ($this->readonly === TRUE)
        {
            return FALSE;
        }
        else
        {
            $sql = 'CREATE VIEW ' . $this->escape_string($name) . ' AS ';
            $sql .= $this->preliminary_query($from);
            return $this->query($sql, FALSE);
        }
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
                $msg = "Wrong input for escape_string()! Array given: $input";
                Output::error($msg);
                return FALSE;
            }
            return mysqli_real_escape_string($this->res, $string);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Escape column names for "ON"-using statements.
     *
     * @param String $string comparison string
     *
     * @return String escaped column list
     */
    private function escape_on($string)
    {
        $parts = explode('=', $string);
        $return  = $this->escape_columns($parts[0]) . ' = ';
        $return .= $this->escape_columns($parts[1]);
        return $return;
    }

     /**
     * Generate and return UUID.
     *
     * @return Mixed $return hex UUID on success, FALSE on failure
     */
    public function generate_uuid()
    {
        $sql = 'SELECT '.$this->gen_uuid_hex.' AS UUID;';
        $query = $this->query($sql, TRUE);
        if ($query)
        {
            return $query->field('UUID');
        }
        else
        {
            return FALSE;
        }
    }

}

?>
