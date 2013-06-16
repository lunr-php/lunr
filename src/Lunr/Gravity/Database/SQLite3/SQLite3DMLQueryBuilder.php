<?php

/**
 * SQLite3 database query builder class.
 *
 * PHP Version 5.3
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3;

use Lunr\Gravity\Database\DatabaseDMLQueryBuilder;

/**
 * This is a SQL query builder class for generating queries suitable for SQLite3.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class SQLite3DMLQueryBuilder extends DatabaseDMLQueryBuilder
{

    /**
     * The left identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_L = '"';

    /**
     * The right identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_R = '"';

    /**
     * Shared instance of the SQLite3Connection class.
     * @var SQLite3Connection
     */
    protected $db;

    /**
     * Constructor.
     *
     * @param SQLite3Connection $db Shared instance of the SQLite3Connection class.
     */
    public function __construct($db)
    {
        parent::__construct();

        $this->db = $db;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->db);
        parent::__destruct();
    }

    /**
     * Construct and return a INSERT query.
     *
     * @return String $query The constructed query string.
     */
    public function get_insert_query()
    {
        if ($this->into == '')
        {
            return '';
        }

        $components   = array();
        $components[] = 'insert_mode';
        $components[] = 'into';
        $components[] = 'column_names';

        if ($this->select_statement != '')
        {
            $components[] = 'select_statement';
        }
        else
        {
            $components[] = 'values';
        }

        return 'INSERT ' . $this->implode_query($components);
    }

    /**
     * Construct and return a REPLACE query.
     *
     * @return String $query The constructed query string.
     */
    public function get_replace_query()
    {
        if ($this->into == '')
        {
            return '';
        }

        $components   = array();
        $components[] = 'into';
        $components[] = 'column_names';

        if ($this->select_statement != '')
        {
            $components[] = 'select_statement';
        }
        else
        {
            $components[] = 'values';
        }

        return 'REPLACE ' . $this->implode_query($components);
    }

    /**
     * Define and escape input as value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Unused with SQLite
     *
     * @return String $return Defined and escaped value
     */
    public function value($value, $collation = '', $charset = '')
    {
        return trim($this->collate('\'' . $this->db->escape_string($value) . '\'', $collation));
    }

    /**
     * Not supported by sqlite. Returns the same as value
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Unused with SQLite
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '')
    {
        return $this->value($value, $collation, $charset);
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $match     Whether to match forward, backward or both
     * @param String $collation Collation name
     * @param String $charset   Unused with SQLite
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function likevalue($value, $match = 'both', $collation = '', $charset = '')
    {
        switch ($match)
        {
            case 'forward':
                $string = '\'' . $this->db->escape_string($value) . '%\'';
                break;
            case 'backward':
                $string = '\'%' . $this->db->escape_string($value) . '\'';
                break;
            case 'both':
            default:
                $string = '\'%' . $this->db->escape_string($value) . '%\'';
                break;
        }

        return trim($this->collate($string, $collation));
    }

    /**
     * Define and escape input as index hint.
     *
     * @param String $keyword Whether to use INDEXED BY or NOT INDEXED the index/indices
     * @param array  $indices Array of indices
     * @param String $for     Unused with SQLite
     *
     * @return mixed $return NULL for invalid indices, escaped string otherwise.
     */
    public function index_hint($keyword, $indices, $for = '')
    {
        if (!is_array($indices) || empty($indices))
        {
            return NULL;
        }

        $keyword = strtoupper($keyword);

        $valid_keywords = array('INDEXED BY', 'NOT INDEXED');

        if (!in_array($keyword, $valid_keywords))
        {
            $keyword = 'INDEXED BY';
        }

        $indices = array_map(array($this, 'escape_location_reference'), $indices);
        $indices = implode(', ', $indices);

        return $keyword . ' ' . $indices;
    }

    /**
     * Not supported by SQLite.
     *
     * @param String $mode The delete mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function delete_mode($mode)
    {
        return $this;
    }

    /**
     * Define a DELETE clause.
     *
     * @param String $delete The tables to delete from
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function insert_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'OR ROLLBACK':
            case 'OR ABORT':
            case 'OR REPLACE':
            case 'OR FAIL':
            case 'OR IGNORE':
                $this->insert_mode['mode'] = $mode;
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Not supported by sqlite.
     *
     * @param String $mode The replace mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function replace_mode($mode)
    {
        return $this;
    }

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param String $table Table reference
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function select_statement($select)
    {
        $this->sql_select_statement($select);
        return $this;
    }

    /**
     * Define SET clause of the SQL statement.
     *
     * For update only in SQLite.
     * For insert use SQLite3DMLQueryBuilder::column_names and SQLite3DMLQueryBuilder::values
     *
     * @param Array $set Array containing escaped key->value pairs to be set
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function select_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'ALL':
            case 'DISTINCT':
                $this->select_mode['duplicates'] = $mode;
                break;
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function update_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'OR ROLLBACK':
            case 'OR ABORT':
            case 'OR REPLACE':
            case 'OR FAIL':
            case 'OR IGNORE':
                $this->update_mode['mode'] = $mode;
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function from($table_reference, $index_hints = NULL)
    {
        $this->sql_from($table_reference, $index_hints);
        return $this;
    }

    /**
     * Define JOIN clause of the SQL statement,
     *
     * @param String $table_reference Table reference
     * @param String $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function on_between($left, $lower, $upper, $negate = FALSE)
    {
        $right = $lower . ' AND ' . $upper;
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function where_between($left, $lower, $upper, $negate = FALSE)
    {
        $right = $lower . ' AND ' . $upper;
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function where_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param String  $expr  Expression to group by
     * @param Boolean $order Not supported by SQLite
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->sql_group_by($expr);
        return $this;
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function having_between($left, $lower, $upper, $negate = FALSE)
    {
        $right = $lower . ' AND ' . $upper;
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define ORDER BY clause in the SQL statement.
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
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
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function limit($amount, $offset = -1)
    {
        $this->sql_limit($amount, $offset);
        return $this;
    }

    /**
     * Define a UNION or UNION ALL clause of the SQL statement
     *
     * @param String $sql_query   sql query reference
     * @param Boolean $all   True for ALL or False for empty (default).
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
     * Not supported by SQLite.
     *
     * @param String $mode The lock mode you want to use
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function lock_mode($mode)
    {
        return $this;
    }

    /**
     * Set logical connector 'AND'.
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function sql_and()
    {
        $this->sql_connector('AND');
        return $this;
    }

    /**
     * Set logical connector 'OR'.
     *
     * @return SQLite3DMLQueryBuilder $self Self reference
     */
    public function sql_or()
    {
        $this->sql_connector('OR');
        return $this;
    }

}

?>
