<?php

/**
 * This file contains the LocatorTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\Locator;
use PHPUnit_Framework_TestCase;
use ReflectionClass;
use stdClass;

/**
 * This class contains the tests for the locator class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Locator
 */
class LocatorTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the Locator class.
     * @var Locator
     */
    private $locator;

    /**
     * Reflection instance of the Locator class.
     * @var ReflectionClass
     */
    private $locator_reflection;

    /**
     * Test Case Constructor.
     */
    public function setUp()
    {
        $this->locator            = new Locator();
        $this->locator_reflection = new ReflectionClass('Lunr\Core\Locator');
    }

    /**
     * Test Case Destructor.
     */
    public function tearDown()
    {
        unset($this->locator);
        unset($this->locator_reflection);
    }

    /**
     * Test that registry is an empty array.
     */
    public function testRegistryIsEmptyArray()
    {
        $property = $this->locator_reflection->getProperty('registry');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->locator);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that storing values that are not callable does not work.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider nonClosureValueProvider
     * @covers       Lunr\Core\Locator::__set
     */
    public function testNonClosureValuesDoNotGetStoredWithSet($value)
    {
        $property = $this->locator_reflection->getProperty('registry');
        $property->setAccessible(TRUE);

        $value1 = $property->getValue($this->locator);

        $this->locator->id = $value;

        $value2 = $property->getValue($this->locator);

        $this->assertEquals($value1, $value2);
        $this->assertInternalType('array', $value2);
        $this->assertEmpty($value2);
    }

    /**
     * Test that storing values that are callable works.
     *
     * @covers Lunr\Core\Locator::__set
     */
    public function testClosuresGetStored()
    {
        $property = $this->locator_reflection->getProperty('registry');
        $property->setAccessible(TRUE);

        $this->locator->id = function () { return; };

        $value = $property->getValue($this->locator);

        $this->assertInternalType('array', $value);
        $this->assertArrayHasKey('id', $value);
        $this->assertCount(1, $value);
        $this->assertInternalType('callable', $value['id']);
    }

    /**
     * Test that calling an unknown ID returns NULL.
     *
     * @covers Lunr\Core\Locator::__call
     */
    public function testCallingUnknownIDReturnsNull()
    {
        $this->assertNull($this->locator->unknown());
    }

    /**
     * Test that calling an ID executes the stored closure.
     *
     * @covers Lunr\Core\Locator::__call
     */
    public function testCallingIDExecutesClosure()
    {
        $this->locator->id = function ($arg1, $arg2) { return $arg1 . $arg2; };

        $value = $this->locator->id(1, 2);

        $this->assertEquals('12', $value);
    }

    /**
     * Test that declaring a non-closure value singleton returns NULL.
     *
     * @param mixed $value Non-callable value
     *
     * @dataProvider nonClosureValueProvider
     * @covers       Lunr\Core\Locator::as_singleton
     */
    public function testDeclaringNonClosureSingletonReturnsNull($value)
    {
        $this->assertNull($this->locator->as_singleton($value));
    }

    /**
     * Test that declaring a closure singleton returns a different closure.
     *
     * @covers Lunr\Core\Locator::as_singleton
     */
    public function testDeclaringAsSingletonReturnsDifferentClosure()
    {
        $closure = function () { return 1; };
        $value   = $this->locator->as_singleton($closure);

        $this->assertInternalType('callable', $value);
        $this->assertNotSame($closure, $value);
    }

    /**
     * Test that the singleton closure returns the value returned from the sub-closure.
     *
     * @covers Lunr\Core\Locator::as_singleton
     */
    public function testSingletonClosureReturnsValueFromClosure()
    {
        $closure = function () { return 1; };
        $value   = $this->locator->as_singleton($closure);

        $this->assertEquals(1, $value());
    }

    /**
     * Test that the singleton closure will return a singleton object starting with the second call.
     *
     * @covers Lunr\Core\Locator::as_singleton
     */
    public function testSingletonClosureReturnsSingletonUponSecondCall()
    {
        $closure = function () { return new stdClass(); };
        $value   = $this->locator->as_singleton($closure);

        $class1       = $value();
        $class1->test = 'value';

        $class2 = $value();

        $this->assertEquals('value', $class2->test);
        $this->assertSame($class1, $class2);
    }

    /**
     * Unit test data provider for non-closure values.
     *
     * @return array $data Array of non-closure values.
     */
    public function nonClosureValueProvider()
    {
        $data   = array();
        $data[] = array(TRUE);
        $data[] = array(NULL);
        $data[] = array(new stdClass());
        $data[] = array('string');
        $data[] = array(1);
        $data[] = array(1.5);

        return $data;
    }

}

?>
