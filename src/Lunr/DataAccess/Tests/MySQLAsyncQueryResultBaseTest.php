<?php

/**
 * This file contains the MySQLAsyncQueryResultBaseTest class.
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

use Lunr\DataAccess\MySQLAsyncQueryResult;
use MySQLi_Result;

/**
 * This class contains basic tests for the MySQLAsyncQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\MySQLAsyncQueryResult
 */
class MySQLAsyncQueryResultBaseTest extends MySQLAsyncQueryResultTest
{

    /**
     * Test that error message is empty on successful query.
     */
    public function testErrorMessageIsEmpty()
    {
        $property = $this->result_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->result));
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testErrorNumberIsZero()
    {
        $property = $this->result_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->result));
    }

    /**
     * Test that error number is zero on successful query.
     */
    public function testInsertIDIsZero()
    {
        $property = $this->result_reflection->getProperty('insert_id');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->result));
    }

    /**
     * Test that affected rows is a number on successful query.
     */
    public function testAffectedRowsIsNumber()
    {
        $property = $this->result_reflection->getProperty('affected_rows');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->result));
    }

    /**
     * Test that number of rows is a number on successful query.
     */
    public function testNumberOfRowsIsNumber()
    {
        $property = $this->result_reflection->getProperty('num_rows');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->result));
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
     * Test that the mysqli class is passed by reference.
     */
    public function testMysqliIsPassedByReference()
    {
        $property = $this->result_reflection->getProperty('mysqli');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->result);

        $this->assertInstanceOf('Lunr\DataAccess\Tests\MockMySQLiSuccessfulConnection', $value);
        $this->assertSame($this->mysqli, $value);
    }

    /**
     * Test that the fetched flag is FALSE by default.
     */
    public function testFetchedIsFalseByDefault()
    {
        $property = $this->result_reflection->getProperty('fetched');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->result));
    }

    /**
     * Test that fethc_result() does not try to refetch the result if it was already fetched.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultDoesNotRefetchIfFetchedIsTrue()
    {
        $property = $this->result_reflection->getProperty('fetched');
        $property->setAccessible(TRUE);
        $property->setValue($this->result, TRUE);

        $this->mysqli->expects($this->never())
                     ->method('reap_async_query');

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that fetch_result() stores the result correctly.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultStoresResult()
    {
        $result = new MockMySQLiResult($this->getMockBuilder('mysqli_result')
                                            ->disableOriginalConstructor()
                                            ->getMock());

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('result');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('Lunr\DataAccess\Tests\MockMySQLiResult', $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the fetched flag to TRUE.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsFetchedToTrue()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('fetched');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the success flag to TRUE if the result value is TRUE.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchedResultSetsSuccessTrueIfResultIsTrue()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(TRUE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the success flag to FALSE if the result value is FALSE.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchedResultSetsSuccessFalseIfResultIsFalse()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the success flag to TRUE if the result is of type MySQLi_Result.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchedResultSetsSuccessTrueIfResultIsMysqliResult()
    {
        $result = new MockMySQLiResult($this->getMockBuilder('mysqli_result')
                                            ->disableOriginalConstructor()
                                            ->getMock());

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('success');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the error message.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsErrorMessage()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('error_message');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the error number.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsErrorNumber()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('error_number');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets insert id.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsInsertID()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('insert_id');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets affected rows.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsAffectedRows()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('affected_rows');
        $property->setAccessible(TRUE);

        $this->assertEquals(10, $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets number of rows.
     *
     * @covers Lunr\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultSetsNumberOfRows()
    {
        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue(FALSE));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('num_rows');
        $property->setAccessible(TRUE);

        $this->assertEquals(10, $property->getValue($this->result));
    }

}

?>
