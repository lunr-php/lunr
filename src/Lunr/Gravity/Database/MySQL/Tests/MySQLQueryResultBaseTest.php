<?php

/**
 * This file contains the MySQLQueryResultBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;

/**
 * This class contains basic tests for the MySQLQueryResult class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultBaseTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->successfulSetup();
    }

    /**
     * Test that error message is empty on successful query.
     */
    public function testErrorMessageIsEmpty()
    {
        $property = $this->result_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->result));
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testErrorNumberIsZero()
    {
        $property = $this->result_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->result));
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
     * Test that error message is empty on successful query.
     */
    public function testQueryIsPassedCorrectly()
    {
        $property = $this->result_reflection->getProperty('query');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->query, $property->getValue($this->result));
    }

    /**
     * Test that affected_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::affected_rows
     */
    public function testAffectedRowsReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('affected_rows');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 10);

        $value = $this->result->affected_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(10, $value);
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
        $class->setValue($this->result, 10);

        $value = $this->result->number_of_rows();
        $this->assertInternalType('int', $value);
        $this->assertEquals(10, $value);
    }

    /**
     * Test that error_message() returns a string.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::error_message
     */
    public function testErrorMessageReturnsString()
    {
        $class = $this->result_reflection->getProperty('error_message');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, '');

        $value = $this->result->error_message();
        $this->assertInternalType('string', $value);
        $this->assertEquals('', $value);
    }

    /**
     * Test that error_number() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::error_number
     */
    public function testErrorNumberReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('error_number');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 0);

        $value = $this->result->error_number();
        $this->assertInternalType('int', $value);
        $this->assertEquals(0, $value);
    }

    /**
     * Test that insert_id() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::insert_id
     */
    public function testInsertIDReturnsNumber()
    {
        $class = $this->result_reflection->getProperty('insert_id');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 0);

        $value = $this->result->insert_id();
        $this->assertInternalType('int', $value);
        $this->assertEquals(0, $value);
    }

    /**
     * Test that query() returns a string.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::query
     */
    public function testQueryReturnsString()
    {
        $class = $this->result_reflection->getProperty('query');
        $class->setAccessible(TRUE);
        $class->setValue($this->result, 'SELECT * FROM table1');

        $value = $this->result->query();
        $this->assertInternalType('string', $value);
        $this->assertEquals('SELECT * FROM table1', $value);
    }

    /**
     * Test that the mysqli class is passed by reference.
     */
    public function testMysqliIsPassedByReference()
    {
        $property = $this->result_reflection->getProperty('mysqli');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->result);

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\Tests\MockMySQLiSuccessfulConnection', $value);
        $this->assertSame($this->mysqli, $value);
    }

}

?>
