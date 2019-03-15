<?php

/**
 * Contains SQLite3QueryResultFailedTest class.
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

/**
 * This class contains the tests for testing a failed query.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultFailedTest extends SQLite3QueryResultTest
{

    /**
     * Override the default setUp with a setup with a failed query.
     */
    public function setUp(): void
    {
        $this->setUpWithFailedQuery();
    }

    /**
     * Test that the success flag is FALSE.
     */
    public function testSuccessIsFalse(): void
    {
        $property = $this->get_accessible_reflection_property('success');

        $this->assertFalse($property->getValue($this->class));
    }

    /**
     * Test that the result value is FALSE.
     */
    public function testResultIsFalse(): void
    {
        $property = $this->get_accessible_reflection_property('result');

        $this->assertFalse($property->getValue($this->class));
    }

    /**
     * Test that the freed flag is TRUE.
     */
    public function testFreedIsTrue(): void
    {
        $property = $this->get_accessible_reflection_property('freed');

        $this->assertTrue($property->getValue($this->class));
    }

    /**
     * Test that the has_failed() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_failed
     */
    public function testHasFailedReturnsTrue(): void
    {
        $this->assertTrue($this->class->has_failed());
    }

    /**
     * Test that error message is a string on failed query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_message
     */
    public function testErrorMessageIsString(): void
    {
        $property = $this->get_accessible_reflection_property('error_message');

        $this->assertIsString($property->getValue($this->class));
    }

    /**
     * Test that error number is a number on a failed query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_number
     */
    public function testErrorNumberIsNumber(): void
    {
        $property = $this->get_accessible_reflection_property('error_number');

        $this->assertIsInt($property->getValue($this->class));
    }

    /**
     * Test that error number is zero on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::insert_id
     */
    public function testInsertIDIsZero(): void
    {
        $property = $this->get_accessible_reflection_property('insert_id');

        $this->assertEquals(0, $property->getValue($this->class));
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayReturnsEmptyArray(): void
    {
        $value = $this->class->result_array();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_row() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowReturnsEmptyArray(): void
    {
        $value = $this->class->result_row();

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_column() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnReturnsEmptyArray(): void
    {
        $value = $this->class->result_column('column');

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_cell() returns NULL.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellReturnsNull(): void
    {
        $this->assertNull($this->class->result_cell('cell'));
    }

    /**
     * Test that the has_deadlock() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsTrue(): void
    {
        $this->set_reflection_property_value('error_number', 6);

        $this->assertTrue($this->class->has_deadlock());
    }

    /**
     * Test that the has_deadlock() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsFalse(): void
    {
        $this->set_reflection_property_value('error_number', 999);

        $this->assertFalse($this->class->has_deadlock());
    }

}

?>
