<?php

/**
 * This file contains the MySQLQueryResultFailedTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a failed query.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultFailedTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 10);

        $this->failedSetup();

        $this->unmock_function('mysqli_affected_rows');
    }

    /**
     * Test that the success flag is FALSE.
     */
    public function testSuccessIsFalse(): void
    {
        $this->assertFalse($this->get_reflection_property_value('success'));
    }

    /**
     * Test that the result value is FALSE.
     */
    public function testResultIsFalse(): void
    {
        $this->assertFalse($this->get_reflection_property_value('result'));
    }

    /**
     * Test that the freed flasg is TRUE.
     */
    public function testFreedIsTrue(): void
    {
        $this->assertTrue($this->get_reflection_property_value('freed'));
    }

    /**
     * Test that the has_failed() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsTrue(): void
    {
        $this->assertTrue($this->class->has_failed());
    }

    /**
     * Test that error message is a string on failed query.
     */
    public function testErrorMessageIsString(): void
    {
        $this->assertPropertyEquals('error_message', 'bad');
    }

    /**
     * Test that error number is a number on a failed query.
     */
    public function testErrorNumberIsNumber(): void
    {
        $this->assertPropertyEquals('error_number', 666);
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testInsertIDIsZero(): void
    {
        $this->assertPropertyEquals('insert_id', 0);
    }

    /**
     * Test that affected rows is a number on successful query.
     */
    public function testAffectedRowsIsNumber(): void
    {
        $this->assertPropertyEquals('affected_rows', 10);
    }

    /**
     * Test that number of rows is a number on successful query.
     */
    public function testNumberOfRowsIsNumber(): void
    {
        $this->assertPropertyEquals('num_rows', 10);
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber(): void
    {
        $this->set_reflection_property_value('num_rows', 666);

        $value = $this->class->number_of_rows();
        $this->assertIsInt($value);
        $this->assertEquals(666, $value);
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayReturnsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->class->result_array());
    }

    /**
     * Test that result_row() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowReturnsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->class->result_row());
    }

    /**
     * Test that result_column() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnReturnsEmptyArray(): void
    {
        $this->assertArrayEmpty($this->class->result_column('column'));
    }

    /**
     * Test that result_cell() returns NULL.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsNull(): void
    {
        $this->assertNull($this->class->result_cell('cell'));
    }

    /**
     * Test that the has_deadlock() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsTrue(): void
    {
        $this->set_reflection_property_value('error_number', 1213);

        $this->assertTrue($this->class->has_deadlock());
    }

    /**
     * Test that the has_deadlock() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsFalse(): void
    {
        $this->set_reflection_property_value('error_number', 999);

        $this->assertFalse($this->class->has_deadlock());
    }

    /**
     * Test that the has_lock_timeout() method returns TRUE.
     *
     * @covers \Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_lock_timeout
     */
    public function testLockTimeoutReturnsTrue(): void
    {
        $this->set_reflection_property_value('error_number', 1205);

        $this->assertTrue($this->class->has_lock_timeout());
    }

    /**
     * Test that the has_lock_timeout() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_lock_timeout
     */
    public function testLockTimeoutReturnsFalse(): void
    {
        $this->set_reflection_property_value('error_number', 999);

        $this->assertFalse($this->class->has_lock_timeout());
    }

}

?>
