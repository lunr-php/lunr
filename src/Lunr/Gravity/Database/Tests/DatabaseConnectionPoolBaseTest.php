<?php

/**
 * This file contains the DatabaseConnectionPoolBaseTest class.
 *
 * @package    Lunr\Gravity\Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnectionPool;

/**
 * This class contains basic tests for the DatabaseConnectionPool class.
 *
 * @covers Lunr\Gravity\Database\DatabaseConnectionPool
 */
class DatabaseConnectionPoolBaseTest extends DatabaseConnectionPoolTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->emptySetup();
    }

    /**
     * Test that the Configuration class was passed correctly.
     */
    public function testConfigurationPassedByReference(): void
    {
        $property = $this->pool_reflection->getProperty('configuration');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertInstanceOf('Lunr\Core\Configuration', $value);
        $this->assertSame($this->configuration, $value);
    }

    /**
     * Test that the Logger class was passed correctly.
     */
    public function testLoggerPassedByReference(): void
    {
        $property = $this->pool_reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that the ro_pool was setup corectly.
     */
    public function testReadonlyPoolSetupCorrectly(): void
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the rw_pool was setup corectly.
     */
    public function testReadWritePoolSetupCorrectly(): void
    {
        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertIsArray($value);
        $this->assertEmpty($value);
    }

}

?>
