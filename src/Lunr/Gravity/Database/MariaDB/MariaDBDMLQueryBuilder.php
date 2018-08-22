<?php

/**
 * MySQL/MariaDB database query builder class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Mathijs Visser <m.visser@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MariaDB;

use Lunr\Gravity\Database\MySQL\MySQLDMLQueryBuilder;

/**
 * This is a SQL query builder class for generating queries for MariaDB.
 */
class MariaDBDMLQueryBuilder extends MySQLDMLQueryBuilder
{

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        parent::__destruct();
    }

}
