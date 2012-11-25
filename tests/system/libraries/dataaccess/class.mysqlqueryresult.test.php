<?php

/**
 * This file contains the MySQLQueryResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\DataAccess;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use mysqli;
use mysqli_result;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLQueryResult
 */
abstract class MySQLQueryResultTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the MySQLQueryResult class.
     * @var MySQLQueryResult
     */
    protected $result;

    /**
     * Reflection instance of the MySQLQueryResult class.
     * @var ReflectionClass
     */
    protected $result_reflection;

    /**
     * Query result
     * @var mixed
     */
    protected $query_result;

    /**
     * Instance of the mysqli class.
     * @var mysqli
     */
    protected $mysqli;

    /**
     * TestCase Constructor passing a MySQLi_result object.
     *
     * @return void
     */
    public function resultSetSetup()
    {
        $this->mysqli = $this->getMock('\mysqli');

        $this->query_result = $this->getMockBuilder('mysqli_result')
                                   ->disableOriginalConstructor()
                                   ->getMock();

        $this->result = new MySQLQueryResult($this->query_result, $this->mysqli);

        $this->result_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLQueryResult');
    }

    /**
     * TestCase Constructor passing FALSE as query result.
     *
     * @return void
     */
    public function failedSetup()
    {
        $this->query_result = FALSE;

        $this->mysqli = new mysqli();

        $this->result = new MySQLQueryResult($this->query_result, $this->mysqli);

        $this->result_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLQueryResult');
    }

    /**
     * TestCase Constructor passing TRUE as query result.
     *
     * @return void
     */
    public function successfulSetup()
    {
        $this->query_result = TRUE;

        $this->mysqli = new mysqli();

        $this->result = new MySQLQueryResult($this->query_result, $this->mysqli);

        $this->result_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLQueryResult');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->mysqli);
        unset($this->query_result);
        unset($this->result);
        unset($this->result_reflection);
    }

}

?>
