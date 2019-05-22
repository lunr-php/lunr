<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DMLQueryBuilderInterface;

/**
 * This is a SQL query builder class for generating queries
 * suitable for either MySQL or MariaDB, performing automatic escaping
 * of input values where appropriate.
 */
class MySQLSimpleDMLQueryBuilder implements DMLQueryBuilderInterface
{

    /**
     * Instance of the MySQLDMLQueryBuilder class
     * @var MySQLDMLQueryBuilder
     */
    protected $builder;

    /**
     * Instance of the MySQLQueryEscaper class.
     * @var MySQLQueryEscaper
     */
    protected $escaper;

    /**
     * Constructor.
     *
     * @param MySQLDMLQueryBuilder $builder Instance of the MySQLDMLQueryBuilder class
     * @param MySQLQueryEscaper    $escaper Instance of the MySQLQueryEscaper class
     */
    public function __construct($builder, $escaper)
    {
        $this->builder = $builder;
        $this->escaper = $escaper;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->builder);
        unset($this->escaper);
    }

    /**
     * Construct and return a SELECT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_select_query()
    {
        return $this->builder->get_select_query();
    }

    /**
     * Construct and return a INSERT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_insert_query()
    {
        return $this->builder->get_insert_query();
    }

    /**
     * Construct and return an UPDATE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_update_query()
    {
        return $this->builder->get_update_query();
    }

    /**
     * Construct and return a DELETE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_delete_query()
    {
        return $this->builder->get_delete_query();
    }

    /**
     * Construct and return a REPLACE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_replace_query()
    {
        return $this->builder->get_replace_query();
    }

    /**
     * Define the mode of the SELECT clause.
     *
     * @param string $mode The select mode you want to use
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function select_mode($mode)
    {
        $this->builder->select_mode($mode);
        return $this;
    }

    /**
     * Define the mode of the INSERT clause.
     *
     * @param string $mode The insert mode you want to use
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function insert_mode($mode)
    {
        $this->builder->insert_mode($mode);
        return $this;
    }

    /**
     * Define the mode of the DELETE clause.
     *
     * @param string $mode The delete mode you want to use
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function delete_mode($mode)
    {
        $this->builder->delete_mode($mode);
        return $this;
    }

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param string $mode The replace mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function replace_mode($mode)
    {
        $this->builder->replace_mode($mode);
        return $this;
    }

    /**
     * Define the lock mode for a transaction.
     *
     * @param string $mode The lock mode you want to use
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function lock_mode($mode)
    {
        $this->builder->lock_mode($mode);
        return $this;
    }

    /**
     * Define a DELETE clause.
     *
     * @param string $delete The table references to delete from
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function delete($delete)
    {
        $this->builder->delete($delete);
        return $this;
    }

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param string $table Table reference
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function into($table)
    {
        $table = $this->escaper->table($table);
        $this->builder->into($table);

        return $this;
    }

    /**
     * Define SET clause of the SQL statement.
     *
     * @param array $set Array containing escaped key->value pairs to be set
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function set($set)
    {
        $this->builder->set($set);
        return $this;
    }

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param array $keys Array containing escaped field names to be set
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function column_names($keys)
    {
        $keys = array_map([ $this->escaper, 'column' ], $keys);
        $this->builder->column_names($keys);

        return $this;
    }

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param array $values Array containing escaped values to be set
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function values($values)
    {
        $this->builder->values($values);
        return $this;
    }

    /**
     * Define a Select statement for Insert statement.
     *
     * @param string $select SQL Select statement to be used in Insert
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function select_statement($select)
    {
        $this->builder->select_statement($select);
        return $this;
    }

    /**
     * Define a UPDATE clause.
     *
     * @param string $table_references The tables to update
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function update($table_references)
    {
        $tables = '';

        foreach (explode(',', $table_references) as $table)
        {
            $tables .= $this->escape_alias($table, TRUE) . ', ';
        }

        $this->builder->update(rtrim($tables, ', '));
        return $this;
    }

    /**
     * Define a SELECT clause.
     *
     * @param string $select The column(s) to select
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function select($select)
    {
        $columns = '';

        foreach (explode(',', $select) as $column)
        {
            $columns .= $this->escape_alias($column, FALSE) . ', ';
        }

        $this->builder->select(rtrim($columns, ', '));
        return $this;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function from($table_reference, $index_hints = NULL)
    {
        $this->builder->from($this->escape_alias($table_reference), $index_hints);
        return $this;
    }

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param string $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function join($table_reference, $type = 'INNER', $index_hints = NULL)
    {
        $this->builder->join($this->escape_alias($table_reference), $type, $index_hints);
        return $this;
    }

    /**
     * Define USING part of the SQL statement.
     *
     * @param string $column_list Columns to use.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function using($column_list)
    {
        $columns = '';

        foreach (explode(',', $column_list) as $column)
        {
            $columns .= $this->escaper->column(trim($column)) . ', ';
        }

        $this->builder->using(rtrim($columns, ', '));
        return $this;
    }

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on($left, $right, $operator = '=')
    {
        $this->builder->on($this->escaper->column($left), $this->escaper->column($right), $operator);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on_like($left, $right, $negate = FALSE)
    {
        $this->builder->on_like($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param array  $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on_in($left, $right, $negate = FALSE)
    {
        $right = array_map([$this->escaper, 'value'], $right);

        $this->builder->on_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        $this->builder->on_between($left, $lower, $upper, $negate);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        $this->builder->on_regexp($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define ON part of a JOIN clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function on_null($left, $negate = FALSE)
    {
        $this->builder->on_null($this->escaper->column($left), $negate);
        return $this;
    }

    /**
     * Open ON group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function start_on_group()
    {
        $this->builder->start_on_group();
        return $this;
    }

    /**
     * Close ON group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function end_on_group()
    {
        $this->builder->end_on_group();
        return $this;
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where($left, $right, $operator = '=')
    {
        $this->builder->where($this->escaper->column($left), $this->escaper->value($right), $operator);
        return $this;
    }

    /**
     * Open WHERE group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function start_where_group()
    {
        $this->builder->start_where_group();
        return $this;
    }

    /**
     * Close WHERE group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function end_where_group()
    {
        $this->builder->end_where_group();
        return $this;
    }

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE)
    {
        $this->builder->where_like($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define WHERE clause with the IN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param array  $right  Right expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where_in($left, $right, $negate = FALSE)
    {
        $right = array_map([$this->escaper, 'value'], $right);

        $this->builder->where_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
        return $this;
    }

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        $this->builder->where_between($left, $lower, $upper, $negate);
        return $this;
    }

    /**
     * Define WHERE clause with the REGEXP condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where_regexp($left, $right, $negate = FALSE)
    {
        $this->builder->where_regexp($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define WHERE clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function where_null($left, $negate = FALSE)
    {
        $this->builder->where_null($this->escaper->column($left), $negate);
        return $this;
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param string  $expr  Expression to group by
     * @param boolean $order Order ASCending/TRUE or DESCending/FALSE, default no order/NULL
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->builder->group_by($this->escaper->column($expr), $order);
        return $this;
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having($left, $right, $operator = '=')
    {
        $this->builder->having($this->escaper->column($left), $this->escaper->value($right), $operator);
        return $this;
    }

    /**
     * Set logical connector 'AND'.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function sql_and()
    {
        $this->builder->sql_and();
        return $this;
    }

    /**
     * Set logical connector 'OR'.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function sql_or()
    {
        $this->builder->sql_or();
        return $this;
    }

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE)
    {
        $this->builder->having_like($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define HAVING clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param array  $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having_in($left, $right, $negate = FALSE)
    {
        $right = array_map([$this->escaper, 'value'], $right);

        $this->builder->having_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
        return $this;
    }

    /**
     * Define HAVING clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        $this->builder->having_between($left, $lower, $upper, $negate);
        return $this;
    }

    /**
     * Define HAVING clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        $this->builder->having_regexp($this->escaper->column($left), $right, $negate);
        return $this;
    }

    /**
     * Define HAVING clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function having_null($left, $negate = FALSE)
    {
        $this->builder->having_null($this->escaper->column($left), $negate);
        return $this;
    }

    /**
     * Open having group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function start_having_group()
    {
        $this->builder->start_having_group();
        return $this;
    }

    /**
     * Close having group.
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function end_having_group()
    {
        $this->builder->end_having_group();
        return $this;
    }

    /**
     * Define ORDER BY clause in the SQL statement.
     *
     * @param string  $expr Expression to order by
     * @param boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function order_by($expr, $asc = TRUE)
    {
        $this->builder->order_by($this->escaper->column($expr), $asc);
        return $this;
    }

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param integer $amount The amount of elements to retrieve
     * @param integer $offset Start retrieving elements from a specific index
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function limit($amount, $offset = -1)
    {
        $this->builder->limit($this->escaper->intvalue($amount), $this->escaper->intvalue($offset));
        return $this;
    }

    /**
     * Define a UNION or UNION ALL clause of the SQL statement.
     *
     * @param string  $sql_query SQL query reference
     * @param boolean $all       True for ALL or False for empty (default).
     *
     * @return MySQLSimpleDMLQueryBuilder $self Self reference
     */
    public function union($sql_query, $all = FALSE)
    {
        $this->builder->union($this->escaper->query_value($sql_query), $all);
        return $this;
    }

    /**
     * Define a with clause.
     *
     * @param string $alias        The alias of the WITH statement
     * @param string $sql_query    Sql query reference
     * @param array  $column_names An optional parameter to give the result columns a name
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function with($alias, $sql_query, $column_names = NULL)
    {
        $this->builder->with($alias, $sql_query, $column_names);
        return $this;
    }

    /**
     * Define a recursive WITH clause.
     *
     * @param string  $alias           The alias of the WITH statement
     * @param string  $anchor_query    The initial select statement
     * @param string  $recursive_query The select statement that selects recursively out of the initial query
     * @param boolean $union_all       True for UNION ALL false for UNION
     * @param array   $column_names    An optional parameter to give the result columns a name
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function with_recursive($alias, $anchor_query, $recursive_query, $union_all = FALSE, $column_names = NULL)
    {
        $this->builder->with_recursive($alias, $anchor_query, $recursive_query, $union_all, $column_names);
        return $this;
    }

    /**
     * Set ON DUPLICATE KEY UPDATE clause.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_duplicate_key_update($set)
    {
        $this->builder->on_duplicate_key_update($set);
        return $this;
    }

    /**
     * Escape a table reference.
     *
     * @param string  $location_reference A location reference
     * @param boolean $table              Whether to escape a table or a result_column
     *
     * @return string $escaped Escaped location reference
     */
    protected function escape_alias($location_reference, $table = TRUE)
    {
        $method = $table ? 'table' : 'result_column';

        if (strpos($location_reference, ' AS '))
        {
            $parts = explode(' AS ', $location_reference);
            return $this->escaper->{$method}($parts[0], $parts[1]);
        }
        elseif (strpos($location_reference, ' as '))
        {
            $parts = explode(' as ', $location_reference);
            return $this->escaper->{$method}($parts[0], $parts[1]);
        }
        else
        {
            return $this->escaper->{$method}($location_reference);
        }
    }

}

?>
