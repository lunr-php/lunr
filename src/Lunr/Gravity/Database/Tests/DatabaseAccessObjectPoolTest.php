<?php

/**
 * This file contains the DatabaseAccessObjectPoolTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;
use Lunr\Halo\PropertyTraits\PsrLoggerTestTrait;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Base tests for the case where there is a DatabaseConnectionPool.
 *
 * @covers Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectPoolTest extends DatabaseAccessObjectTest
{

    use PsrLoggerTestTrait;

    /**
     * Testcase Constructor.
     */
    public function setUp(): void
    {
        $this->setUpPool();
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testDatabaseConnectionIsPassed(): void
    {
        $this->assertPropertySame('db', $this->db);
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testQueryEscaperIsStored(): void
    {
        $property = $this->reflection->getProperty('escaper');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $property->getValue($this->class));
    }

    /**
     * Test that DatabaseConnectionPool is passed.
     */
    public function testDatabaseConnectionPoolIsPassed(): void
    {
        $this->assertPropertySame('pool', $this->pool);
    }

}

?>
