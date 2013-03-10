<?php

/**
 * This file contains the DatabaseAccessObjectPoolTest class.
 *
 * PHP Version 5.4
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseAccessObject;

/**
 * This class contains the tests for the DatabaseAccessObject class.
 *
 * Base tests for the case where there is a DatabaseConnectionPool.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseAccessObject
 */
class DatabaseAccessObjectPoolTest extends DatabaseAccessObjectTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        $this->setUpPool();
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testDatabaseConnectionIsPassed()
    {
        $property = $this->reflection_dao->getProperty('db');
        $property->setAccessible(TRUE);

        $this->assertSame($this->db, $property->getValue($this->dao));
    }

    /**
     * Test that Logger class is passed.
     */
    public function testLoggerIsPassed()
    {
        $property = $this->reflection_dao->getProperty('logger');
        $property->setAccessible(TRUE);

        $this->assertSame($this->logger, $property->getValue($this->dao));
    }

    /**
     * Test that DatabaseConnectionPool is passed.
     */
    public function testDatabaseConnectionPoolIsPassed()
    {
        $property = $this->reflection_dao->getProperty('pool');
        $property->setAccessible(TRUE);

        $this->assertSame($this->pool, $property->getValue($this->dao));
    }

}

?>
