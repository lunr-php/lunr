<?php

/**
 * This file contains the MySQLAsyncQueryResultTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\MySQLAsyncQueryResult;
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
 * @covers     Lunr\DataAccess\MySQLAsyncQueryResult
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
     * The executed query.
     * @var String
     */
    protected $query;

    /**
     * TestCase Constructor passing TRUE as query result.
     */
    public function setUp()
    {
        $this->mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $this->query = 'SELECT * FROM table';

        $this->result = new MySQLAsyncQueryResult($this->query, $this->mysqli);

        $this->result_reflection = new ReflectionClass('Lunr\DataAccess\MySQLAsyncQueryResult');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->mysqli);
        unset($this->result);
        unset($this->result_reflection);
        unset($this->query);
    }

}

?>
