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
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
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
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::begin_transaction
     */
    public function testBeginTransactionStartsTransactionWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('autocommit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->db->begin_transaction());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test a call to Begin Transaction with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::begin_transaction
     */
    public function testBeginTransactionDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->begin_transaction());
    }

    /**
     * Test a successful call to Commit.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testCommitWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('commit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->db->commit());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testCommitDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->commit());
    }

    /**
     * Test a successful call to rollback.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testRollbackWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('rollback')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->db->rollback());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testRollbackDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->rollback());
    }

    /**
     * Test a successful call to rollback.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::rollback
     */
    public function testEndTransactionWhenConnected()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, TRUE);

        $this->mysqli->expects($this->once())
                     ->method('autocommit')
                     ->will($this->returnValue(TRUE));

        $this->assertTrue($this->db->end_transaction());

        $property->setValue($this->db, FALSE);
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::commit
     */
    public function testEndTransactionDoesNothingWhenNotConnected()
    {
        $mysqli = new MockMySQLiFailedConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->end_transaction());
    }

}
?>
