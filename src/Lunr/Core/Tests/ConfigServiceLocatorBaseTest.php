<?php

/**
 * This file contains the ConfigServiceLocatorTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the locator class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\ConfigServiceLocator
 */
class ConfigServiceLocatorBaseTest extends ConfigServiceLocatorTest
{

    /**
     * Test that the cache is initialized as empty array.
     */
    public function testCacheIsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('cache'));
    }

    /**
     * Test that the registry is initialized correctly.
     */
    public function testRegistryIsSetupCorrectly()
    {
        $registry = $this->get_reflection_property_value('registry');

        $this->assertInternalType('array', $registry);
        $this->assertCount(2, $registry);
        $this->assertArrayHasKey('config', $registry);
        $this->assertArrayHasKey('locator', $registry);
    }

    /**
     * Test that the Configuration class is passed correctly.
     */
    public function testConfigurationIsPassedCorrectly()
    {
        $this->assertSame($this->configuration, $this->get_reflection_property_value('config'));
    }

    /**
     * Test that override() overwrites an index when ID is already taken.
     *
     * @covers Lunr\Core\ConfigServiceLocator::override
     */
    public function testOverrideWhenIDAlreadyTaken()
    {
        $registry = [ 'id' => 'Foo' ];
        $class    = new \stdClass();

        $this->set_reflection_property_value('registry', $registry);

        $this->assertTrue($this->class->override('id', $class));

        $registry = $this->get_reflection_property_value('registry');

        $this->assertArrayHasKey('id', $registry);
        $this->assertSame($class, $registry['id']);
    }

    /**
     * Test that override() returns FALSE when trying to override with non-object.
     *
     * @param mixed $value Non-object value
     *
     * @dataProvider invalidObjectProvider
     * @covers       Lunr\Core\ConfigServiceLocator::override
     */
    public function testOverrideWithInvalidObject($value)
    {
        $this->assertFalse($this->class->override('id', $value));
    }

    /**
     * Test that override() returns TRUE when successful.
     *
     * @covers Lunr\Core\ConfigServiceLocator::override
     */
    public function testSuccessfulOverride()
    {
        $class = new \stdClass();

        $this->assertTrue($this->class->override('id', $class));

        $registry = $this->get_reflection_property_value('registry');

        $this->assertArrayHasKey('id', $registry);
        $this->assertSame($class, $registry['id']);
    }

}
