<?php

/**
 * This file contains the shared Lunr base test class.
 *
 * PHP Version 5.3
 *
 * @package    Lunr\Halo
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Halo;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Closure;

/**
 * This class contains helper code for the Lunr unit tests.
 */
abstract class LunrBaseTest extends TestCase
{

    /**
     * Identifier string for backup functions.
     * @var String
     */
    const FUNCTION_ID = '_lunrbackup';

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
     * Get an accessible ReflectionMethod.
     *
     * @param string $method Method name
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
     * @param string $property Property name
     * @param mixed  $value    New value of the property
     *
     * @return void
     */
    protected function set_reflection_property_value($property, $value)
    {
        $this->get_accessible_reflection_property($property)
             ->setValue($this->class, $value);
    }

    /**
     * Get an accessible ReflectionProperty.
     *
     * @param string $property Property name
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
     * Get a value from a class property.
     *
     * @param string $property Property name
     *
     * @return mixed $return Property value
     */
    protected function get_reflection_property_value($property)
    {
        return $this->get_accessible_reflection_property($property)
                    ->getValue($this->class);
    }

    /**
     * Mock a PHP function.
     *
     * @param string $name Function name
     * @param string $mock Replacement code for the function
     *
     * @return void
     */
    protected function mock_function($name, $mock)
    {
        if (PHP_MAJOR_VERSION < 7)
        {
            $this->runkit_mock_function($name, $mock);

            return;
        }

        $this->uopz_mock_function($name, $mock);
    }

    /**
     * Mock a PHP function with runkit.
     *
     * @param string          $name Function name
     * @param string|\Closure $mock Replacement code for the function
     *
     * @return void
     */
    private function runkit_mock_function($name, $mock)
    {
        if (!extension_loaded('runkit'))
        {
            $this->markTestSkipped('The runkit extension is not available.');
            return;
        }

        if (function_exists($name . self::FUNCTION_ID) === FALSE)
        {
            runkit_function_copy($name, $name . self::FUNCTION_ID);
        }

        if ($mock instanceof Closure)
        {
            runkit_function_redefine($name, $mock);
            return;
        }

        runkit_function_redefine($name, '', $mock);
    }

    /**
     * Mock a PHP function with uopz.
     *
     * @param string          $name Function name
     * @param string|callable $mock Replacement code for the function
     *
     * @return void
     */
    private function uopz_mock_function($name, $mock)
    {
        if (!extension_loaded('uopz'))
        {
            $this->markTestSkipped('The uopz extension is not available.');
            return;
        }

        if ($mock instanceof Closure)
        {
            uopz_set_return($name, $mock, TRUE);
            return;
        }

        uopz_set_return($name, function () use ($mock)
        {
            return eval($mock);
        }, TRUE);
    }

    /**
     * Unmock a PHP function.
     *
     * @param string $name Function name
     *
     * @return void
     */
    protected function unmock_function($name)
    {
        if (PHP_MAJOR_VERSION < 7)
        {
            $this->runkit_unmock_function($name);

            return;
        }

        $this->uopz_unmock_function($name);
    }

    /**
     * Unmock a PHP function with runkit.
     *
     * @param string $name Function name
     *
     * @return void
     */
    private function runkit_unmock_function($name)
    {
        if (!extension_loaded('runkit'))
        {
            return;
        }

        runkit_function_remove($name);
        runkit_function_rename($name . self::FUNCTION_ID, $name);
    }

    /**
     * Unmock a PHP function with uopz.
     *
     * @param string $name Function name
     *
     * @return void
     */
    private function uopz_unmock_function($name)
    {
        if (!extension_loaded('uopz'))
        {
            return;
        }

        uopz_unset_return($name);
    }

    /**
     * Mock a method.
     *
     * Replace the code of a function of a specific class
     *
     * @param callable $method     Method defined in an array form
     * @param string   $mock       Replacement code for the method
     * @param string   $visibility Visibility of the redefined method
     * @param string   $args       Comma-delimited list of arguments for the redefined method
     *
     * @return void
     */
    protected function mock_method($method, $mock, $visibility = 'public', $args = '')
    {
        if (PHP_MAJOR_VERSION < 7)
        {
            $this->runkit_mock_method($method, $mock, $visibility, $args);

            return;
        }

        //UOPZ does not support changing the visibility with the currently used function
        $this->uopz_mock_method($method, $mock, $args);
    }

    /**
     * Mock a method with runkit.
     *
     * Replace the code of a function of a specific class
     *
     * @param callable $method     Method defined in an array form
     * @param string   $mock       Replacement code for the method
     * @param string   $visibility Visibility of the redefined method
     * @param string   $args       Comma-delimited list of arguments for the redefined method
     *
     * @return void
     */
    private function runkit_mock_method($method, $mock, $visibility = 'public', $args = '')
    {
        if (!extension_loaded('runkit'))
        {
            $this->markTestSkipped('The runkit extension is not available.');
            return;
        }

        $class_name  = is_object($method[0]) ? get_class($method[0]) : $method[0];
        $method_name = $method[1];

        if (method_exists($class_name, $method_name . self::FUNCTION_ID) === FALSE)
        {
            runkit_method_copy($class_name, $method_name . self::FUNCTION_ID, $class_name, $method_name);
        }

        switch ($visibility)
        {
            case 'public':
                $visibility_flag = RUNKIT_ACC_PUBLIC;
                break;
            case 'protected':
                $visibility_flag = RUNKIT_ACC_PROTECTED;
                break;
            case 'private':
                $visibility_flag = RUNKIT_ACC_PRIVATE;
                break;
        }

        runkit_method_redefine($class_name, $method_name, $args, $mock, $visibility_flag);
    }

    /**
     * Mock a method with uopz.
     *
     * Replace the code of a function of a specific class
     *
     * @param callable $method Method defined in an array form
     * @param string   $mock   Replacement code for the method
     * @param string   $args   Comma-delimited list of arguments for the redefined method
     *
     * @return void
     */
    private function uopz_mock_method($method, $mock, $args = '')
    {
        if (!extension_loaded('uopz'))
        {
            $this->markTestSkipped('The uopz extension is not available.');
            return;
        }

        $class_name  = is_object($method[0]) ? get_class($method[0]) : $method[0];
        $method_name = $method[1];

        if ($mock instanceof Closure)
        {
            uopz_set_return($class_name, $method_name, $mock, TRUE);
            return;
        }

        $name = '_lambda_func_' . uniqid();

        $callable = 'function ' . $name . '(' . $args . '){' . $mock . '}';

        eval($callable);

        uopz_set_return($class_name, $method_name, Closure::fromCallable($name), TRUE);
    }

    /**
     * Unmock a method.
     *
     * @param callable $method Method defined in an array form
     *
     * @return void
     */
    protected function unmock_method($method)
    {
        if (PHP_MAJOR_VERSION < 7)
        {
            $this->runkit_unmock_method($method);

            return;
        }

        $this->uopz_unmock_method($method);
    }

    /**
     * Unmock a method with runkit.
     *
     * @param callable $method Method defined in an array form
     *
     * @return void
     */
    private function runkit_unmock_method($method)
    {
        if (!extension_loaded('runkit'))
        {
            return;
        }

        $class_name  = is_object($method[0]) ? get_class($method[0]) : $method[0];
        $method_name = $method[1];

        runkit_method_remove($class_name, $method_name);
        runkit_method_rename($class_name, $method_name . self::FUNCTION_ID, $method_name);
    }

    /**
     * Unmock a method with uopz.
     *
     * @param callable $method Method defined in an array form
     *
     * @return void
     */
    private function uopz_unmock_method($method)
    {
        if (!extension_loaded('uopz'))
        {
            return;
        }

        $class_name  = is_object($method[0]) ? get_class($method[0]) : $method[0];
        $method_name = $method[1];

        uopz_unset_return($class_name, $method_name);
    }

    /**
     * Redefine a constant with runkit or uopz
     *
     * TODO: Figure out why this won' work
     *
     * @param string $constant The constant
     * @param mixed  $value    New value
     *
     * @return void
     */
    protected function constant_redefine($constant, $value)
    {
        if (PHP_MAJOR_VERSION < 7)
        {
            if (!extension_loaded('runkit'))
            {
                $this->markTestSkipped('The runkit extension is not available.');
                return;
            }

            runkit_constant_redefine($constant, $value);

            return;
        }

        if (!extension_loaded('uopz'))
        {
            $this->markTestSkipped('The uopz extension is not available.');
            return;
        }

        $constant      = explode('::', $constant);
        $class_name    = $constant[0];
        $constant_name = $constant[1];

        uopz_redefine($class_name, $constant_name, $value);
    }

    /**
     * Assert that a property value equals the expected value.
     *
     * @param string $property Property name
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
     * @param string $property Property name
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
     * @param string $property Property name
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
     * @param string $file Path to file to match against
     *
     * @return void
     */
    protected function expectOutputMatchesFile($file)
    {
        $this->expectOutputString(file_get_contents($file));
    }

}

?>
