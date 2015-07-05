<?php

/**
 * This file contains the MockMysqli class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class is a wrapper around MySQLi for a successful connection.
 */
class MockMySQLi
{

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    /**
     * Destructor.
     */
    public function __destruct()
    {

    }

    /**
     * Fake property access to the MySQLi class.
     *
     * @param String $name Property name
     *
     * @return mixed $return Property value.
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'errno':
                return 0;
        }
    }

    /**
     * Fake a successful connection to the database server.
     *
     * @param string $host     Hostname or IP address
     * @param string $user     Username
     * @param string $password Password
     * @param string $database Database
     * @param int    $port     Port
     * @param string $socket   Socket
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return boolean $return Whether the connection was successful or not.
     */
    public function connect($host, $user, $password, $database, $port, $socket)
    {
        return TRUE;
    }

    /**
     * Fake setting charset.
     *
     * @param string $charset Hostname or IP address
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     *
     * @return boolean $return Whether setting the charset was successful or not.
     */
    public function set_charset($charset)
    {
        return TRUE;
    }

    /**
     * Used for establishing secure connections using SSL.
     *
     * @param string $key    The path name to the key file.
     * @param string $cert   The path name to the certificate file.
     * @param string $ca     The path name to the certificate authority file.
     * @param string $capath The pathname to a directory that contains trusted SSL CA certificates in PEM format.
     * @param string $cipher A list of allowable ciphers to use for SSL encryption.
     *
     * @return boolean $return Always returns TRUE
     */
    public function ssl_set($key, $cert, $ca, $capath, $cipher)
    {
        return TRUE;
    }

}

?>
