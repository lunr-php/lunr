<?php

/**
 * This file contains the MySQLQueryResultFreeTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;
use MySQLi_Result;

/**
 * This class contains tests for the freeing of data in the MySQLQueryResult class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultFreeTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 10);
        $this->mock_function('mysqli_num_rows', fn() => 10);

        $this->resultSetSetup();

        $this->unmock_function('mysqli_affected_rows');
        $this->unmock_function('mysqli_num_rows');
    }

    /**
     * Test that free_result() does try to free the result data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::free_result
     */
    public function testFreeResultFreesIfFreedIsFalse(): void
    {
        $this->query_result->expects($this->once())
                    ->method('free');

        $method = $this->get_accessible_reflection_method('free_result');

        $method->invoke($this->class);
    }

    /**
     * Test that free_result() does not try to free the result data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::free_result
     */
    public function testFreeResultDoesNotFreeIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->query_result->expects($this->never())
                    ->method('free');

        $method = $this->get_accessible_reflection_method('free_result');

        $method->invoke($this->class);

        // $this->set_reflection_property_value('freed', FALSE);
    }

    /**
     * Test that result_array() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayFreesDataIfFreedIsFalse(): void
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->class->result_array();
    }

    /**
     * Test that result_array() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->class->result_array();
    }

    /**
     * Test that result_row() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowFreesDataIfFreedIsFalse(): void
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->class->result_row();
    }

    /**
     * Test that result_row() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->class->result_row();
    }

    /**
     * Test that result_column() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnFreesDataIfFreedIsFalse(): void
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->class->result_column('col');
    }

    /**
     * Test that result_column() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->class->result_column('col');
    }

    /**
     * Test that result_cell() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellFreesDataIfFreedIsFalse(): void
    {
        $this->query_result->expects($this->once())
                           ->method('free');

        $this->class->result_cell('cell');
    }

    /**
     * Test that result_cell() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->query_result->expects($this->never())
                           ->method('free');

        $this->class->result_cell('cell');
    }

}

?>
