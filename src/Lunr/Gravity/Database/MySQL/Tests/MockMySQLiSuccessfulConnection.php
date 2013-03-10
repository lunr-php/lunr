<?php

/**
 * This file contains the MockMysqliSuccessfulConnection class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use \MySQLi;

/**
 * This class is a wrapper around MySQLi for a successful connection.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
class MockMySQLiSuccessfulConnection
{

    /**
     * Instance of a real MySQLi class.
     * @var MySQLi
     */
    private $mysqli;

    /**
     * Constructor.
     */
    public function __construct($mysqli)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->mysqli);
    }

    /**
     * Forward non-mocked methods to the MySQLi class.
     *
     * @param String $method    Method name
     * @param array  $arguments Arguments to that method
     *
     * @return mixed $return Return value of the respective MySQLi method.
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array(array($this->mysqli, $method), $arguments);
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
            case 'thread_id':
                return 666;
            case 'affected_rows':
                return 10;
            case 'errno':
                return 0;
            case 'error':
                return '';
            case 'insert_id':
                return 0;
            default:
                return $this->mysqli->{$name};
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
     * Fake killing the connection.
     *
     * @param Integer $thread_id The thread_id of the connection to kill.
     *
     * @return Boolean $return TRUE if the thread_id matches the faked one, FALSE otherwise.
     */
    public function kill($thread_id)
    {
        if ($thread_id === 666)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
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

}

?>
