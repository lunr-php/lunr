<?php

/**
 * Abstract database access class.
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

use Lunr\Gravity\DataAccessObjectInterface;

/**
 * This class provides a way to access databases.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class DatabaseAccessObject implements DataAccessObjectInterface
{

    /**
     * Database connection handler.
     * @var DatabaseConnection
     */
    protected $db;

    /**
     * Query Escaper for the main connection.
     * @var DatabaseQueryEscaper
     */
    protected $escaper;

    /**
     * Shared instance of a Logger class.
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Database connection pool.
     * @var DatabaseConnectionPool
     */
    protected $pool;

    /**
     * Constructor.
     *
     * @param DatabaseConnection     $connection Shared instance of a database connection class
     * @param LoggerInterface        $logger     Shared instance of a Logger class
     * @param DatabaseConnectionPool $pool       Shared instance of a database connection pool, NULL by default
     */
    public function __construct($connection, $logger, $pool = NULL)
    {
        $this->db      = $connection;
        $this->escaper = $this->db->get_query_escaper_object();
        $this->logger  = $logger;
        $this->pool    = $pool;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->db);
        unset($this->escaper);
        unset($this->logger);
        unset($this->pool);
    }

    /**
     * Swap the currently used database connection with a new one.
     *
     * @param DatabaseConnection $connection Shared instance of a database connection class
     *
     * @return void
     */
    public function swap_connection($connection)
    {
        $this->db      = $connection;
        $this->escaper = $this->db->get_query_escaper_object();
    }

    /**
     * Get query result as array.
     *
     * @param DatabaseQueryResult $query The result of the run query
     *
     * @return mixed $return FALSE on failure, array otherwise
     */
    protected function result_array($query)
    {
        if ($query->has_failed() === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
            return FALSE;
        }

        if ($query->number_of_rows() == 0)
        {
            return array();
        }
        else
        {
            return $query->result_array();
        }
    }

    /**
     * Get first row of query result.
     *
     * @param DatabaseQueryResult $query The result of the run query
     *
     * @return mixed $return FALSE on failure, array otherwise
     */
    protected function result_row($query)
    {
        if ($query->has_failed() === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
            return FALSE;
        }

        if ($query->number_of_rows() == 0)
        {
            return array();
        }
        else
        {
            return $query->result_row();
        }
    }

    /**
     * Get specific column of query result.
     *
     * @param DatabaseQueryResult $query  The result of the run query
     * @param String              $column The title of the requested column
     *
     * @return mixed $return FALSE on failure, array otherwise
     */
    protected function result_column($query, $column)
    {
        if ($query->has_failed() === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
            return FALSE;
        }

        if ($query->number_of_rows() == 0)
        {
            return array();
        }
        else
        {
            return $query->result_column($column);
        }
    }

    /**
     * Get specific cell of the first row of the query result.
     *
     * @param DatabaseQueryResult $query The result of the run query
     * @param String              $cell  The title of the requested cell
     *
     * @return mixed $return FALSE on failure, mixed otherwise
     */
    protected function result_cell($query, $cell)
    {
        if ($query->has_failed() === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
            return FALSE;
        }

        if ($query->number_of_rows() == 0)
        {
            return '';
        }
        else
        {
            return $query->result_cell($cell);
        }
    }

}

?>
