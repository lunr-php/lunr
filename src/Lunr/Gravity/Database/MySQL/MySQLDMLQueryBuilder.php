<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This is a SQL query builder class for generating queries
 * suitable for either MySQL or MariaDB.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 */
class MySQLDMLQueryBuilder extends DatabaseDMLQueryBuilder
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Define the mode of the DELETE clause.
     *
     * @param String $mode The delete mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function delete_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'LOW_PRIORITY':
            case 'QUICK':
            case 'IGNORE':
                $this->delete_mode[] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define a DELETE clause.
     *
     * @param String $delete The tables to delete from
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function delete($delete = '')
    {
        $this->sql_delete($delete);
        return $this;
    }

    /**
     * Define the mode of the INSERT clause.
     *
     * @param String $mode The insert mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function insert_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'IGNORE':
                $this->insert_mode['errors'] = $mode;
                break;
            case 'HIGH_PRIORITY':
            case 'LOW_PRIORITY':
            case 'DELAYED':
                $this->insert_mode['priority'] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param String $mode The replace mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function replace_mode($mode)
    {
        return $this->insert_mode($mode);
    }

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param String $table Table reference
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function into($table)
    {
        $this->sql_into($table);
        return $this;
    }

    /**
     * Define a Select statement for Insert statement.
     *
     * @param String $select SQL Select statement to be used in Insert
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public function select_statement($select)
    {
        $this->sql_select_statement($select);
        return $this;
    }

    /**
     * Define SET clause of the SQL statement.
     *
     * @param Array $set Array containing escaped key->value pairs to be set
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function set($set)
    {
        $this->sql_set($set);
        return $this;
    }

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param Array $keys Array containing escaped field names to be set
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public function column_names($keys)
    {
        $this->sql_column_names($keys);
        return $this;
    }

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param Array $values Array containing escaped values to be set
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public function values($values)
    {
        $this->sql_values($values);
        return $this;
    }

    /**
     * Define the mode of the SELECT clause.
     *
     * @param String $mode The select mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'ALL':
            case 'DISTINCT':
            case 'DISTINCTROW':
                $this->select_mode['duplicates'] = $mode;
                break;
            case 'SQL_CACHE':
            case 'SQL_NO_CACHE':
                $this->select_mode['cache'] = $mode;
                break;
            case 'HIGH_PRIORITY':
            case 'STRAIGHT_JOIN':
            case 'SQL_SMALL_RESULT':
            case 'SQL_BIG_RESULT':
            case 'SQL_BUFFER_RESULT':
            case 'SQL_CALC_FOUND_ROWS':
                $this->select_mode[] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define a SELECT clause.
     *
     * @param String $select The column(s) to select
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select($select)
    {
        $this->sql_select($select);
        return $this;
    }

    /**
     * Define the mode of the UPDATE clause.
     *
     * @param String $mode The update mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function update_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'LOW_PRIORITY':
            case 'IGNORE':
                $this->update_mode[] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define a UPDATE clause.
     *
     * @param String $table The table to update
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function update($table)
    {
        $this->sql_update($table);
        return $this;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table_reference Table reference
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function from($table_reference, $index_hints = NULL)
    {
        $this->sql_from($table_reference, $index_hints);
        return $this;
    }

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param String $table_reference Table reference
     * @param String $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function join($table_reference, $type = 'INNER', $index_hints = NULL)
    {
        $this->sql_join($table_reference, $type, $index_hints);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on($left, $right, $operator = '=')
    {
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_like($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with IN comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_in($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $lower  The lower bound of the between condition
     * @param String $upper  The upper bound of the between condition
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE)
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Open ON group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function start_on_group()
    {
        $this->sql_group_start('ON');
        return $this;
    }

    /**
     * Close ON group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function end_on_group()
    {
        $this->sql_group_end('ON');
        return $this;
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where($left, $right, $operator = '=')
    {
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the IN condition of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_in($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $lower  The lower bound of the between condition
     * @param String $upper  The upper bound of the between condition
     * @param String $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE)
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define WHERE clause with the REGEXP condition of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Open WHERE group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function start_where_group()
    {
        $this->sql_group_start();
        return $this;
    }

    /**
     * Close WHERE group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function end_where_group()
    {
        $this->sql_group_end();
        return $this;
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param String  $expr  Expression to group by
     * @param Boolean $order Order ASCending/TRUE or DESCending/FALSE, default no order/NULL
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->sql_group_by($expr);

        if($order !== NULL && is_bool($order))
        {
            $direction       = ($order === TRUE) ? ' ASC' : ' DESC';
            $this->group_by .= $direction;
        }

        return $this;
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having($left, $right, $operator = '=')
    {
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with IN comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_in($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'IN' : 'NOT IN';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with BETWEEN comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $lower  The lower bound of the between condition
     * @param String $upper  The upper bound of the between condition
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_between($left, $lower, $upper, $negate = FALSE)
    {
        $right    = $lower . ' AND ' . $upper;
        $operator = ($negate === FALSE) ? 'BETWEEN' : 'NOT BETWEEN';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define HAVING clause with REGEXP comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Open HAVING group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function start_having_group()
    {
        $this->sql_group_start('HAVING');
        return $this;
    }

    /**
     * Close HAVING group.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function end_having_group()
    {
        $this->sql_group_end('HAVING');
        return $this;
    }

    /**
     * Define ORDER BY clause in the SQL statement.
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function order_by($expr, $asc = TRUE)
    {
        $this->sql_order_by($expr, $asc);
        return $this;
    }

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param Integer $amount The amount of elements to retrieve
     * @param Integer $offset Start retrieving elements from a specific index
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function limit($amount, $offset = -1)
    {
        $this->sql_limit($amount, $offset);
        return $this;
    }

    /**
     * Define a UNION or UNION ALL clause of the SQL statement.
     *
     * @param String  $sql_query sql query reference
     * @param Boolean $all       True for ALL or False for empty (default).
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function union($sql_query, $all = FALSE)
    {
        $base = ($all === TRUE) ? 'UNION ALL' : 'UNION';
        $this->sql_compound($sql_query, $base);
        return $this;
    }

    /**
     * Define the lock mode for a transaction.
     *
     * @param String $mode The lock mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function lock_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'FOR UPDATE':
            case 'LOCK IN SHARE MODE':
                $this->lock_mode = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Set logical connector 'AND'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_and()
    {
        $this->sql_connector('AND');
        return $this;
    }

    /**
     * Set logical connector 'OR'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_or()
    {
        $this->sql_connector('OR');
        return $this;
    }

    /**
     * Set logical connector 'XOR'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_xor()
    {
        $this->sql_connector('XOR');
        return $this;
    }

}

?>
