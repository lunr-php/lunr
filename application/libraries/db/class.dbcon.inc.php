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
     * Hostname of the database server
     * @var String
     */
    private $host;

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
     * Resource handler for the (established) database connection
     * @var Resource
     */
    private $res;

    /**
     * Connection status
     * @var Boolean
     */
    private $connected;

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
     * Constructor
     * automatically sets up mysql server-vars
     */
    public function __construct($db)
    {
        $this->host = $db['hostname'];
        $this->user = $db['username'];
        $this->pwd = $db['password'];
        $this->db = $db['database'];
        $this->select = "";
        $this->join = "";
        $this->where = "";
        $this->order = "";
        $this->group = "";
        $this->limit = "";
    }

    /**
     * Destructor
     * closes database connection if there is still one established
     */
    public function __destruct()
    {
        if ($this->connected)
        {
            $this->disconnect();
        }
        unset($this->host);
        unset($this->user);
        unset($this->pwd);
        unset($this->db);
        unset($this->res);
        unset($this->connected);
        unset($this->last_query);
        unset($this->select);
        unset($this->join);
        unset($this->where);
        unset($this->order);
        unset($this->group);
        unset($this->limit);
    }

    /**
     * Establishes a connection to the defined mysql-server
     * @return void
     */
    public function connect()
    {
        $this->res = mysqli_connect($this->host, $this->user, $this->pwd, $this->db);
        mysqli_set_charset($this->res, "utf8");
        $this->connected = TRUE;
    }

    /**
     * Disconnects from mysql-server
     * @return void
     */
    public function disconnect()
    {
        mysqli_close($this->res);
        $this->connected = FALSE;
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
     * Return the preliminary query, that would be executed by query() at this point
     * **DEBUG**
     * @param String $from Where to get the data from
     * @return String SQL query
     */
    public function preliminary_query($from)
    {
        $sql_command = "";

        if ($this->select != "")
        {
            $sql_command .= $this->select;
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

        return $sql_command;
    }

    /**
     * Executes a defined SQL query
     * @param String $sql_command Predefined SQL query
     * @param Boolean $return Return a Query Result
     * @return Mixed Query Result
     */
    public function query($sql_command, $return = true)
    {
        if (!$this->connected)
        {
            $this->connect();
        }

        if ($this->where != "")
        {
            $sql_command = $sql_command . $this->where;
            $this->where = "";
        }

        if ($this->group != "")
        {
            $sql_command = $sql_command . $this->group;
            $this->group = "";
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
        else{
            mysqli_query($this->res, $sql_command);
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
     * Define a WHERE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function where($col, $val, $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
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

        $this->where .= $this->escape_columns($col) . "= " . $base_charset . "'" . $this->escape_string($val) . "'" . $collate;
    }

    /**
     * Define a WHERE NOT clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function where_not($col, $val, $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
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

        $this->where .= $this->escape_columns($col) . "<> " . $base_charset . "'" . $this->escape_string($val) . "'" . $collate;
    }

    /**
     * Define a LIKE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function like($col, $val, $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
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

        $this->where .= $this->escape_columns($col) . " LIKE ".$base_charset . "'%" . $this->escape_string($val) . "%'" .$collate;
    }

    /**
     * Define a NOT LIKE clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function not_like($col, $val, $collate = "")
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
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

        $this->where .= $this->escape_columns($col) . " NOT LIKE " . $base_charset . "'%" . $this->escape_string($val) . "%'" .$collate;
    }

    /**
     * Define a WHERE IN clause
     * @param String $col Column name
     * @param String $val Value that should be matched
     * @param String $collate Specific collate used for comparison (optional)
     * @return void
     */
    public function where_in($col, $values)
    {
        if ($this->where == "")
        {
            $this->where = " WHERE ";
        }
        else
        {
            $this->where .= " AND ";
        }
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
     * Define an INSERT statement
     * @param String $table The table to insert into
     * @param Mixed $data The data to insert
     * @return void
     */
    public function insert($table, $data)
    {
        $sql  = "INSERT INTO `$table` ";
        $sql .= $this->prepare_data($data,"keys");
        $sql .= "VALUES ";
        $sql .= $this->prepare_data($data,"values");
        $sql .= ";";
        $this->query($sql,false);
    }

    /**
     * Define an UPDATE statement
     * @param String $table The table to update
     * @param Mixed $data The updated data
     * @return void
     */
    public function update($table, $data)
    {
        $sql = "UPDATE `$table` SET ";
        foreach ($data as $key => $value)
        {
            $sql .= "`$key` = '" . $this->escape_string($value) . "',";
        }
        $sql = substr_replace($sql, " ", strripos($sql, ","));
        $this->query($sql, false);
    }

    /**
     * Define a DELETE statement
     * @param String $table The table to update
     * @return void
     */
    public function delete($table)
    {
        $sql = "DELETE FROM `$table`";
        $this->query($sql,false);
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

        foreach ($array as $value)
        {
            $list .= $char . $this->escape_string($value) . $char . ",";
        }

        $list = substr_replace($list, ") ", strripos($list, ","));
        return $list;
    }

    /**
     * Escape a string to be used in a SQL query
     * @param String $string The string to escape
     * @return String the escaped string
     */
    private function escape_string($string)
    {
        if (!$this->connected)
        {
            $this->connect();
        }
        return mysqli_real_escape_string($this->res, $string);
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
            $col .= "`$part`.";
        }
        $col = substr_replace($col, " ", strripos($col, "."));
        return $col;
    }

    /**
     * Escape column names for statements using the "AS" operator
     * @param String $cols Column(s)
     * @return String escaped column list
     */
    private function escape_as($cols)
    {
        $cols = explode(",", $cols);
        $string = "";
        foreach ($cols AS $value)
        {
            if (strpos($value, " AS "))
            {
                $col = explode(" AS ",$value);
                $string .= " `" . $this->escape_columns($col[0]) . "` AS `" . $col[1] . "`, ";
            }
            elseif (strpos($value, " as "))
            {
                $col = explode(" as ",$value);
                $string .= " `" . $this->escape_columns($col[0]) . "` AS `" . $col[1] . "`, ";
            }
            else
            {
                $string .= " `$value`,";
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
}

?>
