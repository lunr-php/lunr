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
 * @author     M2Mobi <info@m2mobi.com>
 * @copyright  2009-2011, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2011, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://opensource.org/licenses/bsd-license BSD License
 */

/**
 * Database result set abstraction class
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 * @copyright  2009-2011, Heinz Wiesinger, Amsterdam, The Netherlands
 * @copyright  2010-2011, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://opensource.org/licenses/bsd-license BSD License
 */
class Query
{

    /**
     * SQL Query Result
     * @var Mixed
     */
    private $query;

    /**
     * Resource handler for the (established) database connection
     * @var Resource
     */
    private $res;

    /**
     * Constructor.
     *
     * @param Mixed    $query The Query result
     * @param Resource $res   Resource handler for the db connection
     */
    public function __construct($query, $res)
    {
        $this->query = $query;
        $this->res = $res;
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
        return mysqli_affected_rows($this->res);
    }

    /**
     * Returns the number of result rows.
     *
     * @return Integer number of result rows
     */
    public function num_rows()
    {
        if (is_bool($this->query))
        {
            Output::error("Num rows called on failed query!");
            return 0;
        }
        else
        {
            return mysqli_num_rows($this->query);
        }
    }

    /**
     * Return an array of results.
     *
     * @return Array Array of Results
     */
    public function result_array()
    {
        $output = array();
        while ($row = mysqli_fetch_assoc($this->query))
        {
            $output[] = $row;
        }
        return $output;
    }

    /**
     * Return the first row of results.
     *
     * @return Array One data row
     */
    public function result_row()
    {
        $output = mysqli_fetch_assoc($this->query);
        return $output;
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
        $line = mysqli_fetch_assoc($this->query);
        return $line[$col];
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
        $output = array();
        while ($row = mysqli_fetch_assoc($this->query))
        {
            $output[] = $row[$col];
        }
        return $output;
    }

}

?>