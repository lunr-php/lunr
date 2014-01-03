<?php

/**
 * This file contains the SQLite3ConnectionTransactionTest class.
 *
 * PHP Version 5.4
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\SQLite3\Tests;

use Lunr\Gravity\Database\SQLite3\SQLite3Connection;
use ReflectionClass;

/**
 * This class contains transaction related unit tests for SQLite3Connection.
 *
 * @category   SQLite
 * @package    Gravity
 * @subpackage Database
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\SQLite3\SQLite3Connection
 */
class SQLite3ConnectionTransactionTest extends SQLite3ConnectionTest
{

    /**
     * Test a successful call to Begin Transaction.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::begin_transaction
     */
    public function testBeginTransactionStartsTransactionWhenConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('exec')
                      ->with($this->equalTo('BEGIN TRANSACTION'))
                      ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->begin_transaction());
    }

    /**
     * Test a call to Begin Transaction with no connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::begin_transaction
     */
    public function testBeginTransactionDoesNothingWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', FALSE);

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $this->sqlite3->expects($this->never())
                      ->method('exec');

        $this->assertFalse($this->class->begin_transaction());
    }

    /**
     * Test a successful call to Commit.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::commit
     */
    public function testCommitWhenConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('exec')
                      ->with($this->equalTo('COMMIT TRANSACTION'))
                      ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->commit());
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::commit
     */
    public function testCommitDoesNothingWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', FALSE);

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $this->sqlite3->expects($this->never())
                      ->method('exec');

        $this->assertFalse($this->class->commit());
    }

    /**
     * Test a successful call to rollback.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::rollback
     */
    public function testRollbackWhenConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('exec')
                      ->with($this->equalTo('ROLLBACK TRANSACTION'))
                      ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->rollback());
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::commit
     */
    public function testRollbackDoesNothingWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', FALSE);

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $this->sqlite3->expects($this->never())
                      ->method('exec');

        $this->assertFalse($this->class->rollback());
    }

    /**
     * Test a successful call to rollback.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::end_transaction
     */
    public function testEndTransactionWhenConnected()
    {
        $this->set_reflection_property_value('connected', TRUE);

        $this->sqlite3->expects($this->once())
                      ->method('exec')
                      ->with($this->equalTo('END TRANSACTION'))
                      ->will($this->returnValue(TRUE));

        $this->assertTrue($this->class->end_transaction());
    }

    /**
     * Test a call to Commit with no connection.
     *
     * @covers Lunr\Gravity\Database\SQLite3\SQLite3Connection::end_transaction
     */
    public function testEndTransactionDoesNothingWhenNotConnected()
    {
        $this->set_reflection_property_value('connected', FALSE);

        $this->sqlite3->expects($this->once())
                      ->method('lastErrorCode')
                      ->will($this->returnValue(1));

        $this->sqlite3->expects($this->never())
                      ->method('exec');

        $this->assertFalse($this->class->end_transaction());
    }

}
?>
