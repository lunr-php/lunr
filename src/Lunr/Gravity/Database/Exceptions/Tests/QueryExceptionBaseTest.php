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
    public function testSQLQuerySetCorrectly(): void
    {
        $this->assertPropertySame('query', 'SQL query');
    }

    /**
     * Test that the database error code was set correctly.
     */
    public function testDatabaseErrorCodeSetCorrectly(): void
    {
        $this->assertPropertySame('database_error_code', 1024);
    }

    /**
     * Test that the database error message was set correctly.
     */
    public function testDatabaseErrorMessageSetCorrectly(): void
    {
        $this->assertPropertySame('database_error_message', "There's an error in your query.");
    }

    /**
     * Test that getQuery() returns the SQL query.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getQuery
     */
    public function testGetQueryReturnsQuery(): void
    {
        $this->assertSame('SQL query', $this->class->getQuery());
    }

    /**
     * Test that getDatabaseErrorCode() returns the database error code.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getDatabaseErrorCode
     */
    public function testGetDatabaseErrorCodeReturnsErrorCode(): void
    {
        $this->assertSame(1024, $this->class->getDatabaseErrorCode());
    }

    /**
     * Test that getDatabaseErrorMessage() returns the database error message.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::getDatabaseErrorMessage
     */
    public function testGetDatabaseErrorMessageReturnsErrorMessage(): void
    {
        $this->assertSame("There's an error in your query.", $this->class->getDatabaseErrorMessage());
    }

    /**
     * Test that the error message was passed correctly.
     */
    public function testErrorMessagePassedCorrectly(): void
    {
        $this->expectExceptionMessage('Exception Message');

        throw $this->class;
    }

    /**
     * Test that setMessage() changes the error message.
     *
     * @covers \Lunr\Gravity\Database\Exceptions\QueryException::setMessage
     */
    public function testSetMessage(): void
    {
        $this->class->setMessage('New error message!');

        $this->expectExceptionMessage('New error message!');

        throw $this->class;
    }
}

?>
