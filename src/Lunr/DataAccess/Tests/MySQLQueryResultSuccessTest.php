<?php

/**
 * This file contains the MySQLQueryResultSuccessTest class.
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
 * based on a successful query without result.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\MySQLQueryResult
 */
class MySQLQueryResultSuccessTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->successfulSetup();
    }

    /**
     * Test that the success flag is TRUE.
     */
    public function testSuccessIsTrue()
    {
        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that the result value is TRUE.
     */
    public function testResultIsTrue()
    {
        $property = $this->result_reflection->getProperty('result');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
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
     * Test that the has_failed() method returns FALSE.
     *
     * @covers Lunr\DataAccess\MySQLQueryResult::has_failed
     */
    public function testHasFailedReturnsFalse()
    {
        $this->assertFalse($this->result->has_failed());
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\DataAccess\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('num_rows');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 10);

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
