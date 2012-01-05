<?php

/**
 * This file contains the ConfigurationBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;

/**
 * Basic tests for the Configuration class, with
 * empty initialization.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Configuration
 */
class ConfigurationBaseTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray(array());
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

    /**
     * Test the function __toString().
     *
     * @covers Lunr\Libraries\Core\Configuration::__toString
     */
    public function testToString()
    {
        ob_start();
        echo $this->configuration;
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertEquals('Array', $output);
    }

    /**
     * Test conversion to array when $config is empty.
     *
     * @depends testConfigIsEmpty
     * @covers  Lunr\Libraries\Core\Configuration::toArray
     */
    public function testToArrayIsEmpty()
    {
        $this->assertEquals(array(), $this->configuration->toArray());
    }

    /**
     * Test current() returns False if $config is empty.
     *
     * @depends testConfigIsEmpty
     * @covers  Lunr\libraries\Core\Configuration::current
     */
    public function testCurrentIsFalseWithEmptyArray()
    {
        $this->assertFalse($this->configuration->current());
    }

    /**
     * Test key() returns NULL if $config is empty.
     *
     * @depends testConfigIsEmpty
     * @covers  Lunr\Libraries\Core\Configuration::key
     */
    public function testKeyIsNullWithEmptyArray()
    {
        $this->assertNull($this->configuration->key());
    }

    /**
     * Test valid() returns False if $config is empty.
     *
     * @depends testConfigIsEmpty
     * @depends testCurrentIsFalseWithEmptyArray
     * @covers  Lunr\Libraries\Core\Configuration::key
     */
    public function testValidIsFalseWithEmptyArray()
    {
        $this->assertFalse($this->configuration->valid());
    }

    /**
     * Test that next() increases the internal position pointer.
     *
     * @depends testPositionIsZero
     * @covers  Lunr\Libraries\Core\Configuration::next
     */
    public function testNextIncreasesPosition()
    {
        $property = $this->configuration_reflection->getProperty('position');
        $property->setAccessible(TRUE);
        $this->configuration->next();
        $this->assertEquals(1, $property->getValue($this->configuration));
    }

    /**
     * Test that count() returns zero.
     *
     * @depends testConfigIsEmpty
     * @covers  Lunr\Libraries\Core\Configuration::count
     */
    public function testCountIsZero()
    {
        $this->assertEquals(0, $this->configuration->count());
        $this->assertEquals(0, count($this->configuration));
    }

}

?>
