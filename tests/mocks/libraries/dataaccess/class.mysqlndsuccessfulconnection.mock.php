<?php

/**
 * This file contains the MockMysqlndSuccessfulConnection class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Mocks
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use \MySQLndUhConnection;

/**
 * This class is a mysqlnd_uh connection handler mocking a successful connection.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLConnection
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
     * @return boolean $return Whether the connection was successful or not.
     */
    public function connect($connection , $host , $user , $password , $database , $port , $socket , $mysql_flags)
    {
        return TRUE;
    }

    /**
     * Return a fake thread ID.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     *
     * @return int $return Fake thread ID
     */
    public function getThreadId($connection)
    {
        return 666;
    }

    /**
     * Fake setting charset.
     *
     * @param mysqlnd_connection $connection Mysqlnd connection handle
     * @param string             $charset    Hostname or IP address
     *
     * @return boolean $return Whether setting the charset was successful or not.
     */
    public function setCharset($connection, $charset)
    {
        return TRUE;
    }

}

?>
