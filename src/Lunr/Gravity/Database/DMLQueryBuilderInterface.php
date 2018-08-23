<?php

/**
 * DML query builder interface.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * This interface defines the DML query builder primitives.
 */
interface DMLQueryBuilderInterface
{

    /**
     * Construct and return a SELECT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_select_query();

    /**
     * Construct and return a DELETE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_delete_query();

    /**
     * Construct and return a INSERT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_insert_query();

    /**
     * Construct and return a REPLACE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_replace_query();

    /**
     * Construct and return an UPDATE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_update_query();

    /**
     * Define the mode of the DELETE clause.
     *
     * @param string $mode The delete mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function delete_mode($mode);

    /**
     * Define a DELETE clause.
     *
     * @param string $delete The table references to delete from
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function delete($delete);

    /**
     * Define the mode of the INSERT clause.
     *
     * @param string $mode The insert mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function insert_mode($mode);

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param string $mode The replace mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function replace_mode($mode);

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param string $table Table name
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function into($table);

    /**
     * Define a Select statement for Insert statement.
     *
     * @param string $select SQL Select statement to be used in Insert
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select_statement($select);

    /**
     * Define SET clause of the SQL statement.
     *
     * @param array $set Array containing escaped key->value pairs to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function set($set);

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param array $keys Array containing escaped field names to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function column_names($keys);

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param array $values Array containing escaped values to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function values($values);

    /**
     * Define the mode of the SELECT clause.
     *
     * @param string $mode The select mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select_mode($mode);

    /**
     * Define a SELECT clause.
     *
     * @param string $select The columns to select
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select($select);

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param string $table_reference Table name
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function from($table_reference);

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param string $table_reference Table reference to join with.
     * @param string $type            Type of JOIN operation to perform.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function join($table_reference, $type = 'INNER');

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return DMLQueryBuilder $self Self reference
     */
    public function on($left, $right, $operator = '=');

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function on_like($left, $right, $negate = FALSE);

    /**
    * Define ON part of a JOIN clause with IN comparator of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function on_in($left, $right, $negate = FALSE);

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function on_regexp($left, $right, $negate = FALSE);

    /**
     * Define ON part of a JOIN clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function on_null($left, $negate = FALSE);

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where($left, $right, $operator = '=');

    /**
     * Open WHERE group.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function start_where_group();

    /**
     * Close WHERE group.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function end_where_group();

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE);

    /**
    * Define WHERE clause with the IN condition of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the condition or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function where_in($left, $right, $negate = FALSE);

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $lower  The lower bound of the between condition
     * @param string $upper  The upper bound of the between condition
     * @param string $negate Whether to negate the condition or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define WHERE clause with the REGEXP condition of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the condition or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function where_regexp($left, $right, $negate = FALSE);

    /**
     * Define WHERE clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where_null($left, $negate = FALSE);

    /**
     * Define a GROUP BY clause of the SQL statement.
     *
     * @param string $expr Expression to group by
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function group_by($expr);

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function having($left, $right, $operator = '=');

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param string $left   Left expression
     * @param string $right  Right expression
     * @param string $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE);

    /**
    * Define HAVING clause with IN comparator of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function having_in($left, $right, $negate = FALSE);

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
    public function having_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define HAVING clause with REGEXP comparator of the SQL statement.
    *
    * @param string $left   Left expression
    * @param string $right  Right expression
    * @param string $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function having_regexp($left, $right, $negate = FALSE);

    /**
     * Define HAVING clause with the NULL condition.
     *
     * @param string $left   Left expression
     * @param string $negate Whether to negate the condition or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function having_null($left, $negate = FALSE);

    /**
     * Define a ORDER BY clause of the SQL statement.
     *
     * @param string  $expr Expression to order by
     * @param boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function order_by($expr, $asc = TRUE);

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param integer $amount The amount of elements to retrieve
     * @param integer $offset Start retrieving elements from a specific index
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function limit($amount, $offset = -1);

    /**
     * Define a UNION or UNION ALL clause of the SQL statement.
     *
     * @param string  $sql_query SQL query reference
     * @param boolean $all       True for ALL or False for empty (default).
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function union($sql_query, $all = FALSE);

    /**
     * Define the lock mode for a transaction.
     *
     * @param string $mode The lock mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function lock_mode($mode);

    /**
     * Set logical connector 'AND'.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function sql_and();

    /**
     * Set logical connector 'OR'.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function sql_or();

    /**
     * Define a with clause.
     *
     * @param string $alias        The alias of the WITH statement
     * @param string $sql_query    Sql query reference
     * @param array  $column_names An optional parameter to give the result columns a name
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function with($alias, $sql_query, $column_names = NULL);

    /**
     * Define a recursive WITH clause.
     *
     * @param String  $alias           The alias of the WITH statement
     * @param String  $anchor_query    The initial select statement
     * @param String  $recursive_query The select statement that selects recursively out of the initial query
     * @param Boolean $union_all       True for UNION ALL false for UNION
     * @param array   $column_names    An optional parameter to give the result columns a name
     *
     * @return SQLDMLQueryBuilder $self Self reference
     */
    public function with_recursive($alias, $anchor_query, $recursive_query, $union_all = FALSE, $column_names = NULL);

}

?>
