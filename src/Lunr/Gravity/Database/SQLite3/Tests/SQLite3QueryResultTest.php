<?php

/**
 * Contains SQLite3QueryResultTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3QueryResult;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use SQLite3;
use SQLite3Result;

/**
 * This class contains common constructors/destructors and data providers
 * for testing the SQLite3QueryResult class.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultTest extends LunrBaseTest
{

    /**
     * Instance of the SQLite3 class.
     * @var SQLite3
     */
    protected $sqlite3;

    /**
     * The executed query.
     * @var String
     */
    protected $query;

    /**
     * Instance of the SQLite3Result class.
     * @var SQLite3Result
     */
    protected $sqlite3_result;

    /**
     * TestCase Constructor passing a SQLite3Result object.
     *
     * @return void
     */
    public function setUpWithResult()
    {
        $this->sqlite3 = $this->getMock('Lunr\Gravity\Database\SQLite3\LunrSQLite3');

        $this->query = 'SELECT * FROM table';

        $this->sqlite3_result = $this->getMockBuilder('SQLite3Result')
                                     ->disableOriginalConstructor()
                                     ->getMock();

        $this->class = new SQLite3QueryResult($this->query, $this->sqlite3_result, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3QueryResult');
    }

    /**
     * TestCase Constructor with a TRUE instead of a SQLite3Result object.
     *
     * @return void
     */
    public function setUpWithNoResult()
    {
        $this->sqlite3 = $this->getMock('Lunr\Gravity\Database\SQLite3\LunrSQLite3');

        $this->query = 'SELECT * FROM table';

        $this->sqlite3_result = TRUE;

        $this->class = new SQLite3QueryResult($this->query, $this->sqlite3_result, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3QueryResult');

        $this->set_reflection_property_value('affected_rows', 12);
        $this->set_reflection_property_value('insert_id', 0);
        $this->set_reflection_property_value('error_message', '');
        $this->set_reflection_property_value('error_number', 0);
    }

    /**
     * TestCase Constructor with a FALSE instead of a SQLite3Result object.
     *
     * @return void
     */
    public function setUpWithFailedQuery()
    {
        $this->sqlite3 = $this->getMock('Lunr\Gravity\Database\SQLite3\LunrSQLite3');

        $this->query = 'SELECT * FROM table';

        $this->sqlite3_result = FALSE;

        $this->class = new SQLite3QueryResult($this->query, $this->sqlite3_result, $this->sqlite3);

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\SQLite3\SQLite3QueryResult');

        $this->set_reflection_property_value('error_message', 'The query failed.');
        $this->set_reflection_property_value('error_number', 8);
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->sqlite3);
        unset($this->query);
        unset($this->sqlite3_result);
        unset($this->class);
        unset($this->reflection);
    }

}

?>