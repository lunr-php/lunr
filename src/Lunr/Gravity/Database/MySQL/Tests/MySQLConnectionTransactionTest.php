<?php

/**
 * This file contains the MySQLConnectionTransactionTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

use Lunr\Gravity\Database\MySQL\MySQLConnection;
use ReflectionClass;

/**
 * This class contains transaction related unit tests for MySQLConnection.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Felipe Martinez <felipe@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionTransactionTest extends MySQLConnectionTest
{

    /**
     * Test a successful call to Begin Transaction.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::begin_transaction
     */
    public function testBeginTransactionStartsTransactionWhenConnected()
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
    public function testBeginTransactionDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->begin_transaction());
    }

    /**
     * Test a successful call to Commit.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testCommitWhenConnected()
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
    public function testCommitDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->commit());
    }

    /**
     * Test a successful call to rollback.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testRollbackWhenConnected()
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
    public function testRollbackDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->rollback());
    }

    /**
     * Test a successful call to rollback.
     *
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testEndTransactionWhenConnected()
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
    public function testEndTransactionDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->end_transaction());
    }

}
?>
