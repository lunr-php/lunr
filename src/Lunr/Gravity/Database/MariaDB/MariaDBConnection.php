<?php

/**
* MariaDB database connection class.
*
* PHP Version 5.6
*
* @package    Aurora\Gravity\Database\MariaDB
* @author     Mathijs Visser <m.visser@m2mobi.com>
* @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
* @license    http://lunr.nl/LICENSE MIT License
*/

namespace Lunr\Gravity\Database\MariaDB;

use Lunr\Gravity\Database\MySQL\MySQLConnection;
use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
* MariaDB database access class.
*/
class MariaDBConnection extends MySQLConnection
{

    /**
     * Constructor.
     *
     * @param Configuration   $configuration Shared instance of the configuration class
     * @param LoggerInterface $logger        Shared instance of a logger class
     * @param mysqli          $mysqli        Instance of the mysqli class
     */
    public function __construct($configuration, $logger, $mysqli)
    {
        parent::__construct($configuration, $logger, $mysqli);
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
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
        $querybuilder = new MariaDBDMLQueryBuilder();
        if ($simple === TRUE)
        {
            return new MariaDBSimpleDMLQueryBuilder($querybuilder, $this->get_query_escaper_object());
        }
        else
        {
            return $querybuilder;
        }
    }

}

?>
