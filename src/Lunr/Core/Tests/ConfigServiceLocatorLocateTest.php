<?php

/**
 * This file contains the ConfigServiceLocatorLocateTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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
class ConfigServiceLocatorLocateTest extends ConfigServiceLocatorTest
{

    /**
     * Test that locate() returns an instance from the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsInstanceFromRegistry()
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\Configuration', $method->invokeArgs($this->class, ['config']));
    }

    /**
     * Test that locate() reinstantiates an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReinstantiatesInstanceFromCache()
    {
        $cache = [ 'datetime' => [ 'name' => 'Lunr\Core\DateTime', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\DateTime', $method->invokeArgs($this->class, ['datetime']));
    }

    /**
     * Test that locate() processes a totally new object instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateProcessesTotallyNewInstance()
    {
        $method = $this->get_accessible_reflection_method('locate');

        $registry = $this->get_accessible_reflection_property('registry');

        $this->assertArrayNotHasKey('datetime', $registry->getValue($this->class));
        $method->invokeArgs($this->class, ['datetime']);

        $return = $registry->getValue($this->class);

        $this->assertArrayHasKey('datetime', $return);
        $this->assertInstanceOf('Lunr\Core\DateTime', $return['datetime']);
    }

    /**
     * Test that locate() returns totally new instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsTotallyNewInstance()
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\DateTime', $method->invokeArgs($this->class, ['datetime']));
    }

    /**
     * Test that locate() returns NULL for an unknown ID.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsNullForUnknownID()
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertNull($method->invokeArgs($this->class, ['string']));
    }

    /**
     * Test that locate() returns NULL for a non-string ID.
     *
     * @param mixed $id Invalid ID
     *
     * @dataProvider invalidIDProvider
     * @covers       Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsNullForNonStringID($id)
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertNull($method->invokeArgs($this->class, [ $id ]));
    }

    /**
     * Test that __call() returns an instance from the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReturnsInstanceFromRegistry()
    {
        $this->assertInstanceOf('Lunr\Core\Configuration', $this->class->config());
    }

    /**
     * Test that __call() reinstantiates an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReinstantiatesInstanceFromCache()
    {
        $cache = [ 'datetime' => [ 'name' => 'Lunr\Core\DateTime', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $this->assertInstanceOf('Lunr\Core\DateTime', $this->class->datetime());
    }

    /**
     * Test that __call() processes a totally new object instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallProcessesTotallyNewInstance()
    {
        $registry = $this->get_accessible_reflection_property('registry');

        $this->assertArrayNotHasKey('datetime', $registry->getValue($this->class));
        $this->class->datetime();

        $return = $registry->getValue($this->class);

        $this->assertArrayHasKey('datetime', $return);
        $this->assertInstanceOf('Lunr\Core\DateTime', $return['datetime']);
    }

    /**
     * Test that __call() returns totally new instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReturnsTotallyNewInstance()
    {
        $this->assertInstanceOf('Lunr\Core\DateTime', $this->class->datetime());
    }

    /**
     * Test that __call() returns NULL for an unknown ID.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReturnsNullForUnknownID()
    {
        $this->assertNull($this->class->string());
    }

}

?>
