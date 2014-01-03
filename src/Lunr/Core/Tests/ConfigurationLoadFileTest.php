<?php

/**
 * This file contains the ConfigurationLoadFileTest class.
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
 * This tests loading configuration files via the Configuration class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLoadNonExistingFile()
    {
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

    /**
     * Test loading a correct database config file.
     *
     * @depends Lunr\Core\Tests\ConfigurationArrayConstructorTest::testToArrayEqualsInput
     */
    public function testLoadCorrectDatabaseConfig()
    {
        $oldpath = get_include_path();

        set_include_path(TEST_STATICS . '/Core/valid:' . get_include_path());

        $this->configuration->load_database_config();

        $this->config['db']             = array();
        $this->config['db']['rw_host']  = '10.0.0.22';
        $this->config['db']['ro_host']  = '10.0.0.10';
        $this->config['db']['username'] = 'schiphol';
        $this->config['db']['password'] = '@Sch1ph0l';
        $this->config['db']['database'] = 'MidSchipDB';
        $this->config['db']['driver']   = 'mysql';

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->config, $this->configuration->toArray());

        set_include_path($oldpath);
    }

    /**
     * Test loading an invalid config file.
     */
    public function testLoadInvalidDatabaseConfig()
    {
        $oldpath = get_include_path();

        set_include_path(TEST_STATICS . '/Core/invalid:' . get_include_path());

        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $before = $property->getValue($this->configuration);

        $this->configuration->load_database_config();

        $after = $property->getValue($this->configuration);

        $this->assertEquals($before, $after);

        set_include_path($oldpath);
    }

    /**
     * Test loading a non-existing database config file.
     *
     * @expectedException PHPUnit_Framework_Error
     */
    public function testLoadNonExistingDatabaseConfig()
    {
        $property = $this->configuration_reflection->getProperty('config');
        $property->setAccessible(TRUE);

        $before = $property->getValue($this->configuration);

        $this->configuration->load_database_config();

        $after = $property->getValue($this->configuration);

        $this->assertEquals($before, $after);
    }

    /**
     * Test that loading a database config file invalidates the cached size value.
     */
    public function testLoadDatabaseConfigInvalidatesSize()
    {
        set_include_path(TEST_STATICS . '/Core/valid:' . get_include_path());

        $property = $this->configuration_reflection->getProperty('size_invalid');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->configuration));

        $this->configuration->load_database_config();

        $this->assertTrue($property->getValue($this->configuration));
    }

}

?>
