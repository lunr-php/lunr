<?php

/**
 * This file contains the ConfigurationLoadFileTest class.
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
 * This tests loading configuration files via the Configuration class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @depends    Lunr\Libraries\Core\ConfigurationConvertArrayToClassTest::testConvertArrayToClassWithMultidimensionalArrayValue
 * @covers     Lunr\Libraries\Core\Configuration
 */
class ConfigurationLoadFileTest extends ConfigurationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpArray($this->construct_test_array());
        set_include_path(dirname(__FILE__) . '/../../../statics/configuration:' . get_include_path());
    }

    /**
     * Test loading a correct config file.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Libraries\Core\ConfigurationArrayConstructorTest::testToArrayEqualsInput
     */
    public function testLoadCorrectFile()
    {
        $this->configuration->load_file('correct');

        $this->config['load'] = array();
        $this->config['load']['one'] = 'Value';
        $this->config['load']['two'] = 'String';

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->config, $this->configuration->toArray());
    }

    /**
     * Test loading an invalid config file.
     *
     * @runInSeparateProcess
     */
    public function testLoadInvalidFile()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $before = $property->getValue($this->configuration);

        $this->configuration->load_file('not_array');

        $after  = $property->getValue($this->configuration);

        $this->assertEquals($before, $after);
    }

    /**
     * Test loading a non-existing file.
     *
     * @runInSeparateProcess
     */
//     public function testLoadNonExistingFile()
//     {
//         $this->configuration->load_file('not_exists');
//     }

    /**
     * Test that loading a file invalidates the cached size value.
     *
     * @runInSeparateProcess
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
