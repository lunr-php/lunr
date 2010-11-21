<?php

# Copyright 2009-2010 Heinz Wiesinger, Amsterdam, The Netherlands
# Copyright 2010 M2Mobi BV, Amsterdam, The Netherlands
# All rights reserved.
#
# Redistribution and use of this script, with or without modification, is
# permitted provided that the following conditions are met:
#
# 1. Redistributions of this script must retain the above copyright
#    notice, this list of conditions and the following disclaimer.
#
# THIS SOFTWARE IS PROVIDED BY THE AUTHOR ''AS IS'' AND ANY EXPRESS OR IMPLIED
# WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
# MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO
# EVENT SHALL THE AUTHOR BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
# SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
# PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
# OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
# WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
# OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
# ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

class DBCon
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
     * Resource handler for the (established) database connection
     * @var Resource
     */
    private $res;

    /**
     * Whether there's write access to the database or not
     * @var Boolean
     */
    private $readonly;

    /**
     * Connection status
     * @var Boolean
     */
    private $connected;

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
     * SQL Query part: SELECT statement
     * @var String
     */
    private $select;

    /**
     * SQL Query part: JOIN clause
     * @var String
     */
    private $join;

    /**
     * SQL Query part: WHERE clause
     * @var String
     */
    private $where;

    /**
     * SQL Query part: Where () clause
     * @var Boolean
     */
    private $where_group;

    /**
     * SQL Query part: ORDER BY clause
     * @var String
     */
    private $order;

    /**
     * SQL Query part: GROUP BY clause
     * @var String
     */
    private $group;

    /**
     * SQL Query part: LIMIT clause
     * @var String
     */
    private $limit;

    /**
     * SQL Query part: UNION statement
     * @var String
     */
    private $union;

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
     * Constructor
     * automatically sets up mysql server-vars
     */
    public function __construct($db, $readonly = TRUE)
    {
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
            $this->socket = ini_get("mysqli.default_socket");
        }

        $this->readonly = $readonly;
        $this->select = "";
        $this->join = "";
        $this->where = "";
        $this->where_group = FALSE;
        $this->order = "";
        $this->group = "";
        $this->limit = "";
        $this->union = "";
        $this->last_query = "";
        $this->connected = FALSE;
        $this->transaction = FALSE;
        $this->for_update = FALSE;
        $this->gen_uuid_hex = "REPLACE(UUID(),'-','')";
    }

    /**
     * Destructor
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
        unset($this->res);
        unset($this->connected);
        unset($this->transaction);
        unset($this->last_query);
        unset($this->select);
        unset($this->join);
        unset($this->where);
        unset($this->order);
        unset($this->group);
        unset($this->limit);
        unset($this->union);
        unset($this->where_group);
        unset($this->for_update);
        unset($this->gen_uuid_hex);
        unset($this->socket);
        unset($this->readonly);
    }

    /**
     * Establishes a connection to the defined mysql-server
     * @return void
     */
    public function connect()
    {
        if ($this->readonly)
        {
            $this->res = mysqli_connect($this->ro_host, $this->user, $this->pwd, $this->db, ini_get("mysqli.default_port"), $this->socket);
        }
        else
        {
            $this->res = mysqli_connect($this->rw_host, $this->user, $this->pwd, $this->db, ini_get("mysqli.default_port"), $this->socket);
        }
        if ($this->res)
        {
            mysqli_set_charset($this->res, "utf8");
            $this->connected = TRUE;
        }
    }

    /**
     * Disconnects from mysql-server
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
     * Returns last mysql error
     * @return String Error message
     */
    public function last_error()
    {
        return mysqli_error($this->res);
    }

    /**
     * Returns last mysql error number
     * @return Integer Error number
     */
    public function last_error_number()
    {
        return mysqli_errno($this->res);
    }

    /**
     * Returns the last executed query
     * @return String SQL Query
     */
    public function last_query()
    {
        return $this->last_query;
    }

    /**
     * Returns the id given for the last insert statement
     * @return Mixed Insert ID
     */
    public function last_id()
    {
        return mysqli_insert_id($this->res);
    }

    /**
     * Get the calculated amount of total rows for the last executed query
     * @return mixed $return The amount of rows on success, False on failure
     */
    public function found_rows()
    {
        $sql = "SELECT FOUND_ROWS() AS total;";
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
     * Return the preliminary query, that would be executed by query() at this point
     * **DEBUG**
     * @param String $from Where to get the data from
     * @return String SQL query
     */
    public function preliminary_query($from)
    {
        $sql_command = "";

        if ($this->union != "")
        {
            $sql_command .= $this->union;
        }
        if ($this->select != "")
        {
            $sql_command .= $this->select;
        }
        else
        {
            $sql_command .= "SELECT * ";
        }

        $sql_command .= "FROM " . $this->escape_as($from);

        if ($this->join != "")
        {
            $sql_command .= $this->join;
        }

        if ($this->where != "")
        {
            $sql_command .= $this->where;
        }

        if ($this->group != "")
        {
            $sql_command .= $this->group;
        }

        if ($this->order != "")
        {
            $sql_command .= $this->order;
        }

        if ($this->limit != "")
        {
            $sql_command .= $this->limit;
        }

        if ($this->for_update)
        {
            $sql_command .= " FOR UPDATE";
        }

        return $sql_command;
    }

    /**
     * Executes a defined SQL query
     * @param String $sql_command Predefined SQL query
     * @param Boolean $return Return a Query Result
     * @return Mixed Query Result, TRUE on successful query or FALSE on connection failure/failed query
     */
    public function query($sql_command, $return = true)
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected)
        {
            if ($this->where != "")
            {
                $sql_command = $sql_command . $this->where;
                $this->where = "";
            }

            if ($this->order != "")
            {
                $sql_command = $sql_command . $this->order;
                $this->order = "";
            }

            if ($this->limit != "")
            {
                $sql_command = $sql_command . $this->limit;
                $this->limit = "";
            }

            $this->last_query = $sql_command;

            if ($return)
            {
                $output = mysqli_query($this->res, $sql_command);
                return new Query($output, $this->res);
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
     * Execute the defined SQL query and return the result set
     * @param String $from Where to get the data from
     * @return Query Query result, or False on connection failure
     */
    public function get($from)
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected)
        {
            $sql_command = "";

            if ($this->union != "")
            {
                $sql_command .= $this->union;
                $this->union = "";
            }

            if ($this->select != "")
            {
                $sql_command .= $this->select;
                $this->select = "";
            }
            else
            {
                $sql_command .= "SELECT * ";
            }

            $sql_command .= "FROM " . $this->escape_as($from);

            if ($this->join != "")
            {
                $sql_command .= $this->join;
                $this->join = "";
            }

            if ($this->where != "")
            {
                $sql_command .= $this->where;
                $this->where = "";
            }

            if ($this->group != "")
            {
                $sql_command .= $this->group;
                $this->group = "";
            }

            if ($this->order != "")
            {
                $sql_command .= $this->order;
                $this->order = "";
            }

            if ($this->limit != "")
            {
                $sql_command .= $this->limit;
                $this->limit = "";
            }

            if ($this->for_update)
            {
                $sql_command .= " FOR UPDATE";
                $this->for_update = FALSE;
            }

            $this->last_query = $sql_command;

            $output = mysqli_query($this->res, $sql_command);
            return new Query($output, $this->res);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Define a SELECT statement
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not. Default to "TRUE"
     * @return void
     */
    public function select($select, $escape = TRUE)
    {
        if ($this->select == "")
        {
            $this->select = "SELECT ";
        }
        else
        {
            $this->select .= ", ";
        }

        if ($escape)
        {
            $this->select .= $this->escape_as($select);
        }
        else
        {
            $this->select .= $select . " ";
        }
    }

    /**
     * Select columns as hex values, if not new name assignment done
     * it returns as a column name given (without HEX() surrounding)
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not. Default to "TRUE"
     * @return void
     */
    public function select_hex($select, $escape = TRUE)
    {
        if ($this->select == "")
        {
            $this->select = "SELECT ";
        }
        else
        {
            $this->select .= ", ";
        }

        if ($escape)
        {
            $this->select .= $this->escape_as($select, TRUE);
        }
        else
        {
            $this->select .= $select . " ";
        }
    }

    /**
     * Define a special SELECT statement.
     * WARNING: This overwrites previously defined select criterias
     * @param String $select The columns to select
     * @param String $special The special criteria for the select statement
     * @param String $escape Whether to escape the select statement or not. Default to "TRUE"
     * @return void
     */
    public function select_special($select, $special, $escape = TRUE)
    {
        $this->select = "SELECT " . $special . " ";

        if ($escape)
        {
            $this->select .= $this->escape_as($select);
        }
        else
        {
            $this->select .= $select . " ";
        }
    }

    /**
     * SELECT a row for a subsequent UPDATE, locking the row
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not. Default to "TRUE"
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
     * Define a JOIN clause
     * @param String $table The table name to join with
     * @param String $on Base information on what the join should be done
     * @param String $sort Sort of JOIN operation to be done (INNER JOIN by default)
     * @return void
     */
    public function join($table, $on, $sort = "INNER")
    {
        $this->join .= "$sort JOIN " . $this->escape_as($table) . " ON " . $this->escape_on($on) . " ";
    }

    /**
     * Start a WHERE clause group
     * @param String $connector Logical connector to use (optional, empty by default)
     * @return void
     */
    public function start_where_group($connector = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ( ";
        }
        else
        {
            $this->where .= " $connector ( ";
        }
        $this->where_group = TRUE;
    }

    /**
     * End a where group
     * @return void
     */
    public function end_where_group()
    {
        $this->where .= " ) ";
    }

    /**
     * Define a WHERE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $operator Comparison operator that should be used (optional, '=' by default)
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function where($col, $val, $operator = "=", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        if (substr($val,0,2) == "IS")
        {
            $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . $this->escape_string($val) . $collate;
        }
        else
        {
            $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . "'" . $this->escape_string($val) . "'" . $collate;
        }
    }

    /**
     * Define a WHERE clause, which deals with hex->binary
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $operator Comparison operator that should be used (optional, '=' by default)
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function where_hex($col, $val, $operator = "=", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . "UNHEX('" . $this->escape_string($val) . "')" . $collate;
    }

    /**
     * Define a OR WHERE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $operator Comparison operator that should be used (optional, '=' by default)
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function or_where($col, $val, $operator = "=", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " OR ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        if (substr($val,0,2) == "IS")
        {
            $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . $this->escape_string($val) . $collate;
        }
        else
        {
            $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . "'" . $this->escape_string($val) . "'" . $collate;
        }
    }

    /**
     * Define a OR WHERE clause, which deals with hex->binary
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $operator Comparison operator that should be used (optional, '=' by default)
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function or_where_hex($col, $val, $operator = "=", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " OR ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        $this->where .= $this->escape_columns($col) . $operator . " " . $base_charset . "UNHEX('" . $this->escape_string($val) . "')" . $collate;
    }

    /**
     * Define a LIKE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function like($col, $val, $match = "both", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case "forward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'" . $this->escape_string($val) . "%'" .$collate;
                break;
            case "backward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "%'" .$collate;
                break;
        }
    }

    /**
     * Define an alternative LIKE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function or_like($col, $val, $match = "both", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " OR ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case "forward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'" . $this->escape_string($val) . "%'" .$collate;
                break;
            case "backward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "%'" .$collate;
                break;
        }
    }

    /**
     * Define a NOT LIKE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function not_like($col, $val, $match = "both", $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
        }

        if ($collate == "")
        {
            $base_charset = "";
        }
        else
        {
            $base_charset = "_utf8 ";
            $collate = " COLLATE $collate";
        }

        switch ($match)
        {
            case "forward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'" . $this->escape_string($val) . "%'" .$collate;
                break;
            case "backward":
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "'" .$collate;
                break;
            default:
                $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "%'" .$collate;
                break;
        }
    }

    /**
     * Define a WHERE IN clause
     * @param String $col Column name
     * @param Mixed $val Value that should be matched
     * @return void
     */
    public function where_in($col, $values)
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
        }
        $this->where .= $this->escape_columns($col) . "IN ";
        $this->where .= $this->prepare_data($values, "values");
    }

    /**
     * Define a WHERE IN clause that deals with hex->binary conversion
     * @param String $col Column name
     * @param Mixed $val Value that should be matched
     * @return void
     */
    public function where_in_hex($col, $values)
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        elseif ($this->where_group)
        {
            $this->where .= "";
            $this->where_group = FALSE;
        }
        else
        {
            $this->where .= " AND ";
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

        $this->where .= $this->escape_columns($col) . "IN ";
        $this->where .= $this->prepare_data($values, "values");
    }

    /**
     * Define a ORDER BY clause
     * @param String $col Column name
     * @param String $order Order ASCending or DESCending
     * @return void
     */
    public function order_by($col, $order = "ASC")
    {
        if ($this->order == "")
        {
            $this->order = " ORDER BY ";
        }
        else
        {
            $this->order .= ", ";
        }
        $this->order .= $this->escape_columns($col) . "$order";
    }

    /**
     * Define a GROUP BY clause
     * @param String $group Column to group
     * @return void
     */
    public function group_by($group)
    {
        if ($this->group == "")
        {
            $this->group = " GROUP BY ";
        }
        else
        {
            $this->group .= ", ";
        }
        $this->group .= $this->escape_columns($group);
    }

    /**
     * Define a LIMIT clause
     * @param String $count The amount of elements to retrieve
     * @param String $start Start retrieving elements from a sepcific index
     * @return void
     */
    public function limit($count, $start = "")
    {
        if ($start == "")
        {
            $this->limit = " LIMIT $count";
        }
        else
        {
            $this->limit = " LIMIT $start,$count";
        }
    }

    /**
     * Define a UNION statement
     * @param String $from table name to select from for the first query
     * @return void
     */
    public function union($from)
    {
        $this->union = $this->preliminary_query($from) . " UNION ";
        $this->limit = "";
        $this->where = "";
        $this->select = "";
        $this->order = "";
        $this->group = "";
    }

    /**
     * Define an INSERT statement
     * @param String $table The table to insert into
     * @param Mixed $data The data to insert
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
            $sql .= $this->prepare_data($data,"keys");
            $sql .= "VALUES ";
            $sql .= $this->prepare_data($data,"values");
            $sql .= ";";
            return $this->query($sql,false);
        }
    }

    /**
     * Define a REPLACE statement
     * @param String $table The table to insert into
     * @param Mixed $data The data to insert
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
            $sql .= $this->prepare_data($data,"keys");
            $sql .= "VALUES ";
            $sql .= $this->prepare_data($data,"values");
            $sql .= ";";
            return $this->query($sql,false);
        }
    }

    /**
     * Define an UPDATE statement
     * @param String $table The table to update
     * @param Mixed $data The updated data
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
                $sql .= "`$key` = '" . $this->escape_string($value) . "',";
            }
            $sql = substr_replace($sql, " ", strripos($sql, ","));
            return $this->query($sql, false);
        }
    }

    /**
     * Define a DELETE statement
     * @param String $table The table to update
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
            return $this->query($sql,false);
        }
    }

    /**
     * Start Transaction mode by disabling autocommit
     * @return Boolean True on success and false on failure
     */
    public function begin_transaction()
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_autocommit($this->res,FALSE))
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
     * Commit previous queries of a transaction
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
     * Rollback to the state of the database of the last commit or before the begin
     * of the transaction
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
     * End Transaction, commit remaining uncommitted queries
     * @return Boolean True on success and False on failure
     */
    public function end_transaction()
    {
        if ($this->commit() && mysqli_autocommit($this->res,TRUE))
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
     * Change the default database for the current connection
     * @param String $db New default database
     * @return Boolean True on success, False on Failure
     */
    public function change_database($db)
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->connected && mysqli_select_db($this->res,$db))
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Delete a view in the database
     * @param String $view Name of the view
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
            $sql = "DROP VIEW " . $this->escape_string($view);
            return $this->query($sql);
        }
    }

    /**
     * Create a view in the database
     * @param String $name Name of the view
     * @param String $from Name of the first table used in the from clause for the view definition
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
            $sql = "CREATE VIEW " . $this->escape_string($name) . " AS ";
            $sql .= $this->preliminary_query($from);
            return $this->query($sql);
        }
    }

    /**
     * Prepare, escape, error-check the values we are about to use in a SQL query
     * @param Mixed $data The data to prepare
     * @param String $type Whether we prepare 'keys' or 'values'
     * @return String key/value list
     */
    private function prepare_data($data,$type)
    {
        if (is_array($data))
        {
            if ($type == "keys")
            {
                $array = array_keys($data);
                $char = "`";
            }
            else
            {
                $array = array_values($data);
                $char = "'";
            }
        }
        else
        {
            $array['0'] = $data;
            $char = "'";
        }

        $list = "(";
        $unhex_pattern = "/UNHEX\('[0-9a-fA-F]{32}'\)/";    //The value must be a proper hexadecimal value well formatted -> "UNHEX('hex_value')"

        foreach ($array as $value)
        {
            if(($type != "keys") && (preg_match($unhex_pattern, $value) != FALSE))
            {
                $list .= $value." ,";
            }
            else
            {
                $list .= $char . $this->escape_string($value) . $char . ",";
            }
        }
        $list = substr_replace($list, ") ", strripos($list, ","));
        return $list;
    }

    /**
     * Escape a string to be used in a SQL query
     * @param String $string The string to escape
     * @return Mixed the escaped string, False on connection error
     */
    private function escape_string($string)
    {
        if (!$this->connected)
        {
            $this->connect();
        }
        if ($this->connected)
        {
            return mysqli_real_escape_string($this->res, $string);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Escape column names
     * @param String $col Column
     * @return String escaped column list
     */
    private function escape_columns($col)
    {
        $parts = explode(".", $col);
        $col = "";
        foreach ($parts AS $part)
        {
            $col .= "`" . trim($part) . "`.";
        }
        $col = substr_replace($col, " ", strripos($col, "."));
        return $col;
    }

    /**
     * Escape column names for statements using the "AS" operator
     * @param String $cols Column(s)
     * @return String escaped column list
     */
    private function escape_as($cols, $hex = FALSE)
    {
        $cols = explode(",", $cols);
        $string = "";
        foreach ($cols AS $value)
        {
            if (strpos($value, " AS "))
            {
                $col = explode(" AS ",$value);
                if ($hex)
                {
                    $string .= "HEX(" . $this->escape_columns($col[0]) . ") AS `" . trim($col[1]) . "`, ";
                }
                else
                {
                    $string .= $this->escape_columns($col[0]) . " AS `" . trim($col[1]) . "`, ";
                }
            }
            elseif (strpos($value, " as "))
            {
                $col = explode(" as ",$value);
                if ($hex)
                {
                    $string .= "HEX(" . $this->escape_columns($col[0]) . ") AS `" . trim($col[1]) . "`, ";
                }
                else
                {
                    $string .= $this->escape_columns($col[0]) . " AS `" . trim($col[1]) . "`, ";
                }
            }
            elseif (trim($value) == "*")
            {
                $string .= trim($value) . ", ";
            }
            else
            {
                if ($hex)
                {
                    $string .= " HEX(" . $this->escape_columns(trim($value)) . ") AS `" . trim($value) . "`, ";
                }
                else
                {
                    $string .= $this->escape_columns(trim($value)) . ", ";
                }
            }
        }
        $string = substr_replace($string, " ", strripos($string, ","));
        return $string;
    }

    /**
     * Escape column names for "ON"-using statements
     * @param String $string comparison string
     * @return String escaped column list
     */
    private function escape_on($string)
    {
        $parts = explode("=", $string);
        $return = $this->escape_columns($parts[0]) . " = " . $this->escape_columns($parts[1]);
        return $return;
    }

     /**
     * Generate and return UUID
     * @return Mixed $return hex UUID on success, FALSE on failure
     */
    public function generate_uuid()
    {
        $sql = "SELECT ".$this->gen_uuid_hex." AS UUID;";
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
