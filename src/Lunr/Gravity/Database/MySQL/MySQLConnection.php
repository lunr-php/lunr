<?php

/**
 * MySQL database connection class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseConnection;

/**
 * MySQL/MariaDB database access class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MySQLConnection extends DatabaseConnection
{

    /**
     * Hostname of the database server (read/write access)
     * @var String
     */
    protected $rw_host;

    /**
     * Hostname of the database server (readonly access)
     * @var String
     */
    protected $ro_host;

    /**
     * Username of the user used to connect to the database
     * @var String
     */
    protected $user;

    /**
     * Password of the user used to connect to the database
     * @var String
     */
    protected $pwd;

    /**
     * Database to connect to.
     * @var String
     */
    protected $db;

    /**
     * Port to connect to the database server.
     * @var Integer
     */
    protected $port;

    /**
     * Path to the UNIX socket for localhost connection
     * @var String
     */
    protected $socket;

    /**
     * Instance of the Mysqli class
     * @var mysqli
     */
    protected $mysqli;

    /**
     * Constructor.
     *
     * @param Configuration   $configuration Shared instance of the configuration class
     * @param LoggerInterface $logger        Shared instance of a logger class
     * @param mysqli          $mysqli        Instance of the mysqli class
     */
    public function __construct($configuration, $logger, $mysqli)
    {
        parent::__construct($configuration, $logger);

        $this->mysqli =& $mysqli;

        $this->set_configuration();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->rollback();
        $this->disconnect();

        unset($this->mysqli);
        unset($this->rw_host);
        unset($this->ro_host);
        unset($this->user);
        unset($this->pwd);
        unset($this->db);
        unset($this->port);
        unset($this->socket);

        parent::__destruct();
    }

    /**
     * Set the configuration values.
     *
     * @return void
     */
    private function set_configuration()
    {
        $this->rw_host = $this->configuration['db']['rw_host'];
        $this->user    = $this->configuration['db']['username'];
        $this->pwd     = $this->configuration['db']['password'];
        $this->db      = $this->configuration['db']['database'];

        if (empty($this->configuration['db']['ro_host']))
        {
            $this->ro_host = $this->rw_host;
        }
        else
        {
            $this->ro_host = $this->configuration['db']['ro_host'];
        }

        if ($this->configuration['db']['port'] != NULL)
        {
            $this->port = $this->configuration['db']['port'];
        }
        else
        {
            $this->port = ini_get('mysqli.default_port');
        }

        if ($this->configuration['db']['socket'] != NULL)
        {
            $this->socket = $this->configuration['db']['socket'];
        }
        else
        {
            $this->socket = ini_get('mysqli.default_socket');
        }
    }

    /**
     * Establishes a connection to the defined mysql-server.
     *
     * @return void
     */
    public function connect()
    {
        if ($this->connected === TRUE)
        {
            return;
        }

        if ($this->configuration['db']['driver'] != 'mysql')
        {
            $this->logger->error('Cannot connect to a non-mysql database connection!');
            return;
        }

        $host = ($this->readonly === TRUE) ? $this->ro_host : $this->rw_host;

        $this->mysqli->connect($host, $this->user, $this->pwd, $this->db, $this->port, $this->socket);

        if ($this->mysqli->errno === 0)
        {
            $this->mysqli->set_charset('utf8');
            $this->connected = TRUE;
        }
    }

    /**
     * Disconnects from mysql-server.
     *
     * @return void
     */
    public function disconnect()
    {
        if ($this->connected !== TRUE)
        {
            return;
        }

        $this->mysqli->kill($this->mysqli->thread_id);
        $this->mysqli->close();
        $this->connected = FALSE;
    }

    /**
     * Change the default database for the current connection.
     *
     * @param String $db New default database
     *
     * @return Boolean True on success, False on Failure
     */
    public function change_database($db)
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return $this->mysqli->select_db($db);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Return a new instance of a QueryBuilder object.
     *
     * @return MySQLDMLQueryBuilder $builder New DatabaseDMLQueryBuilder object instance
     */
    public function get_new_dml_query_builder_object()
    {
        return new MySQLDMLQueryBuilder($this);
    }

    /**
     * Escape a string to be used in a SQL query.
     *
     * @param String $string The string to escape
     *
     * @return Mixed $return The escaped string on success, FALSE on error
     */
    public function escape_string($string)
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            $string = $this->mysqli->escape_string($string);
            return addcslashes($string, '%_');
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Run a SQL query.
     *
     * @param String $sql_query The SQL query to run on the database
     *
     * @return MySQLQueryResult $result Query Result
     */
    public function query($sql_query)
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return new MySQLQueryResult($sql_query, $this->mysqli->query($sql_query), $this->mysqli);
        }
        else
        {
            return new MySQLQueryResult($sql_query, FALSE, $this->mysqli);
        }
    }

    /**
     * Run an asynchronous SQL query.
     *
     * @param String $sql_query The SQL query to run on the database
     *
     * @return MySQLAsyncQueryResult $result Query Result
     */
    public function async_query($sql_query)
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            $this->mysqli->query($sql_query, MYSQLI_ASYNC);
        }

        return new MySQLAsyncQueryResult($sql_query, $this->mysqli);
    }

    /**
     * Begins a transaction.
     *
     * @return Boolean
     */
    public function begin_transaction()
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return $this->mysqli->autocommit(FALSE);
        }

        return FALSE;
    }

    /**
     * Commits a transaction.
     *
     * @return Boolean
     */
    public function commit()
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return $this->mysqli->commit();
        }

        return FALSE;
    }

    /**
     * Rolls back a transaction.
     *
     * @return Boolean
     */
    public function rollback()
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return $this->mysqli->rollback();
        }

        return FALSE;
    }

    /**
     * Ends a transaction.
     *
     * @return Boolean
     */
    public function end_transaction()
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return $this->mysqli->autocommit(TRUE);
        }

        return FALSE;
    }

}

?>
