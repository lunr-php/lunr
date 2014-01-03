<?php

/**
 * This file contains the ConfigurationArrayAccessTest class.
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
 * This tests the ArrayAccess methods of the Configuration class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @depends    Lunr\Core\Tests\ConfigurationArrayConstructorTest::testConfig
 * @covers     Lunr\Core\Configuration
 */
class ConfigurationArrayAccessTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray($this->construct_test_array());
    }

    /**
     * Test offsetExists() with existing values.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider existingConfigPairProvider
     */
    public function testOffsetExists($offset)
    {
        $this->assertTrue($this->configuration->offsetExists($offset));
    }

    /**
     * Test offsetExists() with non existing values.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider nonExistingConfigPairProvider
     */
    public function testOffsetDoesNotExist($offset)
    {
        $this->assertFalse($this->configuration->offsetExists($offset));
    }

    /**
     * Test offsetGet() with non existing values.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider existingConfigPairProvider
     */
    public function testOffsetGetWithExistingOffset($offset)
    {
        $this->assertEquals($this->config[$offset], $this->configuration->offsetGet($offset));
    }

    /**
     * Test offsetGet() with non existing values.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider nonExistingConfigPairProvider
     */
    public function testOffsetGetWithNonExistingOffset($offset)
    {
        $this->assertNull($this->configuration->offsetGet($offset));
    }

    /**
     * Test that offsetUnset() unsets the config value.
     */
    public function testOffsetUnsetDoesUnset()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertArrayHasKey('test1', $property->getValue($this->configuration));

        $this->configuration->offsetUnset('test1');

        $this->assertArrayNotHasKey('test1', $property->getValue($this->configuration));
    }

    /**
     * Test that offsetUnset sets $size_invalid to FALSE.
     */
    public function testOffsetUnsetInvalidatesSize()
    {
        $property = $this->configuration_reflection->getProperty('size_invalid');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->configuration));

        $this->configuration->offsetUnset('test1');

        $this->assertTrue($property->getValue($this->configuration));
    }

    /**
     * Test offsetSet() with a given offset.
     *
     * @depends Lunr\Core\Tests\ConfigurationConvertArrayToClassTest::testConvertArrayToClassWithMultidimensionalArrayValue
     */
    public function testOffsetSetWithGivenOffset()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertArrayNotHasKey('test4', $property->getValue($this->configuration));

        $this->configuration->offsetSet('test4', 'Value');

        $value = $property->getValue($this->configuration);

        $this->assertArrayHasKey('test1', $value);
        $this->assertEquals('Value', $value['test4']);
    }

    /**
     * Test offsetSet() with a null offset.
     *
     * @depends Lunr\Core\Tests\ConfigurationConvertArrayToClassTest::testConvertArrayToClassWithMultidimensionalArrayValue
     */
    public function testOffsetSetWithNullOffset()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertArrayNotHasKey(0, $property->getValue($this->configuration));

        $this->configuration->offsetSet(NULL, 'Value');

        $value = $property->getValue($this->configuration);

        $this->assertArrayHasKey(0, $value);
        $this->assertEquals('Value', $value[0]);
    }

    /**
     * Test that offsetSet sets $size_invalid to FALSE.
     */
    public function testOffsetSetInvalidatesSize()
    {
        $property = $this->configuration_reflection->getProperty('size_invalid');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->configuration));

        $this->configuration->offsetSet('test5', 'Value');

        $this->assertTrue($property->getValue($this->configuration));
    }

}

?>
