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
 * @author     M2Mobi <info@m2mobi.com>
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
 * @author     M2Mobi <info@m2mobi.com>
 */
class MySQLDMLQueryBuilder extends DatabaseDMLQueryBuilder
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
     * @param String $select The columns to select
     * @param String $escape Whether to escape the select statement or not.
     *                       Default to "TRUE"
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select($select, $escape = TRUE)
    {
        $this->sql_select($select, $escape);
        return $this;
    }

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
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function select_hex($select, $escape = TRUE)
    {
        $this->sql_select($select, $escape, TRUE);
        return $this;
    }

    /**
     * Define FROM clause of the SQL statement.
     *
     * @param String $table Table name
     *
     * @return MySQLDMLQueryBuilder $self Self reference
     */
    public function from($table)
    {
        $this->sql_from($table);
        return $this;
    }

}

?>
