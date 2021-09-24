<?php

/**
 * This file contains the MySQLQueryResultTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use mysqli;
use mysqli_result;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the MySQLQueryResult class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
abstract class MySQLQueryResultTest extends LunrBaseTest
{

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
     * The executed query.
     * @var String
     */
    protected $query;

    /**
     * TestCase Constructor passing a MySQLi_result object.
     *
     * @return void
     */
    public function resultSetSetup(): void
    {
        $this->mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->query_result = new MockMySQLiResult($this->getMockBuilder('mysqli_result')
                                                        ->disableOriginalConstructor()
                                                        ->getMock());

        $this->query = 'SELECT * FROM table';

        $this->class = new MySQLQueryResult($this->query, $this->query_result, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryResult');
    }

    /**
     * TestCase Constructor passing FALSE as query result.
     *
     * @return void
     */
    public function failedSetup(): void
    {
        $this->query_result = FALSE;

        $this->mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->query = 'SELECT * FROM table';

        $this->class = new MySQLQueryResult($this->query, $this->query_result, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryResult');
    }

    /**
     * TestCase Constructor passing TRUE as query result.
     *
     * @return void
     */
    public function successfulSetup(): void
    {
        $this->query_result = TRUE;

        $this->mysqli = new MockMySQLiSuccessfulConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->query = 'SELECT * FROM table';

        $this->class = new MySQLQueryResult($this->query, $this->query_result, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryResult');
    }

    /**
     * TestCase Constructor passing a MySQLi_result object with warnings.
     *
     * @return void
     */
    public function warningSetup(): void
    {
        $this->mysqli = new MockMySQLiSuccessfulWarningConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->query_result = new MockMySQLiResult($this->getMockBuilder('mysqli_result')
                                                        ->disableOriginalConstructor()
                                                        ->getMock());

        $this->query = 'SELECT * FROM table';

        $this->class = new MySQLQueryResult($this->query, $this->query_result, $this->mysqli);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\MySQL\MySQLQueryResult');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->mysqli);
        unset($this->query_result);
        unset($this->query);
        unset($this->class);
        unset($this->reflection);
    }

}

?>
