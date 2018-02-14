<?php

/**
 * Abtract database query builder class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

/**
 * This class defines abstract database query building.
 */
abstract class DatabaseDMLQueryBuilder implements DMLQueryBuilderInterface
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
     * SQL Query part: UPDATE clause
     * @var String
     */
    protected $update;

    /**
     * SQL Query part: UPDATE modes
     * @var Array
     */
    protected $update_mode;

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
     * SQL Query part: JOIN clause
     * @var String
     */
    protected $join;

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
     * SQL Query part: WHERE clause
     * @var String
     */
    protected $compound;

    /**
     * SQL Query part: Logical connector of expressions
     * @var String
     */
    protected $connector;

    /**
     * SQL Query part: Boolean identifying if the join is not finished
     * @var Boolean
     */
    protected $is_unfinished_join;

    /**
     * SQL Query part: string identifying if the join type is type "using" or "on"
     * @var String
     */
    protected $join_type;

    /**
     * SQL Query part: String that contains the with query
     * @var String
     */
    protected $with;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->select             = '';
        $this->select_mode        = array();
        $this->update             = '';
        $this->update_mode        = array();
        $this->delete             = '';
        $this->delete_mode        = array();
        $this->from               = '';
        $this->join               = '';
        $this->where              = '';
        $this->group_by           = '';
        $this->having             = '';
        $this->order_by           = '';
        $this->limit              = '';
        $this->connector          = '';
        $this->into               = '';
        $this->insert_mode        = array();
        $this->set                = '';
        $this->column_names       = '';
        $this->values             = '';
        $this->select_statement   = '';
        $this->compound           = '';
        $this->is_unfinished_join = FALSE;
        $this->join_type          = '';
        $this->with               = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->select);
        unset($this->select_mode);
        unset($this->update);
        unset($this->update_mode);
        unset($this->delete);
        unset($this->delete_mode);
        unset($this->from);
        unset($this->join);
        unset($this->where);
        unset($this->group_by);
        unset($this->having);
        unset($this->order_by);
        unset($this->limit);
        unset($this->compound);
        unset($this->connector);
        unset($this->into);
        unset($this->insert_mode);
        unset($this->set);
        unset($this->column_names);
        unset($this->values);
        unset($this->select_statement);
        unset($this->is_unfinished_join);
        unset($this->join_type);
        unset($this->with);
    }

    /**
     * Construct and return a SELECT query.
     *
     * @return String $query The constructed query string.
     */
    public function get_select_query()
    {
        if ($this->from == '')
        {
            return '';
        }

        $components = array();

        array_push($components, 'select_mode', 'select', 'from', 'join', 'where');
        array_push($components, 'group_by', 'having', 'order_by', 'limit', 'lock_mode');

        $standard = $this->with . 'SELECT ' . $this->implode_query($components);
        if ($this->compound == '')
        {
            return $standard;
        }

        $components   = array();
        $components[] = 'compound';

        return '(' . $standard . ') ' . $this->implode_query($components);
    }

    /**
     * Construct and return a DELETE query.
     *
     * @return String $query The constructed query string.
     */
    public function get_delete_query()
    {
        if ($this->from == '')
        {
            return '';
        }

        $components = array();
        array_push($components, 'delete_mode', 'delete', 'from', 'join', 'where');

        if (($this->delete == '') && ($this->join == ''))
        {
            array_push($components, 'order_by', 'limit');
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
        if ($this->into == '')
        {
            return '';
        }

        $components   = array();
        $components[] = 'insert_mode';
        $components[] = 'into';

        if ($this->select_statement != '')
        {
            $components[] = 'column_names';
            $components[] = 'select_statement';

            $valid = array( 'HIGH_PRIORITY', 'LOW_PRIORITY', 'IGNORE' );

            $this->insert_mode = array_intersect($this->insert_mode, $valid);
        }
        elseif ($this->set != '')
        {
            $components[] = 'set';
        }
        else
        {
            $components[] = 'column_names';
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

        $valid = array( 'LOW_PRIORITY', 'DELAYED' );

        $this->insert_mode = array_intersect($this->insert_mode, $valid);

        $components   = array();
        $components[] = 'insert_mode';
        $components[] = 'into';

        if ($this->select_statement != '')
        {
            $components[] = 'column_names';
            $components[] = 'select_statement';
        }
        elseif ($this->set != '')
        {
            $components[] = 'set';
        }
        else
        {
            $components[] = 'column_names';
            $components[] = 'values';
        }

        return 'REPLACE ' . $this->implode_query($components);
    }

    /**
     * Construct and return an UPDATE query.
     *
     * @return String $query The constructed query string.
     */
    public function get_update_query()
    {
        if ($this->update == '')
        {
            return '';
        }

        $valid = array( 'LOW_PRIORITY', 'IGNORE' );

        $this->update_mode = array_intersect($this->update_mode, $valid);

        $components = array();
        array_push($components, 'update_mode', 'update', 'join', 'set', 'where');

        if ((strpos($this->update, ',') === FALSE) && $this->join == '')
        {
            $components[] = 'order_by';
            $components[] = 'limit';
        }

        return 'UPDATE ' . $this->implode_query($components);
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
     * Define a WITH clause.
     *
     * @param string $alias        The alias of the WITH statement
     * @param string $sql_query    Sql query reference
     * @param array  $column_names An optional parameter to give the result columns a name
     *
     * @return void
     */
    protected function sql_with($alias, $sql_query, $column_names = NULL)
    {
        if($column_names !== NULL)
        {
            $column_names = ' (' . implode(', ', $column_names) . ')';
        }

        if($this->with != '')
        {
            $this->with .= ', ' . $alias . ' AS ( ' . $sql_query . ' )';
        }
        else
        {
            $this->with = 'WITH ' . $alias . $column_names . ' AS ( ' . $sql_query . ' )';
        }
    }

    /**
     * Define a UPDATE clause.
     *
     * @param String $table_references The tables to update
     *
     * @return void
     */
    protected function sql_update($table_references)
    {
        if ($this->update != '')
        {
            $this->update .= ', ';
        }

        $this->update .= $table_references;
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
        if ($this->from == '')
        {
            $this->from = 'FROM ';
        }
        else
        {
            $this->from .= ', ';
        }

        $this->from .= $table . $this->prepare_index_hints($index_hints);
    }

    /**
     * Define JOIN clause of the SQL statement.
     *
     * @param String $table_reference Table reference
     * @param String $type            Type of JOIN operation to perform.
     * @param array  $index_hints     Array of Index Hints
     *
     * @return void
     */
    protected function sql_join($table_reference, $type, $index_hints = NULL)
    {
        $type = strtoupper($type);

        $join = ($type == 'STRAIGHT') ? 'STRAIGHT_JOIN ' : ltrim($type . ' JOIN ');

        if ($this->join != '')
        {
            $this->join .= ' ';
        }

        $this->join .= $join . $table_reference . $this->prepare_index_hints($index_hints);

        if (!(substr($type, 0, 7) == 'NATURAL'))
        {
            $this->is_unfinished_join = TRUE;
        }

        $this->join_type = '';
    }

    /**
     * Define USING clause of the SQL statement.
     *
     * @param String $column_list Column name to use.
     *
     * @return void
     */
    function sql_using($column_list)
    {
        // Select join type.
        if ($this->join_type === '')
        {
            $this->join_type = 'using';
        }

        // Prevent USING and ON to be used at the same time.
        if ($this->join_type !== 'using')
        {
            return;
        }

        if ($this->is_unfinished_join)
        {
            $this->join              .= ' USING (';
            $this->is_unfinished_join = FALSE;
        }
        elseif (substr($this->join, -1) !== '(')
        {
            $this->join = rtrim($this->join, ')') . ', ';
        }

        $this->join .= $column_list . ')';
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
            $value = (is_null($value)) ? 'NULL' : $value;

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
     *                      array or an array of arrays
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

        if (!isset($values[0]) || !is_array($values[0]))
        {
            $values = array( $values );
        }

        foreach ($values as $value)
        {
            $value = array_map(function($entry){ return is_null($entry) ? 'NULL' : $entry; }, $value);

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
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     * @param String $base     whether to construct WHERE, HAVING or ON
     *
     * @return void
     */
    protected function sql_condition($left, $right, $operator = '=', $base = 'WHERE')
    {
        $condition = ($base === 'ON') ? 'join' : strtolower($base);

        // select join type.
        if ($this->join_type === '' && $this->is_unfinished_join === TRUE && $base === 'ON')
        {
            $this->join_type = strtolower($base);
        }

        // Prevent USING and ON to be used at the same time.
        if ($this->join_type === 'using' && $condition === 'join')
        {
            return;
        }

        if (rtrim($this->$condition, '(') == '' || $this->is_unfinished_join)
        {
            if ($this->is_unfinished_join)
            {
                $this->$condition .= ' ' . $base . ' ';
            }
            else
            {
                $this->$condition = $base . ' ' . $this->$condition;
            }

            $this->connector          = '';
            $this->is_unfinished_join = FALSE;
        }
        elseif ($this->connector != '')
        {
            $this->$condition .= ' ' . $this->connector . ' ';
            $this->connector   = '';
        }
        elseif (substr($this->$condition, -1) !== '(')
        {
            $this->$condition .= ' AND ';
        }

        $this->$condition .= "$left $operator $right";
    }

    /**
     * Define a compound clause for the SQL statement.
     *
     * @param String $sql_query Left expression
     * @param String $base      Whether to construct UNION, EXCEPT or INTERSECT
     *
     * @return void
     */
    protected function sql_compound($sql_query, $base)
    {
        if ($this->compound != '')
        {
            $this->compound .= ' ';
        }

        $this->compound .= $base . ' ' . $sql_query;
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
                if (($component === 'select_mode') || ($component === 'delete_mode')
                    || ($component === 'insert_mode') || ($component === 'update_mode')
                )
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
     * Prepare the list of index hints for a table reference.
     *
     * @param array $index_hints Array of Index Hints
     *
     * @return String $hints Comma separated list of index hints.
     */
    protected function prepare_index_hints($index_hints)
    {
        if (is_array($index_hints) && !empty($index_hints))
        {
            $index_hints = array_diff($index_hints, array( NULL ));
            $hints       = ' ' . implode(', ', $index_hints);
        }
        else
        {
            $hints = '';
        }

        return $hints;
    }

    /**
     * Open the parentheses for the sql condition.
     *
     * @param String $base String indication Statement to group
     *
     * @return void
     */
    public function sql_group_start($base = 'WHERE')
    {
        $condition = ($base === 'ON') ? 'join' : strtolower($base);

        // select join type.
        if ($this->join_type === '' && $this->is_unfinished_join === TRUE && $base === 'ON')
        {
            $this->join_type = strtolower($base);
        }

        // Prevent USING and ON to be used at the same time.
        if ($this->join_type === 'using' && $condition === 'join')
        {
            return;
        }

        if ($this->is_unfinished_join)
        {
            $this->$condition        .= 'ON ';
            $this->is_unfinished_join = FALSE;
        }
        elseif ($this->connector != '')
        {
            $this->$condition .= ' ' . $this->connector . ' ';
            $this->connector   = '';
        }
        elseif (!empty($this->$condition) && substr($this->$condition, -1) !== '(')
        {
            $this->$condition .= ' AND ';
        }

        $this->$condition .= '(';
    }

    /**
     * Close the parentheses for the sql condition.
     *
     * @param String $condition String indication Statement to group
     *
     * @return void
     */
    public function sql_group_end($condition = 'WHERE')
    {
        $condition = ($condition === 'ON') ? 'join' : strtolower($condition);

        // Prevent USING and ON to be used at the same time.
        if ($this->join_type === 'using' && $condition === 'join')
        {
            return;
        }

        $this->$condition .= ')';
    }

}

?>
