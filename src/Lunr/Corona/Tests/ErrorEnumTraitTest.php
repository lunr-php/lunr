<?php

/**
 * This file contains the ErrorEnumTraitTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\ErrorEnumTrait;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains the tests for the ErrorEnumTrait.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\ErrorEnumTrait
 */
class ErrorEnumTraitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the ErrorEnumTrait.
     * @var ErrorEnumTrait
     */
    protected $class;

    /**
     * Reflection instance of the ErrorEnumTrait.
     * @var ReflectionClass
     */
    protected $reflection;

    /**
     * Test case constructor.
     */
    public function setUp()
    {
        $this->class      = $this->getObjectForTrait('Lunr\Corona\ErrorEnumTrait');
        $this->reflection = new ReflectionClass($this->class);
    }

    /**
     * Test case destructor.
     */
    public function tearDown()
    {
        unset($this->class);
        unset($this->reflection);
    }

    /**
     * Test that there are no error enums set by default.
     */
    public function testErrorNullByDefault()
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertNull($value);
    }

    /**
     * Test setting error enums.
     *
     * @covers Lunr\Corona\ErrorEnumTrait::set_error_enums
     */
    public function testSetErrorEnums()
    {
        $ERROR['not_implemented'] = 503;

        $this->class->set_error_enums($ERROR);

        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals($ERROR, $value);
        $this->assertSame($ERROR, $value);
    }

}

?>
