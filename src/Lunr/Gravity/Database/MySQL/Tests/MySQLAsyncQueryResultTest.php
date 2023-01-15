<?php

/**
 * This file contains the MySQLAsyncQueryResultTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use mysqli;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLAsyncQueryResult class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult
 */
abstract class MySQLAsyncQueryResultTest extends LunrBaseTest
{

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
    public function setUp(): void
    {
        $this->mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->query = 'SELECT * FROM table';

        $this->class = new MySQLAsyncQueryResult($this->query, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLAsyncQueryResult');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->mysqli);
        unset($this->class);
        unset($this->reflection);
        unset($this->query);
    }

}

?>
