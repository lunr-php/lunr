<?php

/**
 * This file contains the MySQLAsyncQueryResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use mysqli;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLAsyncQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLAsyncQueryResult
 */
abstract class MySQLAsyncQueryResultTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the MySQLQueryResult class.
     * @var MySQLAsyncQueryResult
     */
    protected $result;

    /**
     * Reflection instance of the MySQLQueryResult class.
     * @var ReflectionClass
     */
    protected $result_reflection;

    /**
     * Mock instance of the mysqli class.
     * @var mysqli
     */
    protected $mysqli;

    /**
     * TestCase Constructor passing TRUE as query result.
     */
    public function setUp()
    {
        $this->mysqli = $this->getMock('mysqli');

        $this->result = new MySQLAsyncQueryResult($this->mysqli);

        $this->result_reflection = new ReflectionClass('Lunr\Libraries\DataAccess\MySQLAsyncQueryResult');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->mysqli);
        unset($this->result);
        unset($this->result_reflection);
    }

}

?>
