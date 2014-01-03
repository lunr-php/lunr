<?php

/**
 * Database connection pool class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database;

use MySQLi;

/**
 * This class implements a simple database connection pool.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class DatabaseConnectionPool
{

    /**
     * Shared instance of the Configuration class
     * @var Configuration
     */
    protected $configuration;

    /**
     * Shared instance of a Logger class
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Readonly connection pool
     * @var array
     */
    protected $ro_pool;

    /**
     * Read-Write connection pool
     * @var array
     */
    protected $rw_pool;

    /**
     * Constructor.
     *
     * @param Configuration   $configuration Shared instance of the configuration class
     * @param LoggerInterface $logger        Shared instance of a logger class
     */
    public function __construct($configuration, $logger)
    {
        $this->configuration = $configuration;
        $this->logger        = $logger;

        $this->ro_pool = array();
        $this->rw_pool = array();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->ro_pool);
        unset($this->rw_pool);
    }

    /**
     * Get a new readonly connection from the pool.
     *
     * @return DatabaseConnection $db A database connection
     */
    public function get_new_ro_connection()
    {
        return $this->get_connection(TRUE, TRUE);
    }

    /**
     * Get a new read-write connection from the pool.
     *
     * @return DatabaseConnection $db A database connection
     */
    public function get_new_rw_connection()
    {
        return $this->get_connection(TRUE, FALSE);
    }

    /**
     * Get an existing readonly connection from the pool.
     *
     * @return DatabaseConnection $db A database connection
     */
    public function get_ro_connection()
    {
        return $this->get_connection(FALSE, TRUE);
    }

    /**
     * Get an existing read-write connection from the pool.
     *
     * @return DatabaseConnection $db A database connection
     */
    public function get_rw_connection()
    {
        return $this->get_connection(FALSE, FALSE);
    }

    /**
     * Get a database connection.
     *
     * @param Boolean $new Whether to get a new connection or not
     * @param Boolean $ro  Whether to get a readonly connection or not
     *
     * @return DatabaseConnection $db A database connection
     */
    protected function get_connection($new, $ro)
    {
        $store = $ro ? 'ro_pool' : 'rw_pool';

        switch ($this->configuration['db']['driver'])
        {
            case 'mysql':
                // Specifying the full namespace here is necessary because of a restriction
                // in PHP with regards to resolving dynamic class names.
                $type  = 'Lunr\Gravity\Database\MySQL\MySQLConnection';
                $extra = new MySQLi();
                break;
            default:
                return NULL;
                break;
        }

        if (($new === TRUE) || (sizeof($this->$store) == 0))
        {
            $connection = new $type($this->configuration, $this->logger, $extra);

            if ($ro === TRUE)
            {
                $connection->set_readonly(TRUE);
            }

            $this->{$store}[] =& $connection;
        }
        else
        {
            $connection =& $this->{$store}[0];
        }

        return $connection;
    }

}

?>
