<?php

/**
 * This file contains the MockMysqlndSuccessfulConnection class.
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
class MockMySQLndSuccessfulConnection extends MySQLndUhConnection
{

    /**
     * Fake a successful connection to the database server.
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
     * Return a fake thread ID.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return int $return Fake thread ID
     */
    public function getThreadId($connection)
    {
        return 666;
    }

    /**
     * Return a fake number of affected rows.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return int $return Fake number of affected rows
     */
    public function getAffectedRows($connection)
    {
        return 10;
    }

    /**
     * Fake setting charset.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     * @param string             $charset    Hostname or IP address
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return boolean $return Whether setting the charset was successful or not.
     */
    public function setCharset($connection, $charset)
    {
        return TRUE;
    }

}

?>
