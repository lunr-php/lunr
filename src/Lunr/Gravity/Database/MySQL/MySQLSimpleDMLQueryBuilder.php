<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

/**
 * This is a SQL query builder class for generating queries
 * suitable for either MySQL or MariaDB, performing automatic escaping
 * of input values where appropriate.
 */
class MySQLSimpleDMLQueryBuilder
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
     * Define INTO clause of the SQL statement.
     *
     * @param string $table Table reference
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function into($table)
    {
        $table = $this->escaper->table($table);
        return $this->builder->into($table);
    }

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param array $keys Array containing escaped field names to be set
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function column_names($keys)
    {
        $keys = array_map([ $this->escaper, 'column' ], $keys);
        return $this->builder->column_names($keys);
    }

    /**
     * Define a UPDATE clause.
     *
     * @param string $table_references The tables to update
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function update($table_references)
    {
        $tables = '';

        foreach (explode(',', $table_references) as $table)
        {
            $tables .= $this->escape_alias($table, TRUE) . ', ';
        }

        return $this->builder->update(rtrim($tables, ', '));
    }

    /**
     * Define a SELECT clause.
     *
     * @param string $select The column(s) to select
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select($select)
    {
        $columns = '';

        foreach (explode(',', $select) as $column)
        {
            $columns .= $this->escape_alias($column, FALSE) . ', ';
        }

        return $this->builder->select(rtrim($columns, ', '));
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function from($table_reference, $index_hints = NULL)
    {
        return $this->builder->from($this->escape_alias($table_reference), $index_hints);
    }

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param string $table_reference Table reference
     * @param string $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function join($table_reference, $type = 'INNER', $index_hints = NULL)
    {
        return $this->builder->join($this->escape_alias($table_reference), $type, $index_hints);
    }

    /**
     * Define USING part of the SQL statement.
     *
     * @param string $column_list Columns to use.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function using($column_list)
    {
        $columns = '';

        foreach (explode(',', $column_list) as $column)
        {
            $columns .= $this->escaper->column(trim($column)) . ', ';
        }

        return $this->builder->using(rtrim($columns, ', '));
    }

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on($left, $right, $operator = '=')
    {
        return $this->builder->on($this->escaper->column($left), $this->escaper->column($right), $operator);
    }

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_like($left, $right, $negate = FALSE)
    {
        return $this->builder->on_like($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define ON part of a JOIN clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_in($left, $right, $negate = FALSE)
    {
        return $this->builder->on_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
    }

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        return $this->builder->on_between($left, $lower, $upper, $negate);
    }

    /**
     * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        return $this->builder->on_regexp($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define ON part of a JOIN clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_null($left, $negate = FALSE)
    {
        return $this->builder->on_null($this->escaper->column($left), $negate);
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where($left, $right, $operator = '=')
    {
        return $this->builder->where($this->escaper->column($left), $this->escaper->value($right), $operator);
    }

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE)
    {
        return $this->builder->where_like($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define WHERE clause with the IN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_in($left, $right, $negate = FALSE)
    {
        return $this->builder->where_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
    }

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        return $this->builder->where_between($left, $lower, $upper, $negate);
    }

    /**
     * Define WHERE clause with the REGEXP condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_regexp($left, $right, $negate = FALSE)
    {
        return $this->builder->where_regexp($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define WHERE clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_null($left, $negate = FALSE)
    {
        return $this->builder->where_null($this->escaper->column($left), $negate);
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param string  $expr  Expression to group by
     * @param boolean $order Order ASCending/TRUE or DESCending/FALSE, default no order/NULL
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        return $this->builder->group_by($this->escaper->column($expr), $order);
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having($left, $right, $operator = '=')
    {
        return $this->builder->having($this->escaper->column($left), $this->escaper->value($right), $operator);
    }

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE)
    {
        return $this->builder->having_like($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define HAVING clause with IN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_in($left, $right, $negate = FALSE)
    {
        return $this->builder->having_in($this->escaper->column($left), $this->escaper->list_value($right), $negate);
    }

    /**
     * Define HAVING clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_between($left, $lower, $upper, $negate = FALSE)
    {
        $left  = $this->escaper->column($left);
        $lower = $this->escaper->value($lower);
        $upper = $this->escaper->value($upper);

        return $this->builder->having_between($left, $lower, $upper, $negate);
    }

    /**
     * Define HAVING clause with REGEXP comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        return $this->builder->having_regexp($this->escaper->column($left), $right, $negate);
    }

    /**
     * Define HAVING clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_null($left, $negate = FALSE)
    {
        return $this->builder->having_null($this->escaper->column($left), $negate);
    }

    /**
     * Define ORDER BY clause in the SQL statement.
     *
     * @param string  $expr Expression to order by
     * @param boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function order_by($expr, $asc = TRUE)
    {
        return $this->builder->order_by($this->escaper->column($expr), $asc);
    }

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param integer $amount The amount of elements to retrieve
     * @param integer $offset Start retrieving elements from a specific index
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function limit($amount, $offset = -1)
    {
        return $this->builder->limit($this->escaper->intvalue($amount), $this->escaper->intvalue($offset));
    }

    /**
     * Define a UNION or UNION ALL clause of the SQL statement.
     *
     * @param string  $sql_query SQL query reference
     * @param boolean $all       True for ALL or False for empty (default).
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function union($sql_query, $all = FALSE)
    {
        return $this->builder->union($this->escaper->query_value($sql_query), $all);
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
