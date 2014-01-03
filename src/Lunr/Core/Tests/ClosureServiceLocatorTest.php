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
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\ClosureServiceLocator;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;
use stdClass;

/**
 * This class contains the tests for the locator class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\ClosureServiceLocator
 */
class LocatorTest extends LunrBaseTest
{

    /**
     * Test Case Constructor.
     */
    public function setUp()
    {
        $this->class      = new ClosureServiceLocator();
        $this->reflection = new ReflectionClass('Lunr\Core\ClosureServiceLocator');
    }

    /**
     * Test Case Destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that registry is an empty array.
     */
    public function testRegistryIsEmptyArray()
    {
        $value = $this->get_reflection_property_value('registry');

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that storing values that are not callable does not work.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider nonClosureValueProvider
     * @covers       Lunr\Core\ClosureServiceLocator::__set
     */
    public function testNonClosureValuesDoNotGetStoredWithSet($value)
    {
        $property = $this->get_accessible_reflection_property('registry');

        $value1 = $property->getValue($this->class);

        $this->class->id = $value;

        $value2 = $property->getValue($this->class);

        $this->assertEquals($value1, $value2);
        $this->assertInternalType('array', $value2);
        $this->assertEmpty($value2);
    }

    /**
     * Test that storing values that are callable works.
     *
     * @covers Lunr\Core\ClosureServiceLocator::__set
     */
    public function testClosuresGetStored()
    {
        $this->class->id = function () { return; };

        $value = $this->get_reflection_property_value('registry');

        $this->assertInternalType('array', $value);
        $this->assertArrayHasKey('id', $value);
        $this->assertCount(1, $value);
        $this->assertInternalType('callable', $value['id']);
    }

    /**
     * Test that calling an unknown ID returns NULL.
     *
     * @covers Lunr\Core\ClosureServiceLocator::__call
     */
    public function testCallingUnknownIDReturnsNull()
    {
        $this->assertNull($this->class->unknown());
    }

    /**
     * Test that calling an ID executes the stored closure.
     *
     * @covers Lunr\Core\ClosureServiceLocator::__call
     */
    public function testCallingIDExecutesClosure()
    {
        $this->class->id = function ($arg1, $arg2) { return $arg1 . $arg2; };

        $value = $this->class->id(1, 2);

        $this->assertEquals('12', $value);
    }

    /**
     * Test that declaring a non-closure value singleton returns NULL.
     *
     * @param mixed $value Non-callable value
     *
     * @dataProvider nonClosureValueProvider
     * @covers       Lunr\Core\ClosureServiceLocator::as_singleton
     */
    public function testDeclaringNonClosureSingletonReturnsNull($value)
    {
        $this->assertNull($this->class->as_singleton($value));
    }

    /**
     * Test that declaring a closure singleton returns a different closure.
     *
     * @covers Lunr\Core\ClosureServiceLocator::as_singleton
     */
    public function testDeclaringAsSingletonReturnsDifferentClosure()
    {
        $closure = function () { return 1; };
        $value   = $this->class->as_singleton($closure);

        $this->assertInternalType('callable', $value);
        $this->assertNotSame($closure, $value);
    }

    /**
     * Test that the singleton closure returns the value returned from the sub-closure.
     *
     * @covers Lunr\Core\ClosureServiceLocator::as_singleton
     */
    public function testSingletonClosureReturnsValueFromClosure()
    {
        $closure = function () { return 1; };
        $value   = $this->class->as_singleton($closure);

        $this->assertEquals(1, $value());
    }

    /**
     * Test that the singleton closure will return a singleton object starting with the second call.
     *
     * @covers Lunr\Core\ClosureServiceLocator::as_singleton
     */
    public function testSingletonClosureReturnsSingletonUponSecondCall()
    {
        $closure = function () { return new stdClass(); };
        $value   = $this->class->as_singleton($closure);

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
