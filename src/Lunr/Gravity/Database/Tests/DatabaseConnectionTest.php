<?php

/**
 * This file contains the DatabaseConnectionTest class.
 *
 * PHP Version 5.3
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Gravity\Database\Tests;

use Lunr\Gravity\Database\DatabaseConnection;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the DatabaseConnection class.
 *
 * @category   Database
 * @package    Gravity
 * @subpackage Database
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Gravity\Database\DatabaseConnection
 */
class DatabaseConnectionTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the Configuration class.
     * @var Configuration
     */
    private $configuration;

    /**
     * Mock instance of a Logger class.
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Mock instance of the DatabaseConnection class.
     * @var DatabaseConnection
     */
    private $db;

    /**
     * Reflection instance of the DatabaseConnection class.
     * @var ReflectionClass
     */
    private $db_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->configuration = $this->getMock('Lunr\Core\Configuration');

        $this->logger = $this->getMock('Psr\Log\LoggerInterface');

        $this->db = $this->getMockBuilder('Lunr\Gravity\Database\DatabaseConnection')
                         ->setConstructorArgs(array(&$this->configuration, &$this->logger))
                         ->getMockForAbstractClass();

        $this->db_reflection = new ReflectionClass('Lunr\Gravity\Database\DatabaseConnection');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->configuration);
        unset($this->logger);
        unset($this->db);
        unset($this->db_reflection);
    }

    /**
     * Test that the Configuration class is passed by reference.
     */
    public function testConfigurationIsPassedByReference()
    {
        $property = $this->db_reflection->getProperty('configuration');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->db);

        $this->assertInstanceOf('Lunr\Core\Configuration', $value);
        $this->assertSame($this->configuration, $value);
    }

    /**
     * Test that the Logger class is passed by reference.
     */
    public function testLoggerIsPassedByReference()
    {
        $property = $this->db_reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->db);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that the connected flag is set to FALSE by default.
     */
    public function testConnectedIsFalse()
    {
        $property = $this->db_reflection->getProperty('connected');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->db));
    }

    /**
     * Test that the readonly flag is set to TRUE by default.
     */
    public function testReadonlyIsFalseByDefault()
    {
        $property = $this->db_reflection->getProperty('readonly');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->db));
    }

    /**
     * Test that set_readonly sets the readonly flag when passed TRUE.
     *
     * @depends testReadonlyIsFalseByDefault
     * @covers  Lunr\Gravity\Database\DatabaseConnection::set_readonly
     */
    public function testSetReadonlySetsReadonlyWhenPassedTrue()
    {
        $property = $this->db_reflection->getProperty('readonly');
        $property->setAccessible(TRUE);

        $this->db->set_readonly(TRUE);

        $this->assertTrue($property->getValue($this->db));
    }

    /**
     * Test that set_readonly unsets the readonly flag when passed FALSE.
     *
     * @depends testSetReadonlySetsReadonlyWhenPassedTrue
     * @covers  Lunr\Gravity\Database\DatabaseConnection::set_readonly
     */
    public function testSetReadonlySetsReadwriteWhenPassedFalse()
    {
        $property = $this->db_reflection->getProperty('readonly');
        $property->setAccessible(TRUE);

        $this->db->set_readonly(TRUE);

        $this->assertTrue($property->getValue($this->db));

        $this->db->set_readonly(FALSE);

        $this->assertFalse($property->getValue($this->db));
    }

}

?>
