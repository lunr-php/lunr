<?php

/**
 * Contains SQLite3QueryResultBaseTest class.
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
 * This class contains the basic tests.
 *
 * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult
 */
class SQLite3QueryResultBaseTest extends SQLite3QueryResultTest
{

    /**
     * Override the default setUp with a setup with no result.
     */
    public function setUp()
    {
        $this->setUpWithNoResult();
    }

    /**
     * Test that error message is empty on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_message
     */
    public function testErrorMessageIsEmpty()
    {
        $property = $this->get_accessible_reflection_property('error_message');
        $this->assertSame('', $property->getValue($this->class));
    }

    /**
     * Test that error number is zero on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::error_number
     */
    public function testErrorNumberIsZero()
    {
        $property = $this->get_accessible_reflection_property('error_number');
        $this->assertSame(0, $property->getValue($this->class));
    }

    /**
     * Test that error number is zero on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::insert_id
     */
    public function testInsertIDIsZero()
    {
        $property = $this->get_accessible_reflection_property('insert_id');
        $this->assertSame(0, $property->getValue($this->class));
    }

    /**
     * Test that affected rows is a number on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::affected_rows
     */
    public function testAffectedRowsIsNumber()
    {
        $property = $this->get_accessible_reflection_property('affected_rows');
        $this->assertInternalType('int', $property->getValue($this->class));
    }

    /**
     * Test that the query is passed correctly on successful query.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::query
     */
    public function testQueryIsPassedCorrectly()
    {
        $property = $this->get_accessible_reflection_property('query');
        $this->assertSame($this->query, $property->getValue($this->class));
    }

    /**
     * Test that affected_rows() returns a number.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3QueryResult::affected_rows
     */
    public function testAffectedRowsReturnsNumber()
    {
        $this->set_reflection_property_value('affected_rows', 12);
        $this->assertSame(12, $this->class->affected_rows());
    }
 
    /**
     * Test that error_message() returns a string.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQlite3QueryResult::error_message
     */
    public function testErrorMessageReturnsString()
    {
        $this->set_reflection_property_value('error_message', '');
        $this->assertSame('', $this->class->error_message());
    }

    /**
     * Test that error_number() returns a number.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQlite3QueryResult::error_number
     */
    public function testErrorNumberReturnsNumber()
    {
        $this->set_reflection_property_value('error_number', 0);
        $this->assertSame(0, $this->class->error_number());
    }

    /**
     * Test that insert_id() returns a number.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQlite3QueryResult::insert_id
     */
    public function testInsertIDReturnsNumber()
    {
        $this->set_reflection_property_value('insert_id', 0);
        $this->assertSame(0, $this->class->insert_id());
    }

    /**
     * Test that query() returns a string.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQlite3QueryResult::query
     */
    public function testQueryReturnsString()
    {
        $this->set_reflection_property_value('query', '');
        $this->assertSame('', $this->class->query());
    }

    /**
     * Test that the sqlite3 class is passed by reference.
     */
    public function testSQLite3IsPassedByReference()
    {
        $property = $this->get_accessible_reflection_property('sqlite3');

        $value = $property->getValue($this->class);

        $this->assertInstanceOf(\SQLite3::class, $value);
        $this->assertSame($this->sqlite3, $value);
    }

}

?>