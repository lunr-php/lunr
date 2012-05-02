<?php

/**
 * This file contains the MySQLAsyncQueryResultBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\DataAccess;
use MySQLi_Result;

/**
 * This class contains basic tests for the MySQLAsyncQueryResult class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\DataAccess\MySQLAsyncQueryResult
 */
class MySQLAsyncQueryResultBaseTest extends MySQLAsyncQueryResultTest
{

    /**
     * Test that the mysqli class is passed by reference.
     */
    public function testMysqliIsPassedByReference()
    {
        $property = $this->result_reflection->getProperty('mysqli');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->result);

        $this->assertInstanceOf('\mysqli', $value);
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
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
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
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchResultStoresResult()
    {
        $result = $this->getMockBuilder('mysqli_result')
                       ->disableOriginalConstructor()
                       ->getMock();

        $this->mysqli->expects($this->once())
                     ->method('reap_async_query')
                     ->will($this->returnValue($result));

        $method = $this->result_reflection->getMethod('fetch_result');
        $method->setAccessible(TRUE);

        $method->invoke($this->result);

        $property = $this->result_reflection->getProperty('result');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('mysqli_result', $property->getValue($this->result));
    }

    /**
     * Test that fetch_result() sets the fetched flag to TRUE.
     *
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
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
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
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
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
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
     * @covers Lunr\Libraries\DataAccess\MySQLAsyncQueryResult::fetch_result
     */
    public function testFetchedResultSetsSuccessTrueIfResultIsMysqliResult()
    {
        $result = $this->getMockBuilder('MySQLi_Result')
                       ->disableOriginalConstructor()
                       ->getMock();

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

}

?>
