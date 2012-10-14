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
     * SQL Query part: FROM clause
     * @var String
     */
    protected $from;

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
        $this->select = '';
        $this->select_mode = array();
        $this->from   = '';
        $this->where  = '';
        $this->group_by = '';
        $this->having = '';
        $this->order_by  = '';
        $this->limit  = '';
        $this->connector = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->select);
        unset($this->select_mode);
        unset($this->from);
        unset($this->where);
        unset($this->group_by);
        unset($this->having);
        unset($this->order_by);
        unset($this->limit);
        unset($this->connector);
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

        if ($this->from == '')
        {
            return '';
        }

        return 'SELECT ' . $this->implode_query($components);
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
        return trim($this->collate($this->escape_column_name($name), $collation));
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
        $column = $this->escape_column_name($column);

        if ($alias === '' || $column === '*')
        {
            return $column;
        }
        else
        {
            return $column .  ' AS `' . $alias . '`';
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
        return 'HEX(' . $this->escape_column_name($column) .  ') AS `' . $alias . '`';
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
        $table = $this->escape_column_name($table);

        if ($alias === '')
        {
            return $table;
        }
        else
        {
            return $table .  ' AS `' . $alias . '`';
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
            $hints = ' ' . implode(', ', $index_hints);
        }
        else
        {
            $hints = '';
        }

        $this->from = 'FROM ' . $table . $hints;
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

        if($offset > -1)
        {
            $this->limit .= " OFFSET $offset" ;
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
                if ($component === 'select_mode')
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
     * Escape a result column name.
     *
     * @param String $col Column
     *
     * @return String escaped column list
     */
    protected function escape_column_name($col)
    {
        $parts = explode('.', $col);
        $col = '';
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
     * Define a SELECT clause.
     *
     * @param String $select The columns to select
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select($select);

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function from($table);

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
