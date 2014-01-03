<?php

/**
 * This file contains the shared Lunr base test class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo;

use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains helper code for the Lunr unit tests.
 *
 * @category   Libraries
 * @package    Halo
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */
abstract class LunrBaseTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the tested class.
     * @var mixed
     */
    protected $class;

    /**
     * Reflection instance of the tested class.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Identifier string for backup functions.
     * @var String
     */
    const FUNCTION_ID = '_lunrbackup';

    /**
     * Testcase Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Get an accessible ReflectionProperty.
     *
     * @param String $property Property name
     *
     * @return ReflectionProperty $return The ReflectionProperty instance
     */
    protected function get_accessible_reflection_property($property)
    {
        $return = $this->reflection->getProperty($property);
        $return->setAccessible(TRUE);

        return $return;
    }

    /**
     * Get an accessible ReflectionMethod.
     *
     * @param String $method Method name
     *
     * @return ReflectionMethod $return The ReflectionMethod instance
     */
    protected function get_accessible_reflection_method($method)
    {
        $return = $this->reflection->getMethod($method);
        $return->setAccessible(TRUE);

        return $return;
    }

    /**
     * Set a value for a class property.
     *
     * @param String $property Property name
     * @param mixed  $value    New value of the property
     *
     * @return void
     */
    protected function set_reflection_property_value($property, $value)
    {
        $this->get_accessible_reflection_property($property)->setValue($this->class, $value);
    }

    /**
     * Get a value from a class property.
     *
     * @param String $property Property name
     *
     * @return mixed $return Property value
     */
    protected function get_reflection_property_value($property)
    {
        return $this->get_accessible_reflection_property($property)->getValue($this->class);
    }

    /**
     * Mock a PHP function.
     *
     * @param String $name Function name
     * @param String $mock Replacement code for the function
     *
     * @return void
     */
    protected function mock_function($name, $mock)
    {
        runkit_function_copy($name, $name . self::FUNCTION_ID);
        runkit_function_redefine($name, '', $mock);
    }

    /**
     * Unmock a PHP function.
     *
     * @param String $name Function name
     *
     * @return void
     */
    protected function unmock_function($name)
    {
        runkit_function_remove($name);
        runkit_function_rename($name . self::FUNCTION_ID, $name);
    }

    /**
     * Assert that a property value equals the expected value.
     *
     * @param String $property Property name
     * @param mixed  $expected Expected value of the property
     *
     * @return void
     */
    protected function assertPropertyEquals($property, $expected)
    {
        $property = $this->get_accessible_reflection_property($property);
        $this->assertEquals($expected, $property->getValue($this->class));
    }

    /**
     * Assert that a property value equals the expected value.
     *
     * @param String $property Property name
     * @param mixed  $expected Expected value of the property
     *
     * @return void
     */
    protected function assertPropertySame($property, $expected)
    {
        $property = $this->get_accessible_reflection_property($property);
        $this->assertSame($expected, $property->getValue($this->class));
    }

    /**
     * Assert that a property value is empty.
     *
     * @param String $property Property name
     *
     * @return void
     */
    protected function assertPropertyEmpty($property)
    {
        $property = $this->get_accessible_reflection_property($property);
        $this->assertEmpty($property->getValue($this->class));
    }

    /**
     * Assert that an array is empty.
     *
     * @param mixed $value The value to test.
     *
     * @return void
     */
    protected function assertArrayEmpty($value)
    {
        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Assert that an array is not empty.
     *
     * @param mixed $value The value to test.
     *
     * @return void
     */
    protected function assertArrayNotEmpty($value)
    {
        $this->assertInternalType('array', $value);
        $this->assertNotEmpty($value);
    }

    /**
     * Expect that the output generating by the tested method matches the content of the given file.
     *
     * @param String $file Path to file to match against
     *
     * @return void
     */
    protected function expectOutputMatchesFile($file)
    {
        $this->expectOutputString(file_get_contents($file));
    }

}

?>
