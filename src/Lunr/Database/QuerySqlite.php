<?php

/**
 * This file contains an abstraction class for a database
 * result set.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2009-2013, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Database;

/**
 * Database result set abstraction class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class QuerySqlite implements QueryInterface
{

    /**
     * SQL Query Result
     * @var SQLite3Result
     */
    private $query;

    /**
     * Resource handler for the (established) database connection
     * @var SQLite3
     */
    private $res;

    /**
     * Constructor.
     *
     * @param Mixed    &$query The Query result
     * @param Resource &$res   Resource handler for the db connection
     */
    public function __construct(&$query, &$res)
    {
        $this->query =& $query;
        $this->res   =& $res;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->query);
        unset($this->res);
    }

    /**
     * Returns the number of affected rows.
     *
     * @return Integer number of affected rows
     */
    public function affected_rows()
    {
        return 0;
    }

    /**
     * Returns the number of result rows.
     *
     * @return Integer number of result rows
     */
    public function num_rows()
    {
        return 0;
    }

    /**
     * Return an array of results.
     *
     * @return Array Array of Results
     */
    public function result_array()
    {
        return array();
    }

    /**
     * Return the first row of results.
     *
     * @return Array One data row
     */
    public function result_row()
    {
        return array();
    }

    /**
     * Return one field for the first row.
     *
     * @param String $col The field to return
     *
     * @return mixed Field value
     */
    public function field($col)
    {
        return '';
    }

    /**
     * Return a column of results.
     *
     * @param String $col The column to return
     *
     * @return Array Query Results
     */
    public function col($col)
    {
        return array();
    }

}

?>
