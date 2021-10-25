<?php

/**
 * This file contains the TransactionalDatabaseAccessObjectCallsTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Tests for using transactional classes.
 *
 * @covers \Lunr\Gravity\Database\DatabaseAccessObject
 */
class TransactionalDatabaseAccessObjectCallsTest extends LunrBaseTest
{

    /**
     * Mock instance of a DatabaseConnection
     * @var \Lunr\Gravity\Database\DatabaseConnection
     */
    protected $db;

    /**
     * Mock instance of the Logger class.
     * @var \Psr\Log\LoggerInterface
     */
    protected $logger;

    /**
     * Testcase constructor.
     */
    public function setUp(): void
    {
        $this->logger = $this->getMockBuilder('Psr\Log\LoggerInterface')->getMock();

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\MySQL\MySQLConnection')
                         ->disableOriginalConstructor()
                         ->getMock();

        $this->class = $this->getMockBuilder('Lunr\Gravity\Database\TransactionalDatabaseAccessObject')
                            ->setConstructorArgs([ $this->db, $this->logger ])
                            ->getMockForAbstractClass();

        $this->reflection = new ReflectionClass('Lunr\Gravity\Database\TransactionalDatabaseAccessObject');
    }

    /**
     * Testcase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->db);
        unset($this->logger);
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that begin_transaction() is called on the DB when the method is called.
     *
     * @covers \Lunr\Gravity\Database\TransactionalDatabaseAccessObject::begin_transaction
     */
    public function testBeginTransactionIsCalled(): void
    {
        $this->db->expects($this->once())
                 ->method('begin_transaction');

        $this->class->begin_transaction();
    }

    /**
     * Test that rollback_transaction() is called on the DB when the method is called.
     *
     * @covers \Lunr\Gravity\Database\TransactionalDatabaseAccessObject::rollback_transaction
     */
    public function testRollbackTransactionIsCalled(): void
    {
        $this->db->expects($this->once())
                 ->method('rollback');

        $this->class->rollback_transaction();
    }

    /**
     * Test that commit_transaction() is called on the DB when the method is called.
     *
     * @covers \Lunr\Gravity\Database\TransactionalDatabaseAccessObject::commit_transaction
     */
    public function testCommitTransactionIsCalled(): void
    {
        $this->db->expects($this->once())
                 ->method('commit');

        $this->class->commit_transaction();
    }

    /**
     * Test that end_transaction() is called on the DB when the method is called.
     *
     * @covers \Lunr\Gravity\Database\TransactionalDatabaseAccessObject::end_transaction
     */
    public function testEndTransactionIsCalled(): void
    {
        $this->db->expects($this->once())
                 ->method('end_transaction');

        $this->class->end_transaction();
    }

}

?>
