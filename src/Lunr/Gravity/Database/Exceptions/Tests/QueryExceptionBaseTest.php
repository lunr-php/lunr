<?php

/**
 * This file contains the QueryExceptionBaseTest class.
 *
 * @package Lunr\Gravity\Database\Exceptions
 * @author  Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Gravity\Database\Exceptions\Tests;

/**
 * This class contains tests for the QueryException class.
 *
 * @covers Lunr\Gravity\Database\Exceptions\QueryException
 */
class QueryExceptionBaseTest extends QueryExceptionTest
{

    /**
     * Test that the SQL query was set correctly.
     */
    public function testSQLQuerySetCorrectly()
    {
        $this->assertPropertySame('query', 'SQL query');
    }

    /**
     * Test that the database error code was set correctly.
     */
    public function testDatabaseErrorCodeSetCorrectly()
    {
        $this->assertPropertySame('database_error_code', 1024);
    }

    /**
     * Test that the database error message was set correctly.
     */
    public function testDatabaseErrorMessageSetCorrectly()
    {
        $this->assertPropertySame('database_error_message', "There's an error in your query.");
    }

    /**
     * Test that getQuery() returns the SQL query.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getQuery
     */
    public function testGetQueryReturnsQuery()
    {
        $this->assertSame('SQL query', $this->class->getQuery());
    }

    /**
     * Test that getDatabaseErrorCode() returns the database error code.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getDatabaseErrorCode
     */
    public function testGetDatabaseErrorCodeReturnsErrorCode()
    {
        $this->assertSame(1024, $this->class->getDatabaseErrorCode());
    }

    /**
     * Test that getDatabaseErrorMessage() returns the database error message.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getDatabaseErrorMessage
     */
    public function testGetDatabaseErrorMessageReturnsErrorMessage()
    {
        $this->assertSame("There's an error in your query.", $this->class->getDatabaseErrorMessage());
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly()
    {
        $this->expectExceptionMessage('Exception Message');

        throw $this->class;
    }

}

?>
