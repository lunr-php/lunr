<?php

/**
 * Contains SQLite3QueryResultFailedTest class.
 *
 * PHP Version 5.6
 *
 * @package    Lunr\Gravity\Database\SQLite3
 * @author     Ruben de Groot <r.degroot@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
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
    public function setUp()
    {
        $this->setUpWithFailedQuery();
    }

    /**
     * Test that the success flag is FALSE.
     */
    public function testSuccessIsFalse()
    {
        $property = $this->get_accessible_reflection_property('success');

        $this->assertFalse($property->getValue($this->class));
    }

    /**
     * Test that the result value is FALSE.
     */
    public function testResultIsFalse()
    {
        $property = $this->get_accessible_reflection_property('result');

        $this->assertFalse($property->getValue($this->class));
    }

    /**
     * Test that the freed flag is TRUE.
     */
    public function testFreedIsTrue()
    {
        $property = $this->get_accessible_reflection_property('freed');

        $this->assertTrue($property->getValue($this->class));
    }

    /**
     * Test that the has_failed() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_failed
     */
    public function testHasFailedReturnsTrue()
    {
        $this->assertTrue($this->class->has_failed());
    }

    /**
     * Test that error message is a string on failed query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_message
     */
    public function testErrorMessageIsString()
    {
        $property = $this->get_accessible_reflection_property('error_message');

        $this->assertInternalType('string', $property->getValue($this->class));
    }

    /**
     * Test that error number is a number on a failed query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_number
     */
    public function testErrorNumberIsNumber()
    {
        $property = $this->get_accessible_reflection_property('error_number');

        $this->assertInternalType('int', $property->getValue($this->class));
    }

    /**
     * Test that error number is zero on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::insert_id
     */
    public function testInsertIDIsZero()
    {
        $property = $this->get_accessible_reflection_property('insert_id');

        $this->assertEquals(0, $property->getValue($this->class));
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_array
     */
    public function testResultArrayReturnsEmptyArray()
    {
        $value = $this->class->result_array();

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_row() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_row
     */
    public function testResultRowReturnsEmptyArray()
    {
        $value = $this->class->result_row();

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_column() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_column
     */
    public function testResultColumnReturnsEmptyArray()
    {
        $value = $this->class->result_column('column');

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_cell() returns NULL.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::result_cell
     */
    public function testResultCellReturnsNull()
    {
        $this->assertNull($this->class->result_cell('cell'));
    }

    /**
     * Test that the has_deadlock() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsTrue()
    {
        $this->set_reflection_property_value('error_number', 6);

        $this->assertTrue($this->class->has_deadlock());
    }

    /**
     * Test that the has_deadlock() method returns FALSE.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::has_deadlock
     */
    public function testHasDeadlockReturnsFalse()
    {
        $this->set_reflection_property_value('error_number', 999);

        $this->assertFalse($this->class->has_deadlock());
    }

}

?>