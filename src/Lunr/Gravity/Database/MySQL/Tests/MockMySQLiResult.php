<?php

/**
 * This file contains the MockMysqliResult class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use \MySQLi_result;

/**
 * This class is a wrapper around MySQLi_result.
 */
class MockMySQLiResult
{

    /**
     * Instance of a real MySQLi_result class.
     * @var MySQLi_result
     */
    private $mysqli_result;

    /**
     * Constructor.
     *
     * @param MySQLi_result $mysqli_result Instance of the MySQLi_result class
     */
    public function __construct($mysqli_result)
    {
        $this->mysqli_result = $mysqli_result;
    }

    /**
     * Destructor.
     */
    public function __destruct()
    {
        unset($this->mysqli_result);
    }

    /**
     * Forward non-mocked methods to the MySQLi class.
     *
     * @param string $method    Method name
     * @param array  $arguments Arguments to that method
     *
     * @return mixed $return Return value of the respective MySQLi method.
     */
    public function __call($method, $arguments)
    {
        return call_user_func_array([ $this->mysqli_result, $method ], $arguments);
    }

    /**
     * Fake property access to the MySQLi class.
     *
     * @param string $name Property name
     *
     * @return mixed $return Property value.
     */
    public function __get($name)
    {
        switch ($name)
        {
            case 'num_rows':
                return 5;
            default:
                return $this->mysqli_result->{$name};
        }
    }

}

?>
