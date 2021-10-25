<?php

/**
 * This file contains the ConfigServiceLocatorSupportTest class.
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
class ConfigServiceLocatorSupportTest extends ConfigServiceLocatorTest
{

    /**
     * Test that load_recipe() does not try to include non-existing files.
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeDoesNotIncludeNonExistingFile(): void
    {
        $filename = 'Core/locator/locate.nonexisting.inc.php';

        $basename = str_replace('src/Lunr/Core/Tests', 'tests/statics/', __DIR__);
        $filename = $basename . $filename;

        $method = $this->get_accessible_reflection_method('load_recipe');

        $this->assertNotContains($filename, get_included_files());
        $method->invokeArgs($this->class, [ 'nonexisting' ]);
        $this->assertNotContains($filename, get_included_files());
    }

    /**
     * Test that load_recipe() includes existing files.
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeIncludesExistingFile(): void
    {
        $filename = 'Core/locator/locate.valid.inc.php';

        $basename = str_replace('src/Lunr/Core/Tests', 'tests/statics/', __DIR__);
        $filename = $basename . $filename;

        $method = $this->get_accessible_reflection_method('load_recipe');

        $this->assertNotContains($filename, get_included_files());
        $method->invokeArgs($this->class, [ 'valid' ]);
        $this->assertContains($filename, get_included_files());
    }

    /**
     * Test that load_recipe() caches valid recipes.
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeCachesWithValidRecipies(): void
    {
        $method = $this->get_accessible_reflection_method('load_recipe');
        $cache  = $this->get_accessible_reflection_property('cache');

        $this->assertArrayNotHasKey('valid', $cache->getValue($this->class));
        $method->invokeArgs($this->class, [ 'valid' ]);
        $this->assertArrayHasKey('valid', $cache->getValue($this->class));
    }

    /**
     * Test that load_recipe() does not cache invalid recipes.
     *
     * @param string $id ID of an invalid recipe.
     *
     * @dataProvider invalidRecipeProvider
     * @covers       Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeDoesNotCacheWithInvalidRecipes($id): void
    {
        $method = $this->get_accessible_reflection_method('load_recipe');
        $cache  = $this->get_accessible_reflection_property('cache');

        $this->assertArrayNotHasKey($id, $cache->getValue($this->class));
        $method->invokeArgs($this->class, [ 'valid' ]);
        $this->assertArrayNotHasKey($id, $cache->getValue($this->class));
    }

    /**
     * Test that process_new_instance() returns the passed instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceReturnsInstance(): void
    {
        $method = $this->get_accessible_reflection_method('process_new_instance');

        $return = $method->invokeArgs($this->class, [ 'id', 'instance' ]);

        $this->assertEquals('instance', $return);
    }

    /**
     * Test that process_new_instance() does not store non-singleton objects in the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceDoesNotStoreNonSingletonsInRegistry(): void
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [ 'singleton' => FALSE ] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, [ 'id', 'instance' ]);
        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
    }

    /**
     * Test that process_new_instance() does not store in the registry if the singleton info is missing.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceDoesNotStoreInRegistryIfSingletonInfoMissing(): void
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, [ 'id', 'instance' ]);
        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
    }

    /**
     * Test that process_new_instance() stores singleton objects in the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceStoresSingletonsInRegistry(): void
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [ 'singleton' => TRUE ] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, [ 'id', 'instance' ]);
        $this->assertArrayHasKey('id', $registry->getValue($this->class));
    }

    /**
     * Test that process_new_instance() calls defined methods with params.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceCallsMethodsWithParams(): void
    {
        $recipe = [
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

        $this->set_reflection_property_value('cache', $recipe);

        $mock = $this->getMockBuilder('Lunr\Halo\CallbackMock')->getMock();

        $mock->expects($this->exactly(2))
             ->method('test')
             ->withConsecutive(
                 [ 'param1' ],
                 [ 'param2', 'param3' ]
             );

        $method = $this->get_accessible_reflection_method('process_new_instance');
        $method->invokeArgs($this->class, [ 'id', $mock ]);
    }

    /**
     * Test that process_new_instance() calls defined methods with no params.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceCallsMethodsWithNoParams(): void
    {
        $recipe = [
            'id' => [
                'methods' => [
                    [ 'name' => 'test' ],
                ],
            ],
        ];

        $this->set_reflection_property_value('cache', $recipe);

        $mock = $this->getMockBuilder('Lunr\Halo\CallbackMock')->getMock();

        $mock->expects($this->exactly(1))
             ->method('test');

        $method = $this->get_accessible_reflection_method('process_new_instance');
        $method->invokeArgs($this->class, [ 'id', $mock ]);
    }

    /**
     * Test that process_new_instance() calls defined methods with located params.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceCallsMethodsWithLocatedParams(): void
    {
        $recipe = [
            'id' => [
                'methods' => [
                    [
                        'name'   => 'test',
                        'params' => [ 'object1_id', 'param2' ],
                    ],
                ],
            ],
        ];

        $object1 = (object) [ 'key1' => 'value1' ];

        $this->set_reflection_property_value('cache', $recipe);
        $this->set_reflection_property_value('registry', [ 'object1_id' => $object1 ]);

        $mock = $this->getMockBuilder('Lunr\Halo\CallbackMock')->getMock();

        $mock->expects($this->exactly(1))
             ->method('test')
             ->with($this->identicalTo($object1), 'param2');

        $method = $this->get_accessible_reflection_method('process_new_instance');
        $method->invokeArgs($this->class, [ 'id', $mock ]);
    }

}

?>
