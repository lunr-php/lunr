<?php

/**
 * This file contains the MockMysqlndFailedConnection class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use \MySQLndUhConnection;

/**
 * This class is a mysqlnd_uh connection handler mocking a successful connection.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockMySQLndFailedConnection extends MySQLndUhConnection
{

    /**
     * Fake a failed connection to the database server.
     *
     * @param mysqlnd_connection $connection  Mysqlnd connection handle
     * @param string             $host        Hostname or IP address
     * @param string             $user        Username
     * @param string             $password    Password
     * @param string             $database    Database
     * @param int                $port        Port
     * @param string             $socket      Socket
     * @param int                $mysql_flags Connection options
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return boolean $return Whether the connection was successful or not.
     */
    public function connect($connection, $host, $user, $password, $database, $port, $socket, $mysql_flags)
    {
        return TRUE;
    }

    /**
     * Return a fake error number.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return int $return Fake error number
     */
    public function getErrorNumber($connection)
    {
        return 666;
    }

    /**
     * Assume failed query.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return int $return Assume failed query
     */
    public function reapQuery($connection)
    {
        return FALSE;
    }

}

?>
