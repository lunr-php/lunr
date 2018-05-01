<?php

/**
 * This file contains the MySQLConnectionMasterSlaveTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Gravity\Database\MySQL
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\MySQL\Tests;

/**
 * This class contains basic tests for the MySQLConnection class.
 *
 * @covers Lunr\Gravity\Database\MySQL\MySQLConnection
 */
class MySQLConnectionMasterSlaveTest extends MySQLConnectionTest
{

    /**
     * Test that run_on_master() sets the correct default query hint.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterSetsCorrectQueryHint()
    {
        $this->class->run_on_master();

        $this->assertPropertyEquals('query_hint', '/* maxscale route to master */');
    }

    /**
     * Test that run_on_slave() sets the correct default query hint.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHint()
    {
        $this->class->run_on_slave();

        $this->assertPropertyEquals('query_hint', '/* maxscale route to slave */');
    }

    /**
     * Test that run_on_master() sets the correct query hint for maxscale.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterSetsCorrectQueryHintForMaxscale()
    {
        $this->class->run_on_master('maxscale');

        $this->assertPropertyEquals('query_hint', '/* maxscale route to master */');
    }

    /**
     * Test that run_on_slave() sets the correct query hint for maxscale.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHintForMaxscale()
    {
        $this->class->run_on_slave('maxscale');

        $this->assertPropertyEquals('query_hint', '/* maxscale route to slave */');
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

}

?>
