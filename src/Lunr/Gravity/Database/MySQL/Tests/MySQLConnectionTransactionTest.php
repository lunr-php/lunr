<?php

/**
 * This file contains the MySQLConnectionTransactionTest class.
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;
use ReflectionClass;

/**
 * This class contains transaction related unit tests for MySQLConnection.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionTransactionTest extends MySQLConnectionTest
{

    /**
     * Test a successful call to Begin Transaction.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::begin_transaction
     */
    public function testBeginTransactionStartsTransactionWhenConnected(): void
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('autocommit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->begin_transaction());

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a call to Begin Transaction with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::begin_transaction
     */
    public function testBeginTransactionThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->class->begin_transaction();
    }

    /**
     * Test a successful call to Commit.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testCommitWhenConnected(): void
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('commit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->commit());

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testCommitThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->class->commit();
    }

    /**
     * Test a successful call to rollback.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testRollbackWhenConnected(): void
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('rollback')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->rollback());

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testRollbackThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->class->rollback();
    }

    /**
     * Test a successful call to rollback.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testEndTransactionWhenConnected(): void
    {
        $property = $this->get_accessible_reflection_property('connected');
        $property->setValue($this->class, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('autocommit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->end_transaction());

        $property->setValue($this->class, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testEndTransactionThrowsExceptionWhenNotConnected(): void
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMockBuilder('\mysqli')->getMock());

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->expectException('Lunr\Gravity\Database\Exceptions\ConnectionException');
        $this->expectExceptionMessage('Could not establish connection to the database!');

        $this->class->end_transaction();
    }

}
?>
