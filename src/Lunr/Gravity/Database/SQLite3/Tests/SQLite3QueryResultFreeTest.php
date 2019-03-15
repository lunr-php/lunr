<?php

/**
 * Contains SQLite3QueryResultFreeTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

/**
 * This class contains the tests for testing if the data is freed when there is a result.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultFreeTest extends SQLite3QueryResultTest
{

    /**
     * Override the default setUp with a setup with a result.
     */
    public function setUp(): void
    {
        $this->setUpWithResult();
    }

    /**
     * Test that free_result() does try to free the result data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::free_result
     */
    public function testFreeResultFreesIfFreedIsFalse(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('finalize');

        $method = $this->get_accessible_reflection_method('free_result');
        $method->invoke($this->class);
    }

    /**
     * Test that free_result() does not try to free the result data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::free_result
     */
    public function testFreeResultDoesNotFreeIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->sqlite3_result->expects($this->never())
                             ->method('finalize');

        $method = $this->get_accessible_reflection_method('free_result');
        $method->invoke($this->class);

        $this->set_reflection_property_value('freed', FALSE);
    }

    /**
     * Test that result_array() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayFreesDataIfFreedIsFalse(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('finalize');

        $this->class->result_array();
    }

    /**
     * Test that result_array() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->sqlite3_result->expects($this->never())
                             ->method('finalize');

        $this->class->result_array();
    }

    /**
     * Test that result_row() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowFreesDataIfFreedIsFalse(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('finalize');

        $this->class->result_row();
    }

    /**
     * Test that result_row() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->sqlite3_result->expects($this->never())
                             ->method('finalize');

        $this->class->result_row();
    }

    /**
     * Test that result_column() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnFreesDataIfFreedIsFalse(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('finalize');

        $this->class->result_column('col');
    }

    /**
     * Test that result_column() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->sqlite3_result->expects($this->never())
                             ->method('finalize');

        $this->class->result_column('col');
    }

    /**
     * Test that result_cell() will free the fetched data if freed is FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellFreesDataIfFreedIsFalse(): void
    {
        $this->sqlite3_result->expects($this->once())
                             ->method('finalize');

        $this->class->result_cell('cell');
    }

    /**
     * Test that result_cell() will not free the fetched data if freed is TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellDoesNotFreeDataIfFreedIsTrue(): void
    {
        $this->set_reflection_property_value('freed', TRUE);

        $this->sqlite3_result->expects($this->never())
                             ->method('finalize');

        $this->class->result_cell('cell');
    }

}

?>
