<?php

/**
 * This file contains the DatabaseAccessObjectResultsTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Tests for returning result information.
 *
 * @covers Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectResultsTest extends DatabaseAccessObjectTest
{

    /**
     * Testcase constructor.
     */
    public function setUp(): void
    {
        $this->setUpNoPool();
    }

    /**
     * Test that indexed_result_array() throws an exception if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::indexed_result_array
     */
    public function testIndexedResultArrayThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('indexed_result_array');

        $method->invokeArgs($this->class, [ &$query, 'key2' ]);
    }

    /**
     * Test that indexed_result_array() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::indexed_result_array
     */
    public function testIndexedResultArrayReturnsEmptyArrayIfQueryHasNoResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->get_accessible_reflection_method('indexed_result_array');

        $result = $method->invokeArgs($this->class, [ &$query, 'key2' ]);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Test that indexed_result_array() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::indexed_result_array
     */
    public function testIndexedResultArrayReturnsArrayIfQueryHasResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = [
            [
                'key'  => 'value',
                'key2' => 'index',
            ],
            [
                'key'  => 'value2',
                'key2' => 'index2',
            ],
        ];

        $query->expects($this->once())
              ->method('result_array')
              ->will($this->returnValue($query_result));

        $method = $this->get_accessible_reflection_method('indexed_result_array');

        $result = $method->invokeArgs($this->class, [ &$query, 'key2' ]);

        $indexed_result = [
            'index'  => [
                'key'  => 'value',
                'key2' => 'index',
            ],
            'index2' => [
                'key'  => 'value2',
                'key2' => 'index2',
            ],
        ];

        $this->assertIsArray($result);
        $this->assertEquals($indexed_result, $result);
    }

    /**
     * Test that result_array() throws an exception if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('result_array');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that result_array() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayReturnsEmptyArrayIfQueryHasNoResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->get_accessible_reflection_method('result_array');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_array() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_array
     */
    public function testResultArrayReturnsArrayIfQueryHasResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = [ 0 => [ 'key' => 'value' ] ];

        $query->expects($this->once())
              ->method('result_array')
              ->will($this->returnValue($query_result));

        $method = $this->get_accessible_reflection_method('result_array');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertIsArray($result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_row() throws an exception if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('result_row');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that result_row() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowReturnsEmptyArrayIfQueryHasNoResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->get_accessible_reflection_method('result_row');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_row() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_row
     */
    public function testResultRowReturnsArrayIfQueryHasResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = [ 'key' => 'value' ];

        $query->expects($this->once())
              ->method('result_row')
              ->will($this->returnValue($query_result));

        $method = $this->get_accessible_reflection_method('result_row');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertIsArray($result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_column() throws an exception if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('result_column');

        $method->invokeArgs($this->class, [ &$query, 'col' ]);
    }

    /**
     * Test that result_column() returns an empty array if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnReturnsEmptyArrayIfQueryHasNoResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->get_accessible_reflection_method('result_column');

        $result = $method->invokeArgs($this->class, [ &$query, 'col' ]);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    /**
     * Test that result_column() returns an array of values if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_column
     */
    public function testResultColumnReturnsArrayIfQueryHasResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = [ 0 => 'value' ];

        $query->expects($this->once())
              ->method('result_column')
              ->will($this->returnValue($query_result));

        $method = $this->get_accessible_reflection_method('result_column');

        $result = $method->invokeArgs($this->class, [ &$query, 'col' ]);

        $this->assertIsArray($result);
        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_cell() throws an exception if query failed.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('result_cell');

        $method->invokeArgs($this->class, [ &$query, 'col' ]);
    }

    /**
     * Test that result_cell() returns an empty string if query has no results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellReturnsEmptyStringIfQueryHasNoResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(0));

        $method = $this->get_accessible_reflection_method('result_cell');

        $result = $method->invokeArgs($this->class, [ &$query, 'col' ]);

        $this->assertEquals('', $result);
    }

    /**
     * Test that result_cell() returns a value if query has results.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_cell
     */
    public function testResultCellReturnsValueIfQueryHasResults(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('number_of_rows')
              ->will($this->returnValue(1));

        $query_result = 'value';

        $query->expects($this->once())
              ->method('result_cell')
              ->will($this->returnValue($query_result));

        $method = $this->get_accessible_reflection_method('result_cell');

        $result = $method->invokeArgs($this->class, [ &$query, 'col' ]);

        $this->assertEquals($query_result, $result);
    }

    /**
     * Test that result_retry() returns the same result query if there is no deadlock.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReturnsQueryInNoDeadlock(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_deadlock')
              ->willReturn(FALSE);

        $query->expects($this->once())
              ->method('has_lock_timeout')
              ->willReturn(FALSE);

        $method = $this->get_accessible_reflection_method('result_retry');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_retry() re-executes the query if there is a deadlock.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReExecutesQueryInDeadlock(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_deadlock')
              ->willReturn(TRUE);

        $query->expects($this->once())
              ->method('query')
              ->willReturn('sql_query');

        $this->db->expects($this->once())
                 ->method('query')
                 ->with('sql_query')
                 ->willReturn($query);

        $method = $this->get_accessible_reflection_method('result_retry');

        $result = $method->invokeArgs($this->class, [ &$query, 1 ]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_retry() re-executes the query if there is a lock wait timeout.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReExecutesQueryInLockTimeout(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_deadlock')
              ->willReturn(FALSE);

        $query->expects($this->once())
              ->method('has_lock_timeout')
              ->willReturn(TRUE);

        $query->expects($this->once())
              ->method('query')
              ->willReturn('sql_query');

        $this->db->expects($this->once())
                 ->method('query')
                 ->with('sql_query')
                 ->willReturn($query);

        $method = $this->get_accessible_reflection_method('result_retry');

        $result = $method->invokeArgs($this->class, [ &$query, 1 ]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_retry() re-executes the query if there is a deadlock more than once.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_retry
     */
    public function testResultRetryReExecutesQueryInDeadlockMoreThanOnce(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->exactly(2))
              ->method('has_deadlock')
              ->willReturnOnConsecutiveCalls(TRUE, FALSE);

        $query->expects($this->once())
              ->method('has_lock_timeout')
              ->willReturnOnConsecutiveCalls(FALSE);

        $query->expects($this->once())
              ->method('query')
              ->willReturn('sql_query');

        $this->db->expects($this->once())
                 ->method('query')
                 ->with('sql_query')
                 ->willReturn($query);

        $method = $this->get_accessible_reflection_method('result_retry');

        $result = $method->invokeArgs($this->class, [ &$query, 2 ]);

        $this->assertSame($result, $query);
    }

    /**
     * Test that result_boolean() throws an exception on a failure.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_boolean
     */
    public function testResultHasFailedTrueIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('has_failed')
            ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
            ->method('error_message')
            ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
            ->method('query')
            ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
            ->method('error')
            ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('result_boolean');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that result_retry() returns TRUE on succesfull execution.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::result_boolean
     */
    public function testResultHasFailedFalseIfQuerySuccesfull(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
            ->disableOriginalConstructor()
            ->getMock();

        $query->expects($this->once())
            ->method('has_failed')
            ->will($this->returnValue(FALSE));

        $method = $this->get_accessible_reflection_method('result_boolean');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertTrue($result);
    }

    /**
     * Test that get_affected_rows() throws an exception on a failure.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::get_affected_rows
     */
    public function testGetAffectedRowsThrowsExceptionIfQueryFailed(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(TRUE));

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
             ->method('error')
             ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\QueryException');
        $this->expectExceptionMessage('Database query error!');

        $method = $this->get_accessible_reflection_method('get_affected_rows');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that get_affected_rows() returns affected rows on succesfull execution.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::get_affected_rows
     */
    public function testGetAffectedRowsReturnsAffectedRowsOnSuccess(): void
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->will($this->returnValue(FALSE));

        $query->expects($this->once())
              ->method('affected_rows')
              ->will($this->returnValue(100));

        $method = $this->get_accessible_reflection_method('get_affected_rows');

        $result = $method->invokeArgs($this->class, [ &$query ]);

        $this->assertSame(100, $result);
    }

}

?>
