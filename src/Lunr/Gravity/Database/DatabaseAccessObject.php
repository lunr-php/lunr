<?php

/**
 * Abstract database access class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

use Lunr\Gravity\DataAccessObjectInterface;

/**
 * This class provides a way to access databases.
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
     * Get query result as an indexed array.
     *
     * @param DatabaseQueryResultInterface $query  The result of the run query
     * @param string                       $column Column to use as index
     *
     * @return mixed $result FALSE on failure, array otherwise
     */
    protected function indexed_result_array($query, $column)
    {
        if ($query->has_failed() === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
            return FALSE;
        }

        if ($query->number_of_rows() == 0)
        {
            return [];
        }

        $result = [];

        foreach ($query->result_array() as $row)
        {
            $result[$row[$column]] = $row;
        }

        return $result;
    }

    /**
     * Get query result as array.
     *
     * @param DatabaseQueryResultInterface $query The result of the run query
     *
     * @return mixed $result FALSE on failure, array otherwise
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
            return [];
        }
        else
        {
            return $query->result_array();
        }
    }

    /**
     * Get first row of query result.
     *
     * @param DatabaseQueryResultInterface $query The result of the run query
     *
     * @return mixed $result FALSE on failure, array otherwise
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
            return [];
        }
        else
        {
            return $query->result_row();
        }
    }

    /**
     * Get specific column of query result.
     *
     * @param DatabaseQueryResultInterface $query  The result of the run query
     * @param string                       $column The title of the requested column
     *
     * @return mixed $result FALSE on failure, array otherwise
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
            return [];
        }
        else
        {
            return $query->result_column($column);
        }
    }

    /**
     * Get specific cell of the first row of the query result.
     *
     * @param DatabaseQueryResultInterface $query The result of the run query
     * @param string                       $cell  The title of the requested cell
     *
     * @return mixed $result FALSE on failure, mixed otherwise
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

    /**
     * Retry executing the query in case of deadlock error.
     *
     * @param DatabaseQueryResultInterface $query       The result of the run query
     * @param integer                      $retry_count The max amount of re-executing the query
     *
     * @return mixed $result FALSE on failure, mixed otherwise
     */
    protected function result_retry($query, $retry_count = 5)
    {

        for ($i = 0; $i < $retry_count; $i++)
        {
            if ($query->has_deadlock() === FALSE)
            {
                return $query;
            }

            $query = $this->db->query($query->query());
        }

        return $query;
    }

    /**
     * Check whether the query has failed or not.
     *
     * @param DatabaseQueryResultInterface $query The result of the run query
     *
     * @return boolean $result FALSE on failure, TRUE on success
     */
    protected function result_boolean($query)
    {
        $result = $query->has_failed();
        if ($result === TRUE)
        {
            $context = [ 'query' => $query->query(), 'error' => $query->error_message() ];
            $this->logger->error('{query}; failed with error: {error}', $context);
        }

        return !$result;
    }

}

?>
