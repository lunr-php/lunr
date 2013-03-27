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
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
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
        $this->get_accessible_reflection_property($property)->getValue($this->class);
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

}

?>
