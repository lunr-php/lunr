<?php

/**
 * MySQL database connection class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL;

use Lunr\Gravity\Database\DatabaseConnection;
use Lunr\Gravity\Database\DMLQueryBuilderInterface;
use Lunr\Gravity\Database\Exceptions\ConnectionException;

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
     * Mysqli options.
     * @var array
     */
    protected $options;

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

        $this->query_hint                                 = '';
        $this->options[ MYSQLI_OPT_INT_AND_FLOAT_NATIVE ] = TRUE;

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
        $this->rw_host     = $this->configuration['db']['rw_host'];
        $this->user        = $this->configuration['db']['username'];
        $this->pwd         = $this->configuration['db']['password'];
        $this->db          = $this->configuration['db']['database'];
        $this->ssl_key     = $this->configuration['db']['ssl_key'];
        $this->ssl_cert    = $this->configuration['db']['ssl_cert'];
        $this->ca_cert     = $this->configuration['db']['ca_cert'];
        $this->ca_path     = $this->configuration['db']['ca_path'];
        $this->cipher      = $this->configuration['db']['cipher'];

        if ($this->configuration['db']['ro_host'] != NULL)
        {
            $this->ro_host = $this->configuration['db']['ro_host'];
        }
        else
        {
            $this->ro_host = $this->rw_host;
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
            throw new ConnectionException('Cannot connect to a non-mysql database connection!');
        }

        $host = ($this->readonly === TRUE) ? $this->ro_host : $this->rw_host;

        if (isset($this->ssl_key, $this->ssl_cert, $this->ca_cert))
        {
            $this->mysqli->ssl_set($this->ssl_key, $this->ssl_cert, $this->ca_cert, $this->ca_path, $this->cipher);
        }

        foreach ($this->options as $key => $value)
        {
            $this->mysqli->options($key, $value);
        }

        $this->mysqli->connect($host, $this->user, $this->pwd, $this->db, $this->port, $this->socket);

        if ($this->mysqli->errno === 0)
        {
            $this->mysqli->set_charset('utf8mb4');
            $this->connected = TRUE;
        }

        if ($this->connected === FALSE)
        {
            throw new ConnectionException('Could not establish connection to the database!');
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
     * @param string $db New default database
     *
     * @return boolean True on success, False on Failure
     */
    public function change_database($db)
    {
        $this->connect();

        return $this->mysqli->select_db($db);
    }

    /**
     * Set option for the current connection.
     *
     * @param integer $key   Mysqli option key.
     * @param mixed   $value Mysqli option value.
     *
     * @return boolean True on success, False on Failure
     */
    public function set_option($key, $value)
    {
        if (is_int($key) === FALSE || is_null($value) === TRUE)
        {
            return FALSE;
        }

        $this->options[$key] = $value;

        return TRUE;
    }

    /**
     * Return a new instance of a QueryBuilder object.
     *
     * @param boolean $simple Whether to return a simple query builder or an advanced one.
     *
     * @return MySQLDMLQueryBuilder $builder New DatabaseDMLQueryBuilder object instance
     */
    public function get_new_dml_query_builder_object($simple = TRUE)
    {
        $querybuilder = new MySQLDMLQueryBuilder();
        if ($simple === TRUE)
        {
            return new MySQLSimpleDMLQueryBuilder($querybuilder, $this->get_query_escaper_object());
        }
        else
        {
            return $querybuilder;
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
     * @param string $string The string to escape
     *
     * @return mixed $return The escaped string
     */
    public function escape_string($string)
    {
        $this->connect();

        return $this->mysqli->escape_string($string);
    }

    /**
     * When running the query on a replication setup, hint to run the next query on the master server.
     *
     * @param string $style What hint style to use.
     *
     * @return MySQLConnection $self Self reference
     */
    public function run_on_master($style = 'maxscale')
    {
        switch ($style)
        {
            case 'maxscale':
                $this->query_hint = '/* maxscale route to master */';
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * When running the query on a replication setup, hint to run the next query on the slave server.
     *
     * @param string $style What hint style to use.
     *
     * @return MySQLConnection $self Self reference
     */
    public function run_on_slave($style = 'maxscale')
    {
        switch ($style)
        {
            case 'maxscale':
                $this->query_hint = '/* maxscale route to slave */';
                break;
            default:
                break;
        }

        return $this;
    }

    /**
     * Run a SQL query.
     *
     * @param string $sql_query The SQL query to run on the database
     *
     * @return MySQLQueryResult $result Query Result
     */
    public function query($sql_query)
    {
        $this->connect();

        $sql_query        = $this->query_hint . $sql_query;
        $this->query_hint = '';

        $this->logger->debug('query: {query}', ['query' => $sql_query]);

        $query_start = microtime(TRUE);
        $result      = $this->mysqli->query($sql_query);
        $query_end   = microtime(TRUE);

        $this->logger->debug('Query executed in ' . ($query_end - $query_start) . ' seconds');

        return new MySQLQueryResult($sql_query, $result, $this->mysqli);
    }

    /**
     * Run an asynchronous SQL query.
     *
     * @param string $sql_query The SQL query to run on the database
     *
     * @return MySQLAsyncQueryResult $result Query Result
     */
    public function async_query($sql_query)
    {
        $this->connect();

        $sql_query        = $this->query_hint . $sql_query;
        $this->query_hint = '';

        $this->logger->debug('query: {query}', ['query' => $sql_query]);

        $this->mysqli->query($sql_query, MYSQLI_ASYNC);

        return new MySQLAsyncQueryResult($sql_query, $this->mysqli);
    }

    /**
     * Begins a transaction.
     *
     * @return boolean
     */
    public function begin_transaction()
    {
        $this->connect();

        return $this->mysqli->autocommit(FALSE);
    }

    /**
     * Commits a transaction.
     *
     * @return boolean
     */
    public function commit()
    {
        $this->connect();

        return $this->mysqli->commit();
    }

    /**
     * Rolls back a transaction.
     *
     * @return boolean
     */
    public function rollback()
    {
        $this->connect();

        return $this->mysqli->rollback();
    }

    /**
     * Ends a transaction.
     *
     * @return boolean
     */
    public function end_transaction()
    {
        $this->connect();

        return $this->mysqli->autocommit(TRUE);
    }

}

?>
