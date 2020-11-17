<?php

/**
 * Abtract database query builder class.
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

use Lunr\Gravity\Database\Exceptions\MissingTableReferenceException;

/**
 * This class defines abstract database query building.
 */
abstract class DatabaseDMLQueryBuilder implements DMLQueryBuilderInterface
{

    /**
     * SQL Query part: SELECT clause
     * @var string
     */
    protected $select;

    /**
     * SQL Query part: SELECT mode
     * @var array
     */
    protected $select_mode;

    /**
     * SQL Query part: lock mode
     * @var string
     */
    protected $lock_mode;

    /**
     * SQL Query part: DELETE clause
     * @var string
     */
    protected $delete;

    /**
     * SQL Query part: DELETE mode
     * @var array
     */
    protected $delete_mode;

    /**
     * SQL Query part: FROM clause
     * @var string
     */
    protected $from;

    /**
     * SQL Query part: INTO clause
     * @var string
     */
    protected $into;

    /**
     * SQL Query part: INSERT modes
     * @var array
     */
    protected $insert_mode;

    /**
     * SQL Query part: UPDATE clause
     * @var string
     */
    protected $update;

    /**
     * SQL Query part: UPDATE modes
     * @var array
     */
    protected $update_mode;

    /**
     * SQL Query part: SET clause
     * @var string
     */
    protected $set;

    /**
     * SQL Query part: Column names
     * @var string
     */
    protected $column_names;

    /**
     * SQL Query part: VALUES
     * @var string
     */
    protected $values;

    /**
     * SQL Query part: UPSERT clause
     * @var string
     */
    protected $upsert;

    /**
     * SQL Query part: SELECT statement
     * @var string
     */
    protected $select_statement;

    /**
     * SQL Query part: JOIN clause
     * @var string
     */
    protected $join;

    /**
     * SQL Query part: WHERE clause
     * @var string
     */
    protected $where;

    /**
     * SQL Query part: GROUP BY clause
     * @var string
     */
    protected $group_by;

    /**
     * SQL Query part: HAVING clause
     * @var string
     */
    protected $having;

    /**
     * SQL Query part: ORDER BY clause
     * @var string
     */
    protected $order_by;

    /**
     * SQL Query part: LIMIT clause
     * @var string
     */
    protected $limit;

    /**
     * SQL Query part: WHERE clause
     * @var string
     */
    protected $compound;

    /**
     * SQL Query part: Logical connector of expressions
     * @var string
     */
    protected $connector;

    /**
     * SQL Query part: Boolean identifying if the join is not finished
     * @var boolean
     */
    protected $is_unfinished_join;

    /**
     * SQL Query part: string identifying if the join type is type "using" or "on"
     * @var string
     */
    protected $join_type;

    /**
     * SQL Query part: String that contains the with query
     * @var string
     */
    protected $with;

    /**
     * Whether a recursive with statement is used or not
     * @var boolean
     */
    protected $is_recursive;

    /**
     * SQL Query part: returning clause
     * @var string
     */
    protected $returning;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->select             = '';
        $this->select_mode        = [];
        $this->update             = '';
        $this->update_mode        = [];
        $this->delete             = '';
        $this->delete_mode        = [];
        $this->from               = '';
        $this->join               = '';
        $this->where              = '';
        $this->group_by           = '';
        $this->having             = '';
        $this->order_by           = '';
        $this->limit              = '';
        $this->connector          = '';
        $this->into               = '';
        $this->insert_mode        = [];
        $this->set                = '';
        $this->column_names       = '';
        $this->values             = '';
        $this->upsert             = '';
        $this->select_statement   = '';
        $this->compound           = '';
        $this->is_unfinished_join = FALSE;
        $this->join_type          = '';
        $this->with               = '';
        $this->is_recursive       = FALSE;
        $this->returning          = '';
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
        unset($this->upsert);
        unset($this->select_statement);
        unset($this->is_unfinished_join);
        unset($this->join_type);
        unset($this->with);
        unset($this->is_recursive);
        unset($this->returning);
    }

    /**
     * Construct and return a SELECT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_select_query()
    {
        $components = [];

        array_push($components, 'select_mode', 'select', 'from', 'join', 'where');
        array_push($components, 'group_by', 'having', 'order_by', 'limit', 'lock_mode');

        $with_query = '';

        if($this->with != '')
        {
            if ($this->is_recursive == TRUE)
            {
                $with_query = 'WITH RECURSIVE ' . $this->with . ' ';
            }
            else
            {
                $with_query = 'WITH ' . $this->with . ' ';
            }
        }

        $standard = $with_query . 'SELECT ' . $this->implode_query($components);
        if ($this->compound == '')
        {
            return $standard;
        }

        $components   = [];
        $components[] = 'compound';

        return '(' . $standard . ') ' . $this->implode_query($components);
    }

    /**
     * Construct and return a DELETE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_delete_query()
    {
        if ($this->from == '')
        {
            throw new MissingTableReferenceException('No from() in delete query!');
        }

        $components = [];
        array_push($components, 'delete_mode', 'delete', 'from', 'join', 'where');

        if (($this->delete == '') && ($this->join == ''))
        {
            array_push($components, 'order_by', 'limit', 'returning');
        }

        return 'DELETE ' . $this->implode_query($components);
    }

    /**
     * Construct and return a INSERT query.
     *
     * @return string $query The constructed query string.
     */
    public function get_insert_query()
    {
        if ($this->into == '')
        {
            throw new MissingTableReferenceException('No into() in insert query!');
        }

        $components   = [];
        $components[] = 'insert_mode';
        $components[] = 'into';

        if ($this->select_statement != '')
        {
            $components[] = 'column_names';
            $components[] = 'select_statement';

            $valid = [ 'HIGH_PRIORITY', 'LOW_PRIORITY', 'IGNORE' ];

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

        $components[] = 'upsert';

        return 'INSERT ' . $this->implode_query($components);
    }

    /**
     * Construct and return a REPLACE query.
     *
     * @return string $query The constructed query string.
     */
    public function get_replace_query()
    {
        if ($this->into == '')
        {
            throw new MissingTableReferenceException('No into() in replace query!');
        }

        $valid = [ 'LOW_PRIORITY', 'DELAYED' ];

        $this->insert_mode = array_intersect($this->insert_mode, $valid);

        $components   = [];
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
     * @return string $query The constructed query string.
     */
    public function get_update_query()
    {
        if ($this->update == '')
        {
            throw new MissingTableReferenceException('No update() in update query!');
        }

        $valid = [ 'LOW_PRIORITY', 'IGNORE' ];

        $this->update_mode = array_intersect($this->update_mode, $valid);

        $components = [];
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
     * @param string|null $select The columns to select
     *
     * @return void
     */
    protected function sql_select($select)
    {
        if ($this->select != '')
        {
            $this->select .= ', ';
        }

        $this->select .= $select ?? 'NULL';
    }

    /**
     * Define a WITH clause.
     *
     * @param string      $alias           The alias of the WITH statement
     * @param string      $sql_query       Sql query reference
     * @param string|null $recursive_query The select statement that selects recursively out of the initial query
     * @param string|null $union           The union part of a recursive query
     * @param array|null  $column_names    An optional parameter to give the result columns a name
     *
     * @return void
     */
    protected function sql_with($alias, $sql_query, $recursive_query = NULL, $union = NULL, $column_names = NULL)
    {
        if($column_names !== NULL)
        {
            $column_names = ' (' . implode(', ', $column_names) . ')';
        }

        if($recursive_query != '' && $recursive_query !== NULL)
        {
            $this->is_recursive = TRUE;

            if(!is_null($union))
            {
                $recursive_query = ' ' . $union . ' ' . $recursive_query;
            }
        }

        if($this->with != '')
        {
            if ($recursive_query != '' && $recursive_query !== NULL)
            {
                $this->with = $alias . $column_names . ' AS ( ' . $sql_query . $recursive_query . ' ), ' . $this->with;
            }
            else
            {
                $this->with .= ', ' . $alias . $column_names . ' AS ( ' . $sql_query . ' )';
            }
        }
        else
        {
            $this->with = $alias . $column_names . ' AS ( ' . $sql_query . $recursive_query . ' )';
        }
    }

    /**
     * Define a UPDATE clause.
     *
     * @param string $table_references The tables to update
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
     * @param string $delete The tables to delete from
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
     * @param string     $table       Table reference
     * @param array|null $index_hints Array of Index Hints
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
     * @param string     $table_reference Table reference
     * @param string     $type            Type of JOIN operation to perform.
     * @param array|null $index_hints     Array of Index Hints
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
     * @param string $column_list Column name to use.
     *
     * @return void
     */
    protected function sql_using($column_list)
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
     * @param string $table Table reference
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
     * @param array $set Array containing escaped key->value pairs to be set
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
     * @param array $keys Array containing escaped field names to be set
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
     * @param array $values Array containing escaped values to be set, can be either an
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
            $values = [ $values ];
        }

        foreach ($values as $value)
        {
            $value = array_map(function($entry){ return is_null($entry) ? 'NULL' : $entry; }, $value);

            $this->values .= '(' . implode(', ', $value) . '), ';
        }

        $this->values = trim($this->values, ', ');
    }

    /**
     * Define an Upsert clause for an Insert statement.
     *
     * @param string      $key    Upsert keyword
     * @param string      $action Action to perform on conflict
     * @param string|null $target Target to watch for conflicts
     *
     * @return void
     */
    protected function sql_upsert($key, $action, $target = NULL)
    {
        $this->upsert = $key . ' ';

        if ($target !== NULL)
        {
            $this->upsert .= $target . ' ';
        }

        $this->upsert .= $action;
    }

    /**
     * Define a Select statement for Insert statement.
     *
     * @param string $select SQL Select statement to be used in Insert
     *
     * @return void
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
     * @param string $left     Left expression
     * @param string $right    Right expression
     * @param string $operator Comparison operator
     * @param string $base     Whether to construct WHERE, HAVING or ON
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
     * @param string $sql_query Left expression
     * @param string $base      Whether to construct UNION, EXCEPT or INTERSECT
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
     * @param string  $expr Expression to order by
     * @param boolean $asc  Order ASCending/TRUE or DESCending/FALSE
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
     * @param integer $amount The amount of elements to retrieve
     * @param integer $offset Start retrieving elements from a sepcific index
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
     * @param string $connector Logical connector to set
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
     * @param string $expr Expression to group by
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
     * @return string $sql The constructed SQL query
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
     * @return string $hints Comma separated list of index hints.
     */
    protected function prepare_index_hints($index_hints)
    {
        if (is_array($index_hints) && !empty($index_hints))
        {
            $index_hints = array_diff($index_hints, [ NULL ]);
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
     * @param string $base String indication Statement to group
     *
     * @return void
     */
    protected function sql_group_start($base = 'WHERE')
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
     * @param string $condition String indication Statement to group
     *
     * @return void
     */
    protected function sql_group_end($condition = 'WHERE')
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
