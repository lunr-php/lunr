<?php

/**
 * This file contains the ConfigServiceLocatorLocateTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

/**
 * This class contains the tests for the locator class.
 *
 * @covers     Lunr\Core\ConfigServiceLocator
 */
class ConfigServiceLocatorLocateTest extends ConfigServiceLocatorTest
{

    /**
     * Test that locate() returns an instance from the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsInstanceFromRegistry(): void
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\Configuration', $method->invokeArgs($this->class, [ 'config' ]));
    }

    /**
     * Test that locate() reinstantiates an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReinstantiatesInstanceFromCache(): void
    {
        $cache = [ 'datetime' => [ 'name' => 'Lunr\Core\DateTime', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\DateTime', $method->invokeArgs($this->class, [ 'datetime' ]));
    }

    /**
     * Test that locate() processes an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testLocateProcessesInstanceFromCache(): void
    {
        $cache = [
            'id' => [
                'methods' => [
                    [
                        'name'   => 'test',
                        'params' => [ 'param1' ],
                    ],
                    [
                        'name'   => 'test',
                        'params' => [ 'param2', 'param3' ],
                    ],
                ],
            ],
        ];

        $this->set_reflection_property_value('cache', $cache);

        $mock = $this->getMockBuilder('Lunr\Halo\CallbackMock')->getMock();

        $mock->expects($this->at(0))
             ->method('test')
             ->with('param1');

        $mock->expects($this->at(1))
             ->method('test')
             ->with('param2', 'param3');

        $this->mock_method([ $this->class, 'get_instance' ], function() use ($mock) { return $mock; });

        $method = $this->get_accessible_reflection_method('locate');

        $method->invokeArgs($this->class, [ 'id' ]);

        $this->unmock_method([ $this->class, 'get_instance' ]);
    }

    /**
     * Test that locate() processes a totally new object instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateProcessesTotallyNewInstance(): void
    {
        $method = $this->get_accessible_reflection_method('locate');

        $registry = $this->get_accessible_reflection_property('registry');

        $this->assertArrayNotHasKey('datetime', $registry->getValue($this->class));
        $method->invokeArgs($this->class, [ 'datetime' ]);

        $return = $registry->getValue($this->class);

        $this->assertArrayHasKey('datetime', $return);
        $this->assertInstanceOf('Lunr\Core\DateTime', $return['datetime']);
    }

    /**
     * Test that locate() returns totally new instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsTotallyNewInstance(): void
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertInstanceOf('Lunr\Core\DateTime', $method->invokeArgs($this->class, [ 'datetime' ]));
    }

    /**
     * Test that locate() returns NULL for an unknown ID.
     *
     * @covers Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsNullForUnknownID(): void
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertNull($method->invokeArgs($this->class, [ 'string' ]));
    }

    /**
     * Test that locate() returns NULL for a non-string ID.
     *
     * @param mixed $id Invalid ID
     *
     * @dataProvider invalidIDProvider
     * @covers       Lunr\Core\ConfigServiceLocator::locate
     */
    public function testLocateReturnsNullForNonStringID($id): void
    {
        $method = $this->get_accessible_reflection_method('locate');

        $this->assertNull($method->invokeArgs($this->class, [ $id ]));
    }

    /**
     * Test that __call() returns an instance from the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReturnsInstanceFromRegistry(): void
    {
        $this->assertInstanceOf('Lunr\Core\Configuration', $this->class->config());
    }

    /**
     * Test that __call() reinstantiates an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReinstantiatesInstanceFromCache(): void
    {
        $cache = [ 'datetime' => [ 'name' => 'Lunr\Core\DateTime', 'params' => [ 'config' ] ] ];
        $this->set_reflection_property_value('cache', $cache);

        $this->assertInstanceOf('Lunr\Core\DateTime', $this->class->datetime());
    }

    /**
     * Test that __call() processes an object from the config cache.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallProcessesInstanceFromCache(): void
    {
        $cache = [
            'id' => [
                'methods' => [
                    [
                        'name'   => 'test',
                        'params' => [ 'param1' ],
                    ],
                    [
                        'name'   => 'test',
                        'params' => [ 'param2', 'param3' ],
                    ],
                ],
            ],
        ];

        $this->set_reflection_property_value('cache', $cache);

        $mock = $this->getMockBuilder('Lunr\Halo\CallbackMock')->getMock();

        $mock->expects($this->at(0))
             ->method('test')
             ->with('param1');

        $mock->expects($this->at(1))
             ->method('test')
             ->with('param2', 'param3');

        $this->mock_method([ $this->class, 'get_instance' ], function() use ($mock) { return $mock; });

        $this->class->id();

        $this->unmock_method([ $this->class, 'get_instance' ]);
    }

    /**
     * Test that __call() processes a totally new object instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallProcessesTotallyNewInstance(): void
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
    public function testMagicCallReturnsTotallyNewInstance(): void
    {
        $this->assertInstanceOf('Lunr\Core\DateTime', $this->class->datetime());
    }

    /**
     * Test that __call() returns NULL for an unknown ID.
     *
     * @covers Lunr\Core\ConfigServiceLocator::__call
     */
    public function testMagicCallReturnsNullForUnknownID(): void
    {
        $this->assertNull($this->class->string());
    }

}

?>
