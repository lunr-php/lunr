<?php

/**
 * This file contains the ConfigurationTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Configuration;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use stdClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the Configuration class.
 *
 * @covers     Lunr\Core\DateTime
 */
abstract class ConfigurationTest extends TestCase
{

    /**
     * Instance of the Configuration class.
     * @var Configuration
     */
    protected $configuration;

    /**
     * Reflection instance of the Configuration class.
     * @var ReflectionClass
     */
    protected $configuration_reflection;

    /**
     * Default config values.
     * @var array
     */
    protected $config;

    /**
     * Setup a default Configuration class.
     *
     * @return void
     */
    protected function setUpNonArray()
    {
        $this->configuration            = new Configuration();
        $this->configuration_reflection = new ReflectionClass('Lunr\Core\Configuration');
    }

    /**
     * Setup a Configuration class initialized with an existing $config array.
     *
     * @param array $config Existing configuration values
     *
     * @return void
     */
    protected function setUpArray($config)
    {
        $this->config                   = $config;
        $this->configuration            = new Configuration($config);
        $this->configuration_reflection = new ReflectionClass('Lunr\Core\Configuration');
    }

    /**
     * TestCase Destructor.
     */
    protected function tearDown()
    {
        unset($this->config);
        unset($this->configuration);
        unset($this->configuration_reflection);
    }

    /**
     * Construct the multi-dimensional test array.
     *
     * @return array Test $config array
     */
    protected function construct_test_array()
    {
        $config                   = [];
        $config['test1']          = 'String';
        $config['test2']          = [];
        $config['test2']['test3'] = 1;
        $config['test2']['test4'] = FALSE;

        return $config;
    }

    /**
     * Unit Test Data Provider for non-array values.
     *
     * @return array $values Set of non-array values.
     */
    public function nonArrayValueProvider()
    {
        $values   = [];
        $values[] = [ 'String' ];
        $values[] = [ 1 ];
        $values[] = [ NULL ];
        $values[] = [ FALSE ];
        $values[] = [ new stdClass() ];

        return $values;
    }

    /**
     * Unit Test Data Provider for existing $config key->value pairs.
     *
     * @return array $pairs Existing key->value pairs
     */
    public function existingConfigPairProvider()
    {
        $pairs   = [];
        $pairs[] = [ 'test1', 'String' ];

        return $pairs;
    }

    /**
     * Unit Test Data Provider for not existing $config key->value pairs.
     *
     * @return array $pairs Not existing key->value pairs
     */
    public function nonExistingConfigPairProvider()
    {
        $pairs   = [];
        $pairs[] = [ 'test4', 'Value' ];

        return $pairs;
    }

}

?>
