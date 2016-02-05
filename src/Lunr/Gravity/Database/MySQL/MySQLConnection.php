<?php

/**
 * MySQL database connection class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseConnection;

/**
 * MySQL/MariaDB database access class.
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
     * SQL hint to send along with the query.
     * @var String
     */
    protected $query_hint;

    /**
     * mysqlnd_ms QoS policy to use with the current connection.
     * @var Integer
     */
    protected $qos_policy;

    /**
     * The path name to the key file.
     * @var String
     */
    protected $ssl_key;

    /**
     * The path name to the certificate file.
     * @var String
     */
    protected $ssl_cert;

    /**
     * The path name to the certificate authority file.
     * @var String
     */
    protected $ca_cert;

    /**
     * The pathname to a directory that contains trusted SSL CA certificates in PEM format.
     * @var String
     */
    protected $ca_path;

    /**
     * A list of allowable ciphers to use for SSL encryption.
     * @var String
     */
    protected $cipher;

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

        $this->query_hint = '';
        $this->qos_policy = 2; //MYSQLND_MS_QOS_CONSISTENCY_EVENTUAL

        $this->set_configuration();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        if ($this->connected === TRUE)
        {
            $this->rollback();
            $this->disconnect();
        }

        unset($this->mysqli);
        unset($this->rw_host);
        unset($this->ro_host);
        unset($this->user);
        unset($this->pwd);
        unset($this->db);
        unset($this->port);
        unset($this->socket);
        unset($this->qos_policy);
        unset($this->query_hint);
        unset($this->ssl_key);
        unset($this->ssl_cert);
        unset($this->ca_cert);
        unset($this->ca_path);
        unset($this->cipher);

        parent::__destruct();
    }

    /**
     * Set the configuration values.
     *
     * @return void
     */
    private function set_configuration()
    {
        $this->rw_host  = $this->configuration['db']['rw_host'];
        $this->user     = $this->configuration['db']['username'];
        $this->pwd      = $this->configuration['db']['password'];
        $this->db       = $this->configuration['db']['database'];
        $this->ssl_key  = $this->configuration['db']['ssl_key'];
        $this->ssl_cert = $this->configuration['db']['ssl_cert'];
        $this->ca_cert  = $this->configuration['db']['ca_cert'];
        $this->ca_path  = $this->configuration['db']['ca_path'];
        $this->cipher   = $this->configuration['db']['cipher'];

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

        if(isset($this->ssl_key, $this->ssl_cert, $this->ca_cert))
        {
            $this->mysqli->ssl_set($this->ssl_key, $this->ssl_cert, $this->ca_cert, $this->ca_path, $this->cipher);
        }

        $this->mysqli->connect($host, $this->user, $this->pwd, $this->db, $this->port, $this->socket);

        if ($this->mysqli->errno === 0)
        {
            $this->mysqli->set_charset('utf8mb4');
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
     * @param Boolean $simple Whether to return a simple query builder or an advanced one.
     *
     * @return MySQLDMLQueryBuilder $builder New DatabaseDMLQueryBuilder object instance
     */
    public function get_new_dml_query_builder_object($simple = TRUE)
    {
        if ($simple === TRUE)
        {
            return new MySQLSimpleDMLQueryBuilder($this->get_query_escaper_object());
        }
        else
        {
            return new MySQLDMLQueryBuilder();
        }
    }

    /**
     * Return a new instance of a QueryEscaper object.
     *
     * @return MySQLQueryEscaper $escaper New MySQLQueryEscaper object instance
     */
    public function get_query_escaper_object()
    {
        if (isset($this->escaper) === FALSE)
        {
            $this->escaper = new MySQLQueryEscaper($this);
        }

        return $this->escaper;
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
            return $this->mysqli->escape_string($string);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * When running the query on a replication setup, hint to run the next query on the master server.
     *
     * @return MySQLConnection $self Self reference
     */
    public function run_on_master()
    {
        $this->query_hint = '/*ms=master*/'; // MYSQLND_MS_MASTER_SWITCH
        return $this;
    }

    /**
     * When running the query on a replication setup, hint to run the next query on the slave server.
     *
     * @return MySQLConnection $self Self reference
     */
    public function run_on_slave()
    {
        $this->query_hint = '/*ms=slave*/'; // MYSQLND_MS_SLAVE_SWITCH
        return $this;
    }

    /**
     * When running the query on a replication setup, hint to run the next query on the last used server.
     *
     * @return MySQLConnection $self Self reference
     */
    public function run_on_last_used()
    {
        $this->query_hint = '/*ms=last_used*/'; // MYSQLND_MS_LAST_USED_SWITCH
        return $this;
    }

    /**
     * Set the Quality of Service policy to use in a replication setup.
     *
     * @param Integer $policy mysqlnd_ms QoS policy
     *
     * @return Boolean $return TRUE if policy was set correctly, FALSE otherwise
     */
    public function set_qos_policy($policy)
    {
        return mysqlnd_ms_set_qos($this->mysqli, $policy);
    }

    /**
     * Get the currently configured Quality of Service policy.
     *
     * @return Integer $policy mysqlnd_ms QoS policy
     */
    public function get_qos_policy()
    {
        return $this->qos_policy;
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

        $sql_query        = $this->query_hint . $sql_query;
        $this->query_hint = '';

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

        $sql_query        = $this->query_hint . $sql_query;
        $this->query_hint = '';

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
