<?php

/**
 * This file contains a MySQLnd Userspace Handler for gathering
 * and storing MySQL SQL query statistics.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Database;

use Lunr\Libraries\Core\DateTime;
use \MySQLndUhConnection;

/**
 * MySQLnd Userspace Handler to log Query Statistics.
 * Stats are logged into a sqlite database.
 *
 * @category   Libraries
 * @package    Database
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MySQLndQueryLogger extends MySQLndUhConnection
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->datetime = new DateTime();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->datetime);
        parent::__destruct();
    }

    /**
     * Intercept MySQL queries.
     *
     * @param Resource $connection MySQL database connection
     * @param String   $query      SQL query to run
     *
     * @return mixed $return Return value of mysqli_query
     */
    public function query($connection, $query)
    {
        $id = $this->get_function_call_hierarchy(xdebug_get_function_stack());

        $start  = microtime(TRUE);
        $return = parent::query($connection, $query);
        $time   = microtime(TRUE) - $start;

        $this->record_query_stats($id, $time);

        return $return;
    }

    /**
     * Creates a function call string.
     *
     * This takes the function stack as input and transforms it
     * into a unique identifier for a query.
     *
     * @param array $stack The Function Stack
     *
     * @return String $hierarchy The Function call string
     */
    private function get_function_call_hierarchy($stack)
    {
        $hierarchy = '';
        foreach ($stack as &$value)
        {
            if (isset($value['class']))
            {
                $hierarchy .= $value['class'] . '->' . $value['function'] . '()=>';
            }
            else
            {
                $hierarchy .= $value['function'] . '()=>';
            }
        }

        unset($value);

        $hierarchy = trim($hierarchy, '=>');
        return $hierarchy;
    }

    /**
     * Record SQL Query statistics.
     *
     * @param String $identifier SQL Query identifier
     * @param Float  $time       Measured runtime of the query
     *
     * @return void
     */
    private function record_query_stats($identifier, $time)
    {
        global $stats_db;
        $sqlite = DBMan::get_db_connection($stats_db, FALSE);

        $data = array(
            'queryIdentifier' => $identifier,
            'execTime'        => $time,
            'execDate'        => $this->datetime->set_datetime_format('%Y-%m-%d %H-%M-%S')->get_datetime()
        );
        $sqlite->insert('query_stats', $data);
    }

}

?>
