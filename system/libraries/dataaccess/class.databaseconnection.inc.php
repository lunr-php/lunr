<?php

/**
 * Abtract database connection class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;

/**
 * This class defines abstract database access.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     M2Mobi <info@m2mobi.com>
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
     * Reference to the Configuration class
     * @var Configuration
     */
    protected $configuration;

    /**
     * Reference to the Logger class
     * @var Logger
     */
    protected $logger;

    /**
     * Constructor.
     *
     * @param Configuration &$configuration Reference to the configuration class
     * @param Logger        &$logger        Reference to the logger class
     * @param Boolean       $readonly Whether the database access should
     *                                be established readonly
     */
    public function __construct(&$configuration, &$logger, $readonly = TRUE)
    {
        $this->connected = FALSE;
        $this->readonly  = $readonly;

        $this->configuration =& $configuration;
        $this->logger        =& $logger;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        $this->configuration = NULL;
        $this->logger        = NULL;

        unset($this->readonly);
        unset($this->connected);
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
     * @param String $db New default database
     *
     * @return Boolean True on success, False on Failure
     */
    public abstract function change_database($db);

    /**
     * Return a new instance of a QueryBuilder object.
     *
     * @return DatabaseDMLQueryBuilder $builder New DatabaseDMLQueryBuilder object instance
     */
    public abstract function get_new_dml_query_builder_object();

}

?>
