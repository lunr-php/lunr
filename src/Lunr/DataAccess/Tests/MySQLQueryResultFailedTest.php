<?php

/**
 * This file contains the MySQLQueryResultFailedTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\MySQLQueryResult;

/**
 * This class contains tests for the MySQLQueryResult class
 * based on a failed query.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\MySQLQueryResult
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
     * @covers Lunr\DataAccess\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsTrue()
    {
        $this->assertTrue($this->result->has_failed());
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\DataAccess\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->result_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, $mysqli);

        $value = $this->result->number_of_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(10, $value);
    }

    /**
     * Test that result_array() returns an empty array.
     *
     * @covers Lunr\DataAccess\MySQLQueryResult::result_array
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
     * @covers Lunr\DataAccess\MySQLQueryResult::result_row
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
     * @covers Lunr\DataAccess\MySQLQueryResult::result_column
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
     * @covers Lunr\DataAccess\MySQLQueryResult::result_cell
     */
    public function testResultCellReturnsNull()
    {
        $this->assertNull($this->result->result_cell('cell'));
    }

}

?>
