<?php

/**
 * This file contains the DatabaseAccessObjectPoolTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
    public function setUp()
    {
        $this->setUpPool();
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testDatabaseConnectionIsPassed()
    {
        $this->assertPropertySame('db', $this->db);
    }

    /**
     * Test that DatabaseConnection class is passed.
     */
    public function testQueryEscaperIsStored()
    {
        $property = $this->reflection->getProperty('escaper');
        $property->setAccessible(TRUE);

        $this->assertInstanceOf('Lunr\Gravity\Database\DatabaseQueryEscaper', $property->getValue($this->class));
    }

    /**
     * Test that DatabaseConnectionPool is passed.
     */
    public function testDatabaseConnectionPoolIsPassed()
    {
        $this->assertPropertySame('pool', $this->pool);
    }

}

?>
