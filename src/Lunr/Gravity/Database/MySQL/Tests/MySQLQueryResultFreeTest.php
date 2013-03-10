<?php

/**
 * This file contains the MySQLQueryResultFreeTest class.
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

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;
use MySQLi_Result;

/**
 * This class contains tests for the freeing of data in the MySQLQueryResult class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultFreeTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->resultSetSetup();
    }

    /**
     * Test that free_result() does try to free the result data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::free_result
     */
    public function testFreeResultFreesIfFreedIsFalse()
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $method = $this->result_reflection->getMethod('free_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);
    }

    /**
     * Test that free_result() does not try to free the result data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::free_result
     */
    public function testFreeResultDoesNotFreeIfFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->mysqli->expects($this->never())
                     ->method('free');

        $method = $this->result_reflection->getMethod('free_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property->setValue($this->result, FALSE);
    }

    /**
     * Test that result_array() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayFreesDataIfFreedIsFalse()
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->result->result_array();
    }

    /**
     * Test that result_array() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayDoesNotFreeDataIfFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->result->result_array();
    }

    /**
     * Test that result_row() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowFreesDataIfFreedIsFalse()
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->result->result_row();
    }

    /**
     * Test that result_row() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowDoesNotFreeDataIfFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->result->result_row();
    }

    /**
     * Test that result_column() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnFreesDataIfFreedIsFalse()
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->result->result_column('col');
    }

    /**
     * Test that result_column() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnDoesNotFreeDataIfFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->result->result_column('col');
    }

    /**
     * Test that result_cell() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellFreesDataIfFreedIsFalse()
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->result->result_cell('cell');
    }

    /**
     * Test that result_cell() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellDoesNotFreeDataIfFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->result->result_cell('cell');
    }

}

?>
