<?php

/**
 * This file contains the MySQLConnectionMasterSlaveTest class.
 *
 * PHP Version 5.3
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains basic tests for the MySQLConnection class.
 *
 * @category   MySQL
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionMasterSlaveTest extends MySQLConnectionTest
{

    /**
     * Runkit simulation code for working qos setting.
     * @var string
     */
    const SET_QOS_WORKS = 'return TRUE;';

    /**
     * Test that run_on_master() sets the correct query hint for mysqlnd_ms.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterSetsCorrectQueryHint()
    {
        $this->db->run_on_master();

        $property = $this->db_reflection->getProperty('query_hint');
        $property->setAccessible(TRUE);

        $this->assertEquals('/*' . MYSQLND_MS_MASTER_SWITCH . '*/', $property->getValue($this->db));
    }

    /**
     * Test that run_on_slave() sets the correct query hint for mysqlnd_ms.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHint()
    {
        $this->db->run_on_slave();

        $property = $this->db_reflection->getProperty('query_hint');
        $property->setAccessible(TRUE);

        $this->assertEquals('/*' . MYSQLND_MS_SLAVE_SWITCH . '*/', $property->getValue($this->db));
    }

    /**
     * Test that run_on_last_used() sets the correct query hint for mysqlnd_ms.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_last_used
     */
    public function testRunOnLastUsedSetsCorrectQueryHint()
    {
        $this->db->run_on_last_used();

        $property = $this->db_reflection->getProperty('query_hint');
        $property->setAccessible(TRUE);

        $this->assertEquals('/*' . MYSQLND_MS_LAST_USED_SWITCH . '*/', $property->getValue($this->db));
    }

    /**
     * Test the fluid interface of run_on_master().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterReturnsSelfReference()
    {
        $this->assertSame($this->db, $this->db->run_on_master());
    }

    /**
     * Test the fluid interface of run_on_slave().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveReturnsSelfReference()
    {
        $this->assertSame($this->db, $this->db->run_on_slave());
    }

    /**
     * Test the fluid interface of run_on_last_used().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_last_used
     */
    public function testRunOnLastUsedReturnsSelfReference()
    {
        $this->assertSame($this->db, $this->db->run_on_last_used());
    }

    /**
     * Test that get_qos_policy() returns the currently set QoS Pollicy.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::get_qos_policy
     */
    public function testGetQosPolicyReturnsCurrentlySetPolicy()
    {
        $property = $this->db_reflection->getProperty('qos_policy');
        $property->setAccessible(TRUE);
        $property->setValue($this->db, MYSQLND_MS_QOS_CONSISTENCY_SESSION);

        $this->assertSame(MYSQLND_MS_QOS_CONSISTENCY_SESSION, $this->db->get_qos_policy());
    }

    /**
     * Test that set_qos_policy() returns TRUE on success.
     *
     * @runInSeparateProcess
     *
     * @requires extension mysqlnd_ms
     * @requires extension runkit
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::set_qos_policy
     */
    public function testSetQosPolicyReturnsTrueOnSuccess()
    {
        runkit_function_redefine('mysqlnd_ms_set_qos', '', self::SET_QOS_WORKS);

        $this->assertTrue($this->db->set_qos_policy(MYSQLND_MS_QOS_CONSISTENCY_SESSION));
    }

    /**
     * Test that set_qos_policy() returns FALSE on failure.
     *
     * @requires extension mysqlnd_ms
     * @requires extension mysqli
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::set_qos_policy
     */
    public function testSetQosPolicyReturnsFalseOnFailure()
    {
        $mysqli = new MockMySQLiSuccessfulConnection($this->getMock('\mysqli'));

        $class = $this->db_reflection->getProperty('mysqli');
        $class->setAccessible(TRUE);
        $class->setValue($this->db, $mysqli);

        $this->assertFalse($this->db->set_qos_policy(100));
    }

}

?>
