<?php

/**
 * This file contains the ConfigurationArrayConstructorTest class.
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
 * This tests the Configuration class when providing an
 * non-empty array as input to the constructor.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @depends    Lunr\Core\Tests\ConfigurationConvertArrayToClassTest::testConvertArrayToClassWithMultidimensionalArrayValue
 * @covers     Lunr\Core\Configuration
 */
class ConfigurationArrayConstructorTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray($this->construct_test_array());
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
     * Test that initial size of the initialized class is two.
     */
    public function testSizeIsTwo()
    {
        $property = $this->configuration_reflection->getProperty('size');
        $property->setAccessible(TRUE);
        $this->assertEquals(2, $property->getValue($this->configuration));
    }

    /**
     * Test that $config is set up according to the input.
     */
    public function testConfig()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);
        $output = $property->getValue($this->configuration);

        $this->assertEquals($this->config['test1'], $output['test1']);
        $this->assertInstanceOf('Lunr\Core\Configuration', $output['test2']);
    }

    /**
     * Test conversion to array when $config is not empty.
     *
     * @covers Lunr\Core\Configuration::toArray
     */
    public function testToArrayEqualsInput()
    {
        $this->assertEquals($this->config, $this->configuration->toArray());
    }

    /**
     * Test Cloning the Configuration class.
     */
    public function testCloneClass()
    {
        $config = clone $this->configuration;

        $this->assertEquals($config, $this->configuration);
        $this->assertNotSame($config, $this->configuration);
    }

    /**
     * Test that current() initially points to the first element.
     *
     * @depends testConfig
     * @covers  Lunr\Core\Configuration::current
     */
    public function testCurrentIsFirstElement()
    {
        $this->assertEquals($this->config['test1'], $this->configuration->current());
    }

    /**
     * Test that key() initially points to the first element.
     *
     * @depends testConfig
     * @covers  Lunr\Core\Configuration::key
     */
    public function testKeyIsFirstElement()
    {
        $this->assertEquals('test1', $this->configuration->key());
    }

    /**
     * Test that current() does not advance the internal position pointer.
     *
     * @depends testConfig
     * @depends testPositionIsZero
     * @covers  Lunr\Core\Configuration::current
     */
    public function testCurrentDoesNotAdvancePointer()
    {
        $this->assertEquals($this->config['test1'], $this->configuration->current());
        $this->assertEquals($this->config['test1'], $this->configuration->current());

        $property = $this->configuration_reflection->getProperty('position');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->configuration));
    }

    /**
     * Test that key() does not advance the internal position pointer.
     *
     * @depends testConfig
     * @depends testPositionIsZero
     * @covers  Lunr\Core\Configuration::key
     */
    public function testKeyDoesNotAdvancePointer()
    {
        $this->assertEquals('test1', $this->configuration->key());
        $this->assertEquals('test1', $this->configuration->key());

        $property = $this->configuration_reflection->getProperty('position');
        $property->setAccessible(TRUE);

        $this->assertEquals(0, $property->getValue($this->configuration));
    }

    /**
     * Test that next() does advance the internal position pointer by one.
     *
     * @depends testConfig
     * @depends testPositionIsZero
     * @depends Lunr\Core\Tests\ConfigurationBaseTest::testNextIncreasesPosition
     * @covers  Lunr\Core\Configuration::next
     */
    public function testNextAdvancesPointer()
    {
        $this->configuration->next();

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);
        $config = $property->getValue($this->configuration);

        $this->assertEquals($config['test2'], $this->configuration->current());
    }

    /**
     * Test that key() points to the second element after one call to next().
     *
     * @depends testConfig
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::key
     */
    public function testKeyIsSecondElementAfterNext()
    {
        $this->configuration->next();
        $this->assertEquals('test2', $this->configuration->key());
    }

    /**
     * Test that valid() returns TRUE when the element exists.
     *
     * @depends testConfig
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::valid
     */
    public function testValidIsTrueForExistingElement()
    {
        $this->assertTrue($this->configuration->valid());
    }

    /**
     * Test that valid() returns TRUE when the element exists, and its value is FALSE.
     *
     * @depends testConfig
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::valid
     */
    public function testValidIsTrueWhenElementValueIsFalse()
    {
        $this->configuration->next();
        $this->configuration->current()->next();

        $this->assertFalse($this->configuration->current()->current());
        $this->assertNotNull($this->configuration->current()->key());

        $this->assertTrue($this->configuration->current()->valid());
    }

    /**
     * Test that valid() returns FALSE when the element doesn't' exist.
     *
     * @depends testConfig
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::valid
     */
    public function testValidIsFalseOnNonExistingElement()
    {
        $this->configuration->next();
        $this->configuration->next();

        $this->assertFalse($this->configuration->valid());
    }

    /**
     * Test that rewind() rewinds the position counter to zero.
     *
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::rewind
     */
    public function testRewindRewindsPosition()
    {
        $this->configuration->next();

        $property = $this->configuration_reflection->getProperty('position');
        $property->setAccessible(TRUE);

        $this->assertEquals(1, $property->getValue($this->configuration));

        $this->configuration->rewind();

        $this->assertEquals(0, $property->getValue($this->configuration));
    }

    /**
     * Test that rewind() rewinds the position counter to zero.
     *
     * @depends testNextAdvancesPointer
     * @covers  Lunr\Core\Configuration::rewind
     */
    public function testRewindRewindsPointer()
    {
        $this->configuration->next();

        $this->configuration->rewind();

        $this->assertEquals($this->config['test1'], $this->configuration->current());
    }

}

?>
