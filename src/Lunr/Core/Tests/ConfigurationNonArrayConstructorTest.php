<?php

/**
 * This file contains the ConfigurationNonArrayConstructorTest
 * class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Configuration;

/**
 * Basic tests for the Configuration class,
 * when initialized with a non-array value.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Configuration
 */
class ConfigurationNonArrayConstructorTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpNonArray();
    }

    /**
     * Test that the internal config storage is initially empty.
     */
    public function testConfigIsEmpty()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);
        $this->assertEmpty($property->getValue($this->configuration));
    }

    /**
     * Test that the internal position pointer is initially zero.
     */
    public function testPositionIsZero()
    {
        $property = $this->configuration_reflection->getProperty('position');
        $property->setAccessible(TRUE);
        $this->assertEquals(0, $property->getValue($this->configuration));
    }

    /**
     * Test that the initial size value is cached.
     */
    public function testSizeInvalidIsFalse()
    {
        $property = $this->configuration_reflection->getProperty('size_invalid');
        $property->setAccessible(TRUE);
        $this->assertFalse($property->getValue($this->configuration));
    }

    /**
     * Test that the initial size value is zero.
     */
    public function testSizeIsZero()
    {
        $property = $this->configuration_reflection->getProperty('size');
        $property->setAccessible(TRUE);
        $this->assertEquals(0, $property->getValue($this->configuration));
    }

}

?>
