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
 * @author     M2Mobi <info@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class defines abstract database query building.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
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
     * Constructor.
     */
    public function __construct()
    {
        $this->select = '';
        $this->select_mode = array();
        $this->from   = '';
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->select);
        unset($this->select_mode);
        unset($this->from);
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

        if ($this->from == '')
        {
            return '';
        }

        return 'SELECT ' . $this->implode_query($components);
    }

    /**
     * Define a SELECT clause.
     *
     * @param String  $select The columns to select
     * @param Boolean $escape Whether to escape the select statement or not.
     *                        Default to TRUE
     * @param Boolean $hex    Whether to represent the selected column data as hexadecimal or not.
     *                        Default to FALSE
     *
     * @return void
     */
    protected function sql_select($select, $escape = TRUE, $hex = FALSE)
    {
        if ($this->select != '')
        {
            $this->select .= ', ';
        }

        if ($escape === TRUE)
        {
            $this->select .= $this->escape_alias($select, $hex);
        }
        elseif ($hex === TRUE)
        {
            $this->select .= 'HEX(' . $select . ') AS ' . $select;
        }
        else
        {
            $this->select .= $select;
        }
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return void
     */
    protected function sql_from($table)
    {
        $this->from = 'FROM ' . $this->escape_alias($table);
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
     * Escape column names for statements using the "AS" operator.
     *
     * @param String  $cols Column(s)
     * @param Boolean $hex  Whether we should consider the values
     *                      as hexadecimal or not.
     *
     * @return String escaped column list
     */
    protected function escape_alias($cols, $hex = FALSE)
    {
        $cols = explode(',', $cols);
        $string = '';

        foreach ($cols AS $value)
        {
            $name = trim($value);
            $alias = $name;

            if (strpos($value, ' AS '))
            {
                $col   = explode(' AS ', $value);
                $name  = trim($col[0]);
                $alias = trim($col[1]);
            }
            elseif (strpos($value, ' as '))
            {
                $col   = explode(' as ', $value);
                $name  = trim($col[0]);
                $alias = trim($col[1]);
            }
            elseif ($name == '*')
            {
                $string .= $name . ', ';
                continue;
            }

            if ($hex === TRUE)
            {
                $string .= 'HEX(' . $this->escape_column_name($name) . ')';
                $string .= ' AS `' . $alias . '`, ';
            }
            else
            {
                $string .= $this->escape_column_name($name);

                if ($name != $alias)
                {
                    $string .= ' AS `' . $alias . '`, ';
                }
                else
                {
                    $string .= ', ';
                }
            }
        }

        return trim($string, ', ');
    }

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
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select($select, $escape = TRUE);

    /**
     * Define a SELECT clause, converting the column data to HEX values.
     *
     * If no alias name is specified the original column name minus
     * the surrounding HEX() is taken.
     *
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function select_hex($select, $escape = TRUE);

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return DatabaseDMLQueryBuilder $self Self reference
     */
    public abstract function from($table);

}

?>
