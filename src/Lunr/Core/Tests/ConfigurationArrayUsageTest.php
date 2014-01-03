<?php

/**
 * This file contains the ConfigurationArrayUsageTest class.
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
 * @covers     Lunr\Core\Configuration
 */
class ConfigurationArrayUsageTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray($this->construct_test_array());
    }

    /**
     * Test accessing the Configuration class as an array for read operations.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetGetWithExistingOffset
     */
    public function testArrayReadAccess()
    {
        $this->assertEquals($this->config['test1'], $this->configuration['test1']);
    }

    /**
     * Test accessing the Configuration class as an array for write operations.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetSetWithGivenOffset
     */
    public function testArrayWriteAccess()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertArrayNotHasKey('test4', $property->getValue($this->configuration));

        $this->configuration['test4'] = 'Value';

        $array = $property->getValue($this->configuration);

        $this->assertArrayHasKey('test4', $array);
        $this->assertEquals('Value', $array['test4']);
    }

    /**
     * Test correct isset behavior on existing offsets.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider existingConfigPairProvider
     * @depends      Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetExists
     */
    public function testIssetOnExistingOffset($offset)
    {
        $this->assertTrue(isset($this->configuration[$offset]));
    }

    /**
     * Test correct isset behavior on existing offsets.
     *
     * @param mixed $offset Offset
     *
     * @dataProvider nonExistingConfigPairProvider
     * @depends      Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetDoesNotExist
     */
    public function testIssetOnNonExistingOffset($offset)
    {
        $this->assertFalse(isset($this->configuration[$offset]));
    }

    /**
     * Test correct foreach behavior.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetExists
     * @depends Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetDoesNotExist
     * @depends Lunr\Core\Tests\ConfigurationArrayAccessTest::testOffsetGetWithExistingOffset
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testRewindRewindsPointer
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testValidIsTrueForExistingElement
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testValidIsTrueWhenElementValueIsFalse
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testValidIsFalseOnNonExistingElement
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testNextAdvancesPointer
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testCurrentIsFirstElement
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testKeyIsFirstElement
     */
    public function testForeach()
    {
        $iteration = 0;

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $config = $property->getValue($this->configuration);

        foreach($this->configuration as $key => $value)
        {
            $this->assertEquals($config[$key], $value);
            ++$iteration;
        }

        $this->assertEquals($iteration, count($this->configuration));
    }

}

?>
