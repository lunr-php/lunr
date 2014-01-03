<?php

/**
 * Abstract query escaper class.
 *
 * PHP Version 5.4
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
 * This class provides common escaping methods for SQL query parts.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class DatabaseQueryEscaper implements QueryEscaperInterface
{

    /**
     * Instance of the Database Connection.
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * The left identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_L = '`';

    /**
     * The right identifier delimiter.
     * @var String
     */
    const IDENTIFIER_DELIMITER_R = '`';

    /**
     * Constructor.
     *
     * @param DatabaseConnection $db Instance of the DatabaseConnection class.
     */
    public function __construct($db)
    {
        $this->db = $db;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->db);
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
            return $column . ' AS ' . static::IDENTIFIER_DELIMITER_L . $alias . static::IDENTIFIER_DELIMITER_R;
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
        $alias = static::IDENTIFIER_DELIMITER_L . $alias . static::IDENTIFIER_DELIMITER_R;

        return 'HEX(' . $this->escape_location_reference($column) . ') AS ' . $alias;
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
            return $table . ' AS ' . static::IDENTIFIER_DELIMITER_L . $alias . static::IDENTIFIER_DELIMITER_R;
        }
    }

    /**
     * Define and escape input as integer value.
     *
     * @param mixed $value Input to escape as integer
     *
     * @return Integer Defined and escaped Integer value
     */
    public function intvalue($value)
    {
        return intval($value);
    }

    /**
    * Define input as a query within parentheses.
    *
    * @param String $value Input
    *
    * @return String $return Defined within parentheses
    */
    public function query_value($value)
    {
        return empty($value) ? '' : '(' . $value . ')';
    }

    /**
     * Define input as a csv from an array within parentheses.
     *
     * @param array $array_values Input
     *
     * @return String $output Defined, escaped and within parentheses
     */
    public function list_value($array_values)
    {
        if(is_array($array_values) === FALSE)
        {
            return '';
        }

        return '(' . implode(',', $array_values) . ')';
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
                $col .= static::IDENTIFIER_DELIMITER_L . $part . static::IDENTIFIER_DELIMITER_L . '.';
            }
        }

        return trim($col, '.');
    }

}

?>
