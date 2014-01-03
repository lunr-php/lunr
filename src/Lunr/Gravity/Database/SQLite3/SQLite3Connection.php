<?php

/**
 * SQLite database connection class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3;

use Lunr\Gravity\Database\DatabaseConnection;

/**
 * SQLite database access class.
 *
 * @category   SQLite3
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Olivier Wizen <olivier@m2mobi.com>
 */
class SQLite3Connection extends DatabaseConnection
{

    /**
     * Database to connect to.
     * @var String
     */
    protected $db;

    /**
     * Instance of the SQLite3 class
     * @var SQLite3
     */
    protected $sqlite3;

    /**
     * Constructor.
     *
     * @param Configuration   $configuration Shared instance of the configuration class
     * @param LoggerInterface $logger        Shared instance of a logger class
     * @param LunrSQLite3     $sqlite3       Instance of the LunrSQLite3 class
     */
    public function __construct($configuration, $logger, $sqlite3)
    {
        parent::__construct($configuration, $logger);

        $this->sqlite3 =& $sqlite3;

        $this->set_configuration();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->disconnect();

        unset($this->sqlite3);
        unset($this->db);

        parent::__destruct();
    }

    /**
     * Set the configuration values.
     *
     * @return void
     */
    private function set_configuration()
    {
        $this->db = isset($this->configuration['db']['file']) ? $this->configuration['db']['file'] : ':memory:';
    }

    /**
     * Establishes a connection to the defined database.
     *
     * @return void
     */
    public function connect()
    {
        if($this->connected === TRUE)
        {
            return;
        }

        if ($this->configuration['db']['driver'] != 'sqlite3')
        {
            $this->logger->error('Cannot connect to a non-sqlite3 database connection!');
            return;
        }

        $flag = $this->readonly ? SQLITE3_OPEN_READONLY : SQLITE3_OPEN_READWRITE;

        $this->sqlite3->open($this->db, $flag | SQLITE3_OPEN_CREATE, '');

        if($this->sqlite3->lastErrorCode() === 0)
        {
            $this->connected = TRUE;
        }
    }

    /**
     * Disconnects from database.
     *
     * @return void
     */
    public function disconnect()
    {
        if($this->connected !== TRUE)
        {
            return;
        }

        $this->sqlite3->close();

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
        $this->db = $db;

        $this->disconnect();

        $this->connect();

        return $this->connected;
    }

    /**
     * Return a new instance of a QueryBuilder object.
     *
     * @return SQLite3DMLQueryBuilder $builder New SQLite3DMLQueryBuilder object instance
     */
    public function get_new_dml_query_builder_object()
    {
        return new SQLite3DMLQueryBuilder();
    }

    /**
     * Return a new instance of a QueryEscaper object.
     *
     * @return SQLite3QueryEscaper $escaper New SQLite3QueryEscaper object instance
     */
    public function get_query_escaper_object()
    {
        if (isset($this->escaper) === FALSE)
        {
            $this->escaper = new SQLite3QueryEscaper($this);
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
        return $this->sqlite3->escapeString($string);
    }

    /**
     * Run a SQL query.
     *
     * @param String $sql_query The SQL query to run on the database
     *
     * @return DMLQueryBuilderInterface $result Query Result
     */
    public function query($sql_query)
    {
        $this->connect();

        if ($this->connected === TRUE)
        {
            return NULL;
        }
        else
        {
            return NULL;
        }
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
            return $this->sqlite3->exec('BEGIN TRANSACTION');
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
            return $this->sqlite3->exec('COMMIT TRANSACTION');
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
            return $this->sqlite3->exec('ROLLBACK TRANSACTION');
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
            return $this->sqlite3->exec('END TRANSACTION');
        }

        return FALSE;
    }

}

?>
