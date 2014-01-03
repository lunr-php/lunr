<?php

/**
 * DML query builder interface.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * This interface defines the DML query builder primitives.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
interface DMLQueryBuilderInterface
{

    /**
     * Define the mode of the DELETE clause.
     *
     * @param String $mode The delete mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function delete_mode($mode);

    /**
     * Define a DELETE clause.
     *
     * @param String $delete The table references to delete from
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function delete($delete);

    /**
     * Define the mode of the INSERT clause.
     *
     * @param String $mode The insert mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function insert_mode($mode);

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param String $mode The replace mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function replace_mode($mode);

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function into($table);

    /**
     * Define a Select statement for Insert statement.
     *
     * @param String $select SQL Select statement to be used in Insert
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select_statement($select);

    /**
     * Define SET clause of the SQL statement.
     *
     * @param Array $set Array containing escaped key->value pairs to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function set($set);

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param Array $keys Array containing escaped field names to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function column_names($keys);

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param Array $values Array containing escaped values to be set
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function values($values);

    /**
     * Define the mode of the SELECT clause.
     *
     * @param String $mode The select mode you want to use
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select_mode($mode);

    /**
     * Define a SELECT clause.
     *
     * @param String $select The columns to select
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function select($select);

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table_reference Table name
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function from($table_reference);

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param String $table_reference Table reference to join with.
     * @param String $type            Type of JOIN operation to perform.
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function join($table_reference, $type = 'INNER');

    /**
     * Define ON part of a JOIN clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return DMLQueryBuilder $self Self reference
     */
    public function on($left, $right, $operator = '=');

    /**
     * Define ON part of a JOIN clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function on_like($left, $right, $negate = FALSE);

    /**
    * Define ON part of a JOIN clause with IN comparator of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function on_in($left, $right, $negate = FALSE);

    /**
     * Define ON part of a JOIN clause with BETWEEN comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $lower  The lower bound of the between condition
     * @param String $upper  The upper bound of the between condition
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function on_regexp($left, $right, $negate = FALSE);

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where($left, $right, $operator = '=');

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE);

    /**
    * Define WHERE clause with the IN condition of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the condition or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function where_in($left, $right, $negate = FALSE);

    /**
     * Define WHERE clause with the BETWEEN condition of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $lower  The lower bound of the between condition
     * @param String $upper  The upper bound of the between condition
     * @param String $negate Whether to negate the condition or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define WHERE clause with the REGEXP condition of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the condition or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function where_regexp($left, $right, $negate = FALSE);

    /**
     * Define a GROUP BY clause of the SQL statement.
     *
     * @param String $expr Expression to group by
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function group_by($expr);

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function having($left, $right, $operator = '=');

    /**
     * Define HAVING clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE);

    /**
    * Define HAVING clause with IN comparator of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function having_in($left, $right, $negate = FALSE);

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
    public function having_between($left, $lower, $upper, $negate = FALSE);

    /**
    * Define HAVING clause with REGEXP comparator of the SQL statement.
    *
    * @param String $left   Left expression
    * @param String $right  Right expression
    * @param String $negate Whether to negate the comparison or not
    *
    * @return DMLQueryBuilderInterface $self Self reference
    */
    public function having_regexp($left, $right, $negate = FALSE);

    /**
     * Define a ORDER BY clause of the SQL statement.
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function order_by($expr, $asc = TRUE);

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param Integer $amount The amount of elements to retrieve
     * @param Integer $offset Start retrieving elements from a specific index
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function limit($amount, $offset = -1);

    /**
     * Define a UNION or UNION ALL clause of the SQL statement.
     *
     * @param String  $sql_query sql query reference
     * @param Boolean $all       True for ALL or False for empty (default).
     *
     * @return DMLQueryBuilderInterface $self Self reference
     */
    public function union($sql_query, $all = FALSE);

    /**
     * Define the lock mode for a transaction.
     *
     * @param String $mode The lock mode you want to use
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

}

?>
