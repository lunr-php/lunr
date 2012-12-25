<?php

/**
 * This file contains the DatabaseConnectionPoolBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\DataAccess\Tests;

use Lunr\DataAccess\DatabaseConnectionPool;

/**
 * This class contains basic tests for the DatabaseConnectionPool class.
 *
 * @category   Libraries
 * @package    DataAccess
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\DataAccess\DatabaseConnectionPool
 */
class DatabaseConnectionPoolBaseTest extends DatabaseConnectionPoolTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->emptySetup();
    }

    /**
     * Test that the Configuration class was passed correctly.
     */
    public function testConfigurationPassedByReference()
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
    public function testLoggerPassedByReference()
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
    public function testReadonlyPoolSetupCorrectly()
    {
        $property = $this->pool_reflection->getProperty('ro_pool');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the rw_pool was setup corectly.
     */
    public function testReadWritePoolSetupCorrectly()
    {
        $property = $this->pool_reflection->getProperty('rw_pool');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->pool);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

}

?>
