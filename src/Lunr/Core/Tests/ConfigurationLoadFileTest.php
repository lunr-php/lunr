<?php

/**
 * This file contains the ConfigurationLoadFileTest class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Configuration;

/**
 * This tests loading configuration files via the Configuration class.
 *
 * @depends    Lunr\Core\Tests\ConfigurationConvertArrayToClassTest::testConvertArrayToClassWithMultidimensionalArrayValue
 * @covers     Lunr\Core\Configuration
 */
class ConfigurationLoadFileTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray($this->construct_test_array());
    }

    /**
     * Test loading a correct config file.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testToArrayEqualsInput
     */
    public function testLoadCorrectFile()
    {
        $this->configuration->load_file('correct');

        $this->config['load']        = array();
        $this->config['load']['one'] = 'Value';
        $this->config['load']['two'] = 'String';

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->config, $this->configuration->toArray());
    }

    /**
     * Test loading a correct config file.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testToArrayEqualsInput
     */
    public function testLoadFileOverwritesValues()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->configuration->load_file('overwrite');

        $config                   = array();
        $config['test1']          = 'Value';
        $config['test2']          = array();
        $config['test2']['test3'] = 1;
        $config['test2']['test4'] = FALSE;

        $this->assertEquals($config, $this->configuration->toArray());
    }

    /**
     * Test loading a correct config file.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testToArrayEqualsInput
     */
    public function testLoadFileMergesArrays()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->configuration->load_file('merge');

        $config                   = array();
        $config['test1']          = 'String';
        $config['test2']          = array();
        $config['test2']['test3'] = 1;
        $config['test2']['test4'] = FALSE;
        $config['test2']['test5'] = 'Value';

        $this->assertEquals($config, $this->configuration->toArray());
    }

    /**
     * Test loading an invalid config file.
     */
    public function testLoadInvalidFile()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $before = $property->getValue($this->configuration);

        $this->configuration->load_file('not_array');

        $after = $property->getValue($this->configuration);

        $this->assertEquals($before, $after);
    }

    /**
     * Test loading a non-existing file.
     */
    public function testLoadNonExistingFile()
    {
        if (class_exists('\PHPUnit\Framework\Error\Error'))
        {
            // PHPUnit 6
            $this->expectException(\PHPUnit\Framework\Error\Error::class);
        } else {
            // PHPUnit 5
            $this->expectException(\PHPUnit_Framework_Error::class);
        }

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $before = $property->getValue($this->configuration);

        $this->configuration->load_file('not_exists');

        $after = $property->getValue($this->configuration);

        $this->assertEquals($before, $after);
    }

    /**
     * Test that loading a file invalidates the cached size value.
     */
    public function testLoadFileInvalidatesSize()
    {
        $property = $this->configuration_reflection->getProperty('size_invalid');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->configuration));

        $this->configuration->load_file('correct');

        $this->assertTrue($property->getValue($this->configuration));
    }

}

?>
