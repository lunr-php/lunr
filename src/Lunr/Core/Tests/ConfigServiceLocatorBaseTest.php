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
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
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

}
