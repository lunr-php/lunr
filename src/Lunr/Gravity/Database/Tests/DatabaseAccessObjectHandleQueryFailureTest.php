<?php

/**
 * This file contains the DatabaseAccessObjectHandleQueryFailureTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2019, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * @covers Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectHandleQueryFailureTest extends DatabaseAccessObjectTest
{

    /**
     * Testcase constructor.
     */
    public function setUp()
    {
        $this->setUpNoPool();
    }

    /**
     * Test that handle_query_failure() does not throw an exception if the query was successful.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::handle_query_failure
     */
    public function testHandleQueryFailureDoesNotThrowExceptionOnQuerySuccess()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->willReturn(FALSE);

        $query->expects($this->never())
              ->method('has_deadlock');

        $method = $this->get_accessible_reflection_method('handle_query_failure');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that handle_query_failure() throws a QueryException in case of an error.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::handle_query_failure
     */
    public function testHandleQueryFailureThrowsQueryExceptionOnError()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->willReturn(TRUE);

        $query->expects($this->once())
              ->method('has_deadlock')
              ->willReturn(FALSE);

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

        $method = $this->get_accessible_reflection_method('handle_query_failure');

        $method->invokeArgs($this->class, [ &$query ]);
    }

    /**
     * Test that handle_query_failure() throws a DeadlockException in case of a deadlock.
     *
     * @covers Lunr\Gravity\Database\DatabaseAccessObject::handle_query_failure
     */
    public function testHandleQueryFailureThrowsDeadlockExceptionOnDeadlock()
    {
        $query = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLQueryResult')
                      ->disableOriginalConstructor()
                      ->getMock();

        $query->expects($this->once())
              ->method('has_failed')
              ->willReturn(TRUE);

        $query->expects($this->once())
              ->method('has_deadlock')
              ->willReturn(TRUE);

        $query->expects($this->exactly(2))
              ->method('error_message')
              ->will($this->returnValue('message'));

        $query->expects($this->exactly(2))
              ->method('query')
              ->will($this->returnValue('query'));

        $this->logger->expects($this->once())
             ->method('error')
             ->with('{query}; failed with error: {error}', [ 'query' => 'query', 'error' => 'message' ]);

        $this->expectException('Lunr\Gravity\Database\Exceptions\DeadlockException');
        $this->expectExceptionMessage('Database query deadlock!');

        $method = $this->get_accessible_reflection_method('handle_query_failure');

        $method->invokeArgs($this->class, [ &$query ]);
    }

}

?>
