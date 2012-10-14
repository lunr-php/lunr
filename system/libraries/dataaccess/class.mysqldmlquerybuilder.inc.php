<?php

/**
 * MySQL/MariaDB database query builder class.
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
 * This is a SQL query builder class for generating queries
 * suitable for either MySQL or MariaDB.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class MySQLDMLQueryBuilder extends DatabaseDMLQueryBuilder
{

    /**
     * Reference to the MySQLConnection class.
     * @var MySQLConnection
     */
    protected $db;

    /**
     * Constructor.
     *
     * @param MySQLConnection &$db Reference to the MySQLConnection class.
     */
    public function __construct(&$db)
    {
        parent::__construct();

        $this->db =& $db;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
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
    public function value($value, $collation = '', $charset = '')
    {
        return trim($charset . ' ' . $this->collate('\'' . $this->db->escape_string($value) . '\'', $collation));
    }

    /**
     * Define and escape input as a hexadecimal value.
     *
     * @param mixed  $value     Input
     * @param String $collation Collation name
     * @param String $charset   Charset name
     *
     * @return String $return Defined, escaped and unhexed value
     */
    public function hexvalue($value, $collation = '', $charset = '')
    {
        return trim($charset . ' ' . $this->collate('UNHEX(\'' . $this->db->escape_string($value) . '\')', $collation));
    }

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

        return trim($charset . ' ' . $this->collate($string, $collation));
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
     * Define and escape input as index hint.
     *
     * @param String $keyword Whether to USE, FORCE or IGNORE the index/indeces
     * @param array  $indeces Array of indeces
     * @param String $for     Whether to use the index hint for JOIN, ORDER BY or GROUP BY
     *
     * @return mixed $return NULL for invalid indeces, escaped string otherwise.
     */
    public function index_hint($keyword, $indeces, $for = '')
    {
        if (!is_array($indeces) || empty($indeces))
        {
            return NULL;
        }

        $keyword = strtoupper($keyword);

        $valid_keywords = array('USE', 'IGNORE', 'FORCE');
        $valid_for = array('JOIN', 'ORDER BY', 'GROUP BY', '');

        if (!in_array($keyword, $valid_keywords))
        {
            $keyword = 'USE';
        }

        if (!in_array($for, $valid_for))
        {
            $for = '';
        }

        $indeces = array_map(array($this, 'escape_column_name'), $indeces);
        $indeces = implode(', ', $indeces);

        if ($for === '')
        {
            return $keyword . ' INDEX (' . $indeces . ')';
        }
        else
        {
            return $keyword . ' INDEX FOR ' . $for . ' (' . $indeces . ')';
        }
    }

    /**
     * Define the mode of the SELECT clause.
     *
     * @param String $mode The select mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'ALL':
            case 'DISTINCT':
            case 'DISTINCTROW':
                $this->select_mode['duplicates'] = $mode;
                break;
            case 'SQL_CACHE':
            case 'SQL_NO_CACHE':
                $this->select_mode['cache'] = $mode;
                break;
            case 'HIGH_PRIORITY':
            case 'STRAIGHT_JOIN':
            case 'SQL_SMALL_RESULT':
            case 'SQL_BIG_RESULT':
            case 'SQL_BUFFER_RESULT':
            case 'SQL_CALC_FOUND_ROWS':
                $this->select_mode[] = $mode;
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
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select($select)
    {
        $this->sql_select($select);
        return $this;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table       Table reference
     * @param array  $index_hints Array of Index Hints
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function from($table, $index_hints = NULL)
    {
        $this->sql_from($table, $index_hints);
        return $this;
    }

    /**
     * Define WHERE clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
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
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function where_like($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator);
        return $this;
    }

    /**
     * Define GROUP BY clause of the SQL statement.
     *
     * @param String  $expr  Expression to group by
     * @param Boolean $order Order ASCending/TRUE or DESCending/FALSE, default no order/NULL
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->sql_group_by($expr);

        if( $order !== NULL && is_bool($order) )
        {
            $direction = ($order === TRUE) ? " ASC" : " DESC";
            $this->group_by .= $direction;
        }
        return $this;
    }

    /**
     * Define HAVING clause of the SQL statement.
     *
     * @param String $left     Left expression
     * @param String $right    Right expression
     * @param String $operator Comparison operator
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having($left, $right, $operator = '=')
    {
        $this->sql_condition($left, $right, $operator, FALSE);
        return $this;
    }

    /**
     * Define WHERE clause with LIKE comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_like($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'LIKE' : 'NOT LIKE';
        $this->sql_condition($left, $right, $operator, FALSE);
        return $this;
    }

    /**
     * Define ORDER BY clause in the SQL statement
     *
     * @param String  $expr Expression to order by
     * @param Boolean $asc  Order ASCending/TRUE or DESCending/FALSE
     *
     * @return MySQLDMLQueryBuilder $self Self reference
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
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function limit($amount, $offset = -1)
    {
        $this->sql_limit($amount, $offset);
        return $this;
    }

    /**
     * Set logical connector 'AND'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_and()
    {
        $this->sql_connector('AND');
        return $this;
    }

    /**
     * Set logical connector 'OR'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_or()
    {
        $this->sql_connector('OR');
        return $this;
    }

    /**
     * Set logical connector 'XOR'.
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function sql_xor()
    {
        $this->sql_connector('XOR');
        return $this;
    }

}

?>
