<?php

/**
 * This file contains the MySQLConnectionMasterSlaveTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testRunOnMasterSetsCorrectQueryHint(): void
    {
        $this->class->run_on_master();

        $this->assertPropertyEquals('query_hint', '/* maxscale route to master */');
    }

    /**
     * Test that run_on_slave() sets the correct default query hint.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHint(): void
    {
        $this->class->run_on_slave();

        $this->assertPropertyEquals('query_hint', '/* maxscale route to slave */');
    }

    /**
     * Test that run_on_master() sets the correct query hint for maxscale.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterSetsCorrectQueryHintForMaxscale(): void
    {
        $this->class->run_on_master('maxscale');

        $this->assertPropertyEquals('query_hint', '/* maxscale route to master */');
    }

    /**
     * Test that run_on_slave() sets the correct query hint for maxscale.
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveSetsCorrectQueryHintForMaxscale(): void
    {
        $this->class->run_on_slave('maxscale');

        $this->assertPropertyEquals('query_hint', '/* maxscale route to slave */');
    }

    /**
     * Test the fluid interface of run_on_master().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_master
     */
    public function testRunOnMasterReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->run_on_master());
    }

    /**
     * Test the fluid interface of run_on_slave().
     *
     * @covers Lunr\Gravity\Database\MySQL\MySQLConnection::run_on_slave
     */
    public function testRunOnSlaveReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->run_on_slave());
    }

}

?>
