<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\SQLDMLQueryBuilder;

/**
 * This is a SQL query builder class for generating queries
 * suitable for either MySQL or MariaDB.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @author     Felipe Martinez <felipe@m2mobi.com>
 */
class MySQLDMLQueryBuilder extends SQLDMLQueryBuilder
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

    /**
     * Define the mode of the DELETE clause.
     *
     * @param String $mode The delete mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function delete_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'LOW_PRIORITY':
            case 'QUICK':
            case 'IGNORE':
                $this->delete_mode[] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define the mode of the INSERT clause.
     *
     * @param String $mode The insert mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function insert_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'IGNORE':
                $this->insert_mode['errors'] = $mode;
                break;
            case 'HIGH_PRIORITY':
            case 'LOW_PRIORITY':
            case 'DELAYED':
                $this->insert_mode['priority'] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define the mode of the REPLACE clause.
     *
     * @param String $mode The replace mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function replace_mode($mode)
    {
        return $this->insert_mode($mode);
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
     * Define the mode of the UPDATE clause.
     *
     * @param String $mode The update mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function update_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'LOW_PRIORITY':
            case 'IGNORE':
                $this->update_mode[] = $mode;
            default:
                break;
        }

        return $this;
    }

    /**
     * Define ON part of a JOIN clause with REGEXP comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function on_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'ON');
        return $this;
    }

    /**
     * Define WHERE clause with the REGEXP condition of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the condition or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
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
     * @param Boolean $order Order ASCending/TRUE or DESCending/FALSE, default no order/NULL
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function group_by($expr, $order = NULL)
    {
        $this->sql_group_by($expr);

        if($order !== NULL && is_bool($order))
        {
            $direction       = ($order === TRUE) ? ' ASC' : ' DESC';
            $this->group_by .= $direction;
        }

        return $this;
    }

    /**
     * Define HAVING clause with REGEXP comparator of the SQL statement.
     *
     * @param String $left   Left expression
     * @param String $right  Right expression
     * @param String $negate Whether to negate the comparison or not
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function having_regexp($left, $right, $negate = FALSE)
    {
        $operator = ($negate === FALSE) ? 'REGEXP' : 'NOT REGEXP';
        $this->sql_condition($left, $right, $operator, 'HAVING');
        return $this;
    }

    /**
     * Define the lock mode for a transaction.
     *
     * @param String $mode The lock mode you want to use
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function lock_mode($mode)
    {
        $mode = strtoupper($mode);

        switch ($mode)
        {
            case 'FOR UPDATE':
            case 'LOCK IN SHARE MODE':
                $this->lock_mode = $mode;
            default:
                break;
        }

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
