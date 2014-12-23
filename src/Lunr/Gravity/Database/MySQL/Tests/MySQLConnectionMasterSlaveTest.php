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
        $this->class->run_on_master();

        $this->assertPropertyEquals('query_hint', '/*' . MYSQLND_MS_MASTER_SWITCH . '*/');
    }

    /**
     * Test that run_on_slave() sets the correct query hint for mysqlnd_ms.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHint()
    {
        $this->class->run_on_slave();

        $this->assertPropertyEquals('query_hint', '/*' . MYSQLND_MS_SLAVE_SWITCH . '*/');
    }

    /**
     * Test that run_on_last_used() sets the correct query hint for mysqlnd_ms.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_last_used
     */
    public function testRunOnLastUsedSetsCorrectQueryHint()
    {
        $this->class->run_on_last_used();

        $this->assertPropertyEquals('query_hint', '/*' . MYSQLND_MS_LAST_USED_SWITCH . '*/');
    }

    /**
     * Test the fluid interface of run_on_master().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->run_on_master());
    }

    /**
     * Test the fluid interface of run_on_slave().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->run_on_slave());
    }

    /**
     * Test the fluid interface of run_on_last_used().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_last_used
     */
    public function testRunOnLastUsedReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->run_on_last_used());
    }

    /**
     * Test that get_qos_policy() returns the currently set QoS Pollicy.
     *
     * @requires extension mysqlnd_ms
     * @covers   Lunr\Gravity\Database\MySQL\MySQLConnection::get_qos_policy
     */
    public function testGetQosPolicyReturnsCurrentlySetPolicy()
    {
        $this->set_reflection_property_value('qos_policy', MYSQLND_MS_QOS_CONSISTENCY_SESSION);

        $this->assertSame(MYSQLND_MS_QOS_CONSISTENCY_SESSION, $this->class->get_qos_policy());
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
        $this->mock_function('mysqlnd_ms_set_qos', self::SET_QOS_WORKS);

        $this->assertTrue($this->class->set_qos_policy(MYSQLND_MS_QOS_CONSISTENCY_SESSION));

        $this->unmock_function('mysqlnd_ms_set_qos');
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

        $this->set_reflection_property_value('mysqli', $mysqli);

        $this->assertFalse($this->class->set_qos_policy(100));
    }

}

?>
