<?php

/**
 * Abtract database query builder class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class defines abstract database query building.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 */
abstract class DatabaseDMLQueryBuilder
{

    /**
     * SQL Query part: SELECT clause
     * @var String
     */
    protected $select;

    /**
     * SQL Query part: SELECT mode
     * @var array
     */
    protected $select_mode;

    /**
     * SQL Query part: lock mode
     * @var String
     */
    protected $lock_mode;

    /**
     * SQL Query part: DELETE clause
     * @var String
     */
    protected $delete;

    /**
     * SQL Query part: DELETE mode
     * @var array
     */
    protected $delete_mode;

    /**
     * SQL Query part: FROM clause
     * @var String
     */
    protected $from;

    /**
     * SQL Query part: INTO clause
     * @var String
     */
    protected $into;

    /**
     * SQL Query part: INSERT modes
     * @var Array
     */
    protected $insert_mode;

    /**
     * SQL Query part: SET clause
     * @var String
     */
    protected $set;

    /**
     * SQL Query part: Column names
     * @var String
     */
    protected $column_names;

    /**
     * SQL Query part: VALUES
     * @var String
     */
    protected $values;

    /**
     * SQL Query part: SELECT statement
     * @var String
     */
    protected $select_statement;

    /**
     * SQL Query part: WHERE clause
     * @var String
     */
    protected $where;

    /**
     * SQL Query part: GROUP BY clause
     * @var String
     */
    protected $group_by;

    /**
     * SQL Query part: HAVING clause
     * @var String
     */
    protected $having;

    /**
     * SQL Query part: ORDER BY clause
     * @var String
     */
    protected $order_by;

    /**
     * SQL Query part: LIMIT clause
     * @var String
     */
    protected $limit;

    /**
     * SQL Query part: Logical connector of expressions
     * @var String
     */
    protected $connector;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->select           = '';
        $this->select_mode      = array();
        $this->delete           = '';
        $this->delete_mode      = array();
        $this->from             = '';
        $this->where            = '';
        $this->group_by         = '';
        $this->having           = '';
        $this->order_by         = '';
        $this->limit            = '';
        $this->connector        = '';
        $this->into             = '';
        $this->insert_mode      = array();
        $this->set              = '';
        $this->column_names     = '';
        $this->values           = '';
        $this->select_statement = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->select);
        unset($this->select_mode);
        unset($this->delete);
        unset($this->delete_mode);
        unset($this->from);
        unset($this->where);
        unset($this->group_by);
        unset($this->having);
        unset($this->order_by);
        unset($this->limit);
        unset($this->connector);
        unset($this->into);
        unset($this->insert_mode);
        unset($this->set);
        unset($this->column_names);
        unset($this->values);
        unset($this->select_statement);
    }

    /**
     * Construct and return a SELECT query.
     *
     * @return String $query The constructed query string.
     */
    public function get_select_query()
    {
        $components   = array();
        $components[] = 'select_mode';
        $components[] = 'select';
        $components[] = 'from';
        $components[] = 'where';
        $components[] = 'group_by';
        $components[] = 'having';
        $components[] = 'order_by';
        $components[] = 'limit';
        $components[] = 'lock_mode';

        if ($this->from == '')
        {
            return '';
        }

        return 'SELECT ' . $this->implode_query($components);
    }

    /**
     * Construct and return a DELETE query.
     *
     * @return String $query The constructed query string.
     */
    public function get_delete_query()
    {
        $components   = array();
        $components[] = 'delete_mode';
        if ($this->delete != '')
        {
            $components[] = 'delete';
            $components[] = 'from';
            $components[] = 'where';
        }
        else
        {
            $components[] = 'from';
            $components[] = 'where';
            $components[] = 'order_by';
            $components[] = 'limit';
        }

        if ($this->from == '')
        {
            return '';
        }

        return 'DELETE ' . $this->implode_query($components);
    }

    /**
     * Construct and return a INSERT query.
     *
     * @return String $query The constructed query string.
     */
    public function get_insert_query()
    {
        $components   = array();
        $components[] = 'insert_mode';
        $components[] = 'into';

        if ($this->select_statement != '')
        {
            $components[] = 'column_names';
            $components[] = 'select_statement';

            $valid = array(
                'HIGH_PRIORITY',
                'LOW_PRIORITY',
                'IGNORE'
            );

            $this->insert_mode = array_intersect($this->insert_mode, $valid);
        }
        else if ($this->set != '')
        {
            $components[] = 'set';
        }
        else
        {
            $components[] = 'column_names';
            $components[] = 'values';
        }

        if ($this->into == '')
        {
            return '';
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
        $components = array();

        $valid = array(
            'LOW_PRIORITY',
            'DELAYED'
        );

        $this->insert_mode = array_intersect($this->insert_mode, $valid);

        $components[] = 'insert_mode';
        $components[] = 'into';

        if ($this->select_statement != '')
        {
            $components[] = 'column_names';
            $components[] = 'select_statement';
        }
        else if ($this->set != '')
        {
            $components[] = 'set';
        }
        else
        {
            $components[] = 'column_names';
            $components[] = 'values';
        }

        if ($this->into == '')
        {
            return '';
        }

        return 'REPLACE ' . $this->implode_query($components);
    }

    /**
     * Define and escape input as column.
     *
     * @param String $name      Input
     * @param String $collation Collation name
     *
     * @return String $return Defined and escaped column name
     */
    public function column($name, $collation = '')
    {
        return trim($this->collate($this->escape_location_reference($name), $collation));
    }

    /**
     * Define and escape input as a result column.
     *
     * @param String $column Result column name
     * @param String $alias  Alias
     *
     * @return String $return Defined and escaped result column
     */
    public function result_column($column, $alias = '')
    {
        $column = $this->escape_location_reference($column);

        if ($alias === '' || $column === '*')
        {
            return $column;
        }
        else
        {
            return $column . ' AS `' . $alias . '`';
        }
    }

    /**
     * Define and escape input as a result column and transform values to hexadecimal.
     *
     * @param String $column Result column name
     * @param String $alias  Alias
     *
     * @return String $return Defined and escaped result column
     */
    public function hex_result_column($column, $alias = '')
    {
        $alias = ($alias === '') ? $column : $alias;
        return 'HEX(' . $this->escape_location_reference($column) . ') AS `' . $alias . '`';
    }

    /**
     * Define and escape input as table.
     *
     * @param String $table Table name
     * @param String $alias Alias
     *
     * @return String $return Defined and escaped table
     */
    public function table($table, $alias = '')
    {
        $table = $this->escape_location_reference($table);

        if ($alias === '')
        {
            return $table;
        }
        else
        {
            return $table . ' AS `' . $alias . '`';
        }
    }

    /**
     * Define a special collation.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     *
     * @return String $return Value with collation definition.
     */
    protected function collate($value, $collation)
    {
        if ($collation == '')
        {
            return $value;
        }
        else
        {
            return $value . ' COLLATE ' . $collation;
        }
    }

    /**
     * Define a SELECT clause.
     *
     * @param String $select The columns to select
     *
     * @return void
     */
    protected function sql_select($select)
    {
        if ($this->select != '')
        {
            $this->select .= ', ';
        }

        $this->select .= $select;
    }

    /**
     * Define a DELETE clause.
     *
     * @param String $delete The tables to delete from
     *
     * @return void
     */
    protected function sql_delete($delete)
    {
        if ($this->delete != '')
        {
            $this->delete .= ', ';
        }

        $this->delete .= $delete;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table       Table reference
     * @param array  $index_hints Array of Index Hints
     *
     * @return void
     */
    protected function sql_from($table, $index_hints = NULL)
    {
        if (is_array($index_hints) && !empty($index_hints))
        {
            $index_hints = array_diff($index_hints, array(NULL));
            $hints       = ' ' . implode(', ', $index_hints);
        }
        else
        {
            $hints = '';
        }

        if ($this->from == '')
        {
            $this->from = 'FROM ';
        }
        else
        {
            $this->from .= ', ';
        }

        $this->from .= $table . $hints;
    }

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param String $table Table reference
     *
     * @return void
     */
    protected function sql_into($table)
    {
        $this->into = 'INTO ' . $table;
    }

    /**
     * Define SET clause of the SQL statement.
     *
     * @param Array $set Array containing escaped key->value pairs to be set
     *
     * @return void
     */
    protected function sql_set($set)
    {
        if ($this->set == '')
        {
            $this->set = 'SET ';
        }
        else
        {
            $this->set .= ', ';
        }

        foreach ($set as $key => $value)
        {
            $this->set .= $key . ' = ' . $value . ', ';
        }

        $this->set = trim($this->set, ', ');
    }

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param Array $keys Array containing escaped field names to be set
     *
     * @return void
     */
    protected function sql_column_names($keys)
    {
        $this->column_names = '(' . implode(', ', $keys) . ')';
    }

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param Array $values Array containing escaped values to be set, can be either an
     * array or an array of arrays
     *
     * @return void
     */
    protected function sql_values($values)
    {
        if (empty($values))
        {
            return;
        }

        if ($this->values == '')
        {
            $this->values = 'VALUES ';
        }
        else
        {
            $this->values .= ', ';
        }

        if (!is_array($values[0]))
        {
            $values = array($values);
        }

        foreach ($values as $value)
        {
            $this->values .= '(' . implode(', ', $value) . '), ';
        }

        $this->values = trim($this->values, ', ');
    }

    /**
     * Define a Select statement for Insert statement.
     *
     * @param String $select SQL Select statement to be used in Insert
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    protected function sql_select_statement($select)
    {
        if (strpos($select, 'SELECT') === 0)
        {
            $this->select_statement = $select;
        }
    }

    /**
     * Define a conditional clause for the SQL statement.
     *
     * @param String  $left     Left expression
     * @param String  $right    Right expression
     * @param String  $operator Comparison operator
     * @param Boolean $where    whether to construct WHERE or HAVING
     *
     * @return void
     */
    protected function sql_condition($left, $right, $operator = '=', $where = TRUE)
    {
        $condition = ($where === TRUE) ? 'where' : 'having';

        if ($this->$condition == '')
        {
            $this->$condition = strtoupper($condition);
            $this->connector  = '';
        }
        elseif ($this->connector != '')
        {
            $this->$condition .= ' ' . $this->connector;
            $this->connector   = '';
        }
        else
        {
            $this->$condition .= ' AND';
        }

        $this->$condition .= " $left $operator $right";
    }

    /**
     * Define a ORDER BY clause of the SQL statement.
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return void
     */
    protected function sql_order_by($expr, $asc = TRUE)
    {
        $direction = ($asc === TRUE) ? 'ASC' : 'DESC';

        if ($this->order_by == '')
        {
            $this->order_by = 'ORDER BY ';
        }
        else
        {
            $this->order_by .= ', ';
        }

        $this->order_by .= $expr . ' ' . $direction;
    }

    /**
     * Define a LIMIT clause for the SQL statement.
     *
     * @param Integer $amount The amount of elements to retrieve
     * @param Integer $offset Start retrieving elements from a sepcific index
     *
     * @return void
     */
    protected function sql_limit($amount, $offset = -1)
    {
        $this->limit = "LIMIT $amount";

        if ($offset > -1)
        {
            $this->limit .= " OFFSET $offset";
        }
    }

    /**
     * Set a logical connector.
     *
     * @param String $connector Logical connector to set
     *
     * @return void
     */
    protected function sql_connector($connector)
    {
        $this->connector = $connector;
    }

    /**
     * Define a GROUP BY clause of the SQL statement.
     *
     * @param String $expr Expression to group by
     *
     * @return void
     */
    protected function sql_group_by($expr)
    {
        if ($this->group_by == '')
        {
            $this->group_by = 'GROUP BY ';
        }
        else
        {
            $this->group_by .= ', ';
        }

        $this->group_by .= $expr;
    }

    /**
     * Construct SQL query string.
     *
     * @param array $components Array of SQL query components to use to construct the query.
     *
     * @return String $sql The constructed SQL query
     */
    protected function implode_query($components)
    {
        $sql = '';

        foreach ($components as $component)
        {
            if (isset($this->$component) && ($this->$component != ''))
            {
                if (($component === 'select_mode') || ($component === 'delete_mode') || ($component === 'insert_mode'))
                {
                    $sql .= implode(' ', array_unique($this->$component)) . ' ';
                }
                else
                {
                    $sql .= $this->$component . ' ';
                }
            }
            elseif ($component === 'select')
            {
                $sql .= '* ';
            }
        }

        $sql = trim($sql);

        return ($sql == '*') ? '' : $sql;
    }

    /**
     * Escape a location reference (database, table, column).
     *
     * @param String $col Column
     *
     * @return String escaped column list
     */
    protected function escape_location_reference($col)
    {
        $parts = explode('.', $col);
        $col   = '';
        foreach ($parts as $part)
        {
            $part = trim($part);
            if ($part == '*')
            {
                $col .= $part;
            }
            else
            {
                $col .= '`' . $part . '`.';
            }
        }

        return trim($col, '.');
    }

    /**
     * Define and escape input as value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined and escaped value
     */
    public abstract function value($value, $collation = '', $charset = '');

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public abstract function hexvalue($value, $collation = '', $charset = '');

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $match     Whether to match forward, backward or both
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public abstract function likevalue($value, $match = 'both', $collation = '', $charset = '');

    /**
     * Define the mode of the SELECT clause.
     *
     * @param String $mode The select mode you want to use
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select_mode($mode);

    /**
     * Define the lock mode for a transaction.
     *
     * @param String $mode The lock mode you want to use
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function lock_mode($mode);

    /**
     * Define a SELECT clause.
     *
     * @param String $select The columns to select
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select($select);

    /**
     * Define the mode of the DELETE clause.
     *
     * @param String $mode The delete mode you want to use
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function delete_mode($mode);

    /**
     * Define a DELETE clause.
     *
     * @param String $delete The table references to delete from
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function delete($delete);

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function from($table);

    /**
     * Define the mode of the INSERT clause.
     *
     * @param String $mode The insert mode you want to use
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function insert_mode($mode);

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param String $mode The replace mode you want to use
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function replace_mode($mode);

    /**
     * Define INTO clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function into($table);

    /**
     * Define SET clause of the SQL statement.
     *
     * @param Array $set Array containing escaped key->value pairs to be set
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function set($set);

    /**
     * Define Column names of the affected by Insert or Update SQL statement.
     *
     * @param Array $keys Array containing escaped field names to be set
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function column_names($keys);

    /**
     * Define Values for Insert or Update SQL statement.
     *
     * @param Array $values Array containing escaped values to be set
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function values($values);

    /**
     * Define a Select statement for Insert statement.
     *
     * @param String $select SQL Select statement to be used in Insert
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select_statement($select);

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function where($left, $right, $operator = '=');

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function where_like($left, $right, $negate = FALSE);

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function having($left, $right, $operator = '=');

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function having_like($left, $right, $negate = FALSE);

    /**
     * Define a ORDER BY clause of the SQL statement.
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function order_by($expr, $asc = TRUE);

    /**
     * Define a GROUP BY clause of the SQL statement.
     *
     * @param String $expr Expression to group by
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function group_by($expr);

    /**
     * Define a LIMIT clause of the SQL statement.
     *
     * @param Integer $amount The amount of elements to retrieve
     * @param Integer $offset Start retrieving elements from a specific index
     *
     * @return void
     */
    public abstract function limit($amount, $offset = -1);

}
?>
