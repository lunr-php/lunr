<?php

/**
 * This file contains the MySQLQueryResultFailedTest class.
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

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a failed query.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultFailedTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->failedSetup();
    }

    /**
     * Test that the success flag is FALSE.
     */
    public function testSuccessIsFalse()
    {
        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->result));
    }

    /**
     * Test that the result value is FALSE.
     */
    public function testResultIsFalse()
    {
        $property = $this->result_reflection->getProperty('result');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->result));
    }

    /**
     * Test that the freed flasg is TRUE.
     */
    public function testFreedIsTrue()
    {
        $property = $this->result_reflection->getProperty('freed');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that the has_failed() method returns TRUE.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsTrue()
    {
        $this->assertTrue($this->result->has_failed());
    }

    /**
     * Test that error message is a string on failed query.
     */
    public function testErrorMessageIsString()
    {
        $property = $this->result_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertEquals('bad', $property->getValue($this->result));
    }

    /**
     * Test that error number is a number on a failed query.
     */
    public function testErrorNumberIsNumber()
    {
        $property = $this->result_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertEquals(666, $property->getValue($this->result));
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testInsertIDIsZero()
    {
        $property = $this->result_reflection->getProperty('insert_id');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->result));
    }

    /**
     * Test that affected rows is a number on successful query.
     */
    public function testAffectedRowsIsNumber()
    {
        $property = $this->result_reflection->getProperty('affected_rows');
        $property->setAccessible(TRUE);

        $this->assertEquals(10, $property->getValue($this->result));
    }

    /**
     * Test that number of rows is a number on successful query.
     */
    public function testNumberOfRowsIsNumber()
    {
        $property = $this->result_reflection->getProperty('num_rows');
        $property->setAccessible(TRUE);

        $this->assertEquals(10, $property->getValue($this->result));
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('num_rows');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 666);

        $value = $this->result->number_of_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(666, $value);
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_array
     */
    public function testResultArrayReturnsEmptyArray()
    {
        $value = $this->result->result_array();

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_row() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_row
     */
    public function testResultRowReturnsEmptyArray()
    {
        $value = $this->result->result_row();

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_column() returns an empty array.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_column
     */
    public function testResultColumnReturnsEmptyArray()
    {
        $value = $this->result->result_column('column');

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that result_cell() returns NULL.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsNull()
    {
        $this->assertNull($this->result->result_cell('cell'));
    }

}

?>
