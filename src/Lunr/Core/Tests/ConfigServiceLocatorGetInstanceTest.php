<?php

/**
 * This file contains the ConfigServiceLocatorGetInstanceTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the locator class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\ConfigServiceLocator
 */
class ConfigServiceLocatorGetInstanceTest extends ConfigServiceLocatorTest
{

    /**
     * Test that get_instance() returns NULL for a non-instantiable class.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsNullForNonInstantiableClass()
    {
        $cache = [ 'controller' => [ 'name' => 'Lunr\Corona\Controller' ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertNull($method->invokeArgs($this->class, ['controller']));
    }

    /**
     * Test that get_instance() returns an instance if the class doesn't have a Constructor.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForClassWithoutConstructor()
    {
        $cache = [ 'stdclass' => [ 'name' => 'stdClass' ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('stdClass', $method->invokeArgs($this->class, ['stdclass']));
    }

    /**
     * Test that get_instance() returns NULL when there are not enough arguments for the Constructor.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsNullForTooLittleNumberOfConstructorArguments()
    {
        $cache = [ 'request' => [ 'name' => 'Lunr\Corona\Request', 'params' => [] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertNull($method->invokeArgs($this->class, ['request']));
    }

    /**
     * Test that get_instance() returns an instance for a Constructor with arguments.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForConstructorWithArguments()
    {
        $cache = [ 'request' => [ 'name' => 'Lunr\Corona\Request', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('Lunr\Corona\Request', $method->invokeArgs($this->class, ['request']));
    }

    /**
     * Test that get_instance() returns an instance for a Constructor without arguments.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_instance
     */
    public function testGetInstanceReturnsInstanceForConstructorWithoutArguments()
    {
        $cache = [ 'datetime' => [ 'name' => 'Lunr\Core\DateTime', 'params' => [] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('get_instance');

        $this->assertInstanceOf('Lunr\Core\DateTime', $method->invokeArgs($this->class, ['datetime']));
    }

    /**
     * Test that get_parameters processes ID parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesIDParameter()
    {
        $params = [ 'config' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertInternalType('array', $return);
        $this->assertInstanceOf('Lunr\Core\Configuration', $return[0]);
    }

    /**
     * Test that get_parameters processes non-ID parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesNonIDParameter()
    {
        $params = [ 'string' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertInternalType('array', $return);
        $this->assertEquals('string', $return[0]);
    }

    /**
     * Test that get_parameters processes mixed parameters.
     *
     * @covers Lunr\Core\ConfigServiceLocator::get_parameters
     */
    public function testGetParametersProcessesMixedParameters()
    {
        $params = [ 'config', 'string' ];

        $method = $this->get_accessible_reflection_method('get_parameters');

        $return = $method->invokeArgs($this->class, [ $params ]);

        $this->assertInternalType('array', $return);
        $this->assertInstanceOf('Lunr\Core\Configuration', $return[0]);
        $this->assertEquals('string', $return[1]);
    }

}

?>
