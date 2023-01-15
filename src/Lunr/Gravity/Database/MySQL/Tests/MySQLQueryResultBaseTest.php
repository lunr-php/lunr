<?php

/**
 * This file contains the MySQLQueryResultBaseTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLQueryResult;

/**
 * This class contains basic tests for the MySQLQueryResult class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult
 */
class MySQLQueryResultBaseTest extends MySQLQueryResultTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->mock_function('mysqli_affected_rows', fn() => 10);

        $this->successfulSetup();

        $this->unmock_function('mysqli_affected_rows');
    }

    /**
     * Test that error message is empty on successful query.
     */
    public function testErrorMessageIsEmpty(): void
    {
        $this->assertPropertyEquals('error_message', '');
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testErrorNumberIsZero(): void
    {
        $this->assertPropertyEquals('error_number', 0);
    }

    /**
     * Test that warning is NULL on successful query.
     */
    public function testWarningsIsNull(): void
    {
        $this->assertNull($this->get_reflection_property_value('warnings'));
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
     * Test that error message is empty on successful query.
     */
    public function testQueryIsPassedCorrectly(): void
    {
        $this->assertPropertyEquals('query', $this->query);
    }

    /**
     * Test that affected_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::affected_rows
     */
    public function testAffectedRowsReturnsNumber(): void
    {
        $this->set_reflection_property_value('affected_rows', 10);

        $value = $this->class->affected_rows();
        $this->assertIsInt($value);
        $this->assertEquals(10, $value);
    }

    /**
     * Test that number_of_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::number_of_rows
     */
    public function testNumberOfRowsReturnsNumber(): void
    {
        $this->set_reflection_property_value('num_rows', 10);

        $value = $this->class->number_of_rows();
        $this->assertIsInt($value);
        $this->assertEquals(10, $value);
    }

    /**
     * Test that error_message() returns a string.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::error_message
     */
    public function testErrorMessageReturnsString(): void
    {
        $this->set_reflection_property_value('error_message', '');

        $value = $this->class->error_message();
        $this->assertIsString($value);
        $this->assertEquals('', $value);
    }

    /**
     * Test that error_number() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::error_number
     */
    public function testErrorNumberReturnsNumber(): void
    {
        $this->set_reflection_property_value('error_number', 0);

        $value = $this->class->error_number();
        $this->assertIsInt($value);
        $this->assertEquals(0, $value);
    }

    /**
     * Test that insert_id() returns a number.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::insert_id
     */
    public function testInsertIDReturnsNumber(): void
    {
        $this->set_reflection_property_value('insert_id', 0);

        $value = $this->class->insert_id();
        $this->assertIsInt($value);
        $this->assertEquals(0, $value);
    }

    /**
     * Test that query() returns a string.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::query
     */
    public function testQueryReturnsString(): void
    {
        $this->set_reflection_property_value('query', 'SELECT * FROM table1');

        $value = $this->class->query();
        $this->assertIsString($value);
        $this->assertEquals('SELECT * FROM table1', $value);
    }

    /**
     * Test that the mysqli class is passed by reference.
     */
    public function testMysqliIsPassedByReference(): void
    {
        $value = $this->get_reflection_property_value('mysqli');

        $this->assertInstanceOf('Lunr\Gravity\Database\MySQL\Tests\MockMySQLiSuccessfulConnection', $value);
        $this->assertSame($this->mysqli, $value);
    }

    /**
     * Test that canonical_query() returns a string.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLQueryResult::canonical_query
     */
    public function testCanonicalQuery(): void
    {
        $this->set_reflection_property_value('query', 'SELECT * FROM table1 WHERE value="test"');

        $value = $this->class->canonical_query();
        $this->assertIsString($value);
        $this->assertEquals('SELECT * FROM table1 WHERE value="?"', $value);

        $this->set_reflection_property_value('canonical_query', 'SELECT * FROM table2 WHERE value=?');
        $value = $this->class->canonical_query();
        $this->assertIsString($value);
        $this->assertEquals('SELECT * FROM table2 WHERE value=?', $value);
    }

}

?>
