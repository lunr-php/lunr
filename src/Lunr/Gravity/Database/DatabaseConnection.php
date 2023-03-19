<?php

/**
 * Abtract database connection class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database;

use \Lunr\Core\Configuration;
use \Psr\Log\LoggerInterface;

/**
 * This class defines abstract database access.
 */
abstract class DatabaseConnection
{

    /**
     * Connection status
     * @var Boolean
     */
    protected $connected;

    /**
     * Whether there's write access to the database or not
     * @var Boolean
     */
    protected $readonly;

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
     * Instance of the DatabaseQueryEscaper
     * @var DatabaseQueryEscaper
     */
    protected $escaper;

    /**
     * Constructor.
     *
     * @param Configuration   $configuration Shared instance of the configuration class
     * @param LoggerInterface $logger        Shared instance of a logger class
     */
    public function __construct($configuration, $logger)
    {
        $this->connected = FALSE;
        $this->readonly  = FALSE;

        $this->configuration = $configuration;
        $this->logger        = $logger;
        $this->escaper       = NULL;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->escaper);
        unset($this->readonly);
        unset($this->connected);
    }

    /**
     * Toggle readonly flag on the connection.
     *
     * @param bool $switch Whether to make the connection readonly or not
     *
     * @return void
     */
    public function set_readonly($switch)
    {
        $this->readonly = $switch;
    }

    /**
     * Establishes a connection to the defined database server.
     *
     * @return void
     */
    public abstract function connect();

    /**
     * Disconnects from database server.
     *
     * @return void
     */
    public abstract function disconnect();

    /**
     * Change the default database for the current connection.
     *
     * @param string $db New default database
     *
     * @return bool True on success, False on Failure
     */
    public abstract function change_database($db);

    /**
     * Get the name of the database we're currently connected to.
     *
     * @return string Database name
     */
    public abstract function get_database();

    /**
     * Return a new instance of a QueryBuilder object.
     *
     * @return DatabaseDMLQueryBuilder $builder New DatabaseDMLQueryBuilder object instance
     */
    public abstract function get_new_dml_query_builder_object();

    /**
     * Return a new instance of a QueryEscaper object.
     *
     * @return DatabaseQueryEscaper $escaper New DatabaseQueryEscaper object instance
     */
    public abstract function get_query_escaper_object();

    /**
     * Escape a string to be used in a SQL query.
     *
     * @param string $string The string to escape
     *
     * @return mixed $return The escaped string on success, FALSE on error
     */
    public abstract function escape_string($string);

    /**
     * Run a SQL query.
     *
     * @param string $sql_query The SQL query to run on the database
     *
     * @return DatabaseQueryResultInterface $result Query Result
     */
    public abstract function query($sql_query);

    /**
     * Begin a transaction.
     *
     * @return void
     */
    public abstract function begin_transaction();

    /**
     * Commit a transaction.
     *
     * @return void
     */
    public abstract function commit();

    /**
     * Roll back a transaction.
     *
     * @return void
     */
    public abstract function rollback();

    /**
     * Ends a transaction.
     *
     * @return void
     */
    public abstract function end_transaction();

}

?>
