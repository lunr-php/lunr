<?php

/**
 * This file contains the ConfigServiceLocatorSupportTest class.
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
class ConfigServiceLocatorSupportTest extends ConfigServiceLocatorTest
{

    /**
     * Test that load_recipe() does not try to include non-existing files.
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeDoesNotIncludeNonExistingFile()
    {
        $filename = 'locator/locate.nonexisting.inc.php';

        $basename = str_replace('src/Lunr/Core/Tests', 'tests/statics/', __DIR__);
        $filename = $basename . $filename;

        $method = $this->get_accessible_reflection_method('load_recipe');

        $this->assertNotContains($filename, get_included_files());
        $method->invokeArgs($this->class, array('nonexisting'));
        $this->assertNotContains($filename, get_included_files());
    }

    /**
     * Test that load_recipe() includes existing files.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeIncludesExistingFile()
    {
        $filename = 'locator/locate.valid.inc.php';

        $basename = str_replace('src/Lunr/Core/Tests', 'tests/statics/', __DIR__);
        $filename = $basename . $filename;

        $method = $this->get_accessible_reflection_method('load_recipe');

        $this->assertNotContains($filename, get_included_files());
        $method->invokeArgs($this->class, array('valid'));
        $this->assertContains($filename, get_included_files());
    }

    /**
     * Test that load_recipe() caches valid recipes.
     *
     * @runInSeparateProcess
     *
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeCachesWithValidRecipies()
    {
        $method = $this->get_accessible_reflection_method('load_recipe');
        $cache  = $this->get_accessible_reflection_property('cache');

        $this->assertArrayNotHasKey('valid', $cache->getValue($this->class));
        $method->invokeArgs($this->class, array('valid'));
        $this->assertArrayHasKey('valid', $cache->getValue($this->class));
    }

    /**
     * Test that load_recipe() does not cache invalid recipes.
     *
     * @param String $id ID of an invalid recipe.
     *
     * @runInSeparateProcess
     *
     * @dataProvider invalidRecipeProvider
     * @covers Lunr\Core\ConfigServiceLocator::load_recipe
     */
    public function testLoadRecipeDoesNotCacheWithInvalidRecipes($id)
    {
        $method = $this->get_accessible_reflection_method('load_recipe');
        $cache  = $this->get_accessible_reflection_property('cache');

        $this->assertArrayNotHasKey($id, $cache->getValue($this->class));
        $method->invokeArgs($this->class, array('valid'));
        $this->assertArrayNotHasKey($id, $cache->getValue($this->class));
    }

    /**
     * Test that process_new_instance() returns the passed instance.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceReturnsInstance()
    {
        $method = $this->get_accessible_reflection_method('process_new_instance');

        $return = $method->invokeArgs($this->class, ['id', 'instance']);

        $this->assertEquals('instance', $return);
    }

    /**
     * Test that process_new_instance() does not store non-singleton objects in the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceDoesNotStoreNonSingletonsInRegistry()
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [ 'singleton' => FALSE ] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, ['id', 'instance']);
        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
    }

    /**
     * Test that process_new_instance() does not store in the registry if the singleton info is missing.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceDoesNotStoreInRegistryIfSingletonInfoMissing()
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, ['id', 'instance']);
        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
    }

    /**
     * Test that process_new_instance() stores singleton objects in the registry.
     *
     * @covers Lunr\Core\ConfigServiceLocator::process_new_instance
     */
    public function testProcessNewInstanceStoresSingletonsInRegistry()
    {
        $method   = $this->get_accessible_reflection_method('process_new_instance');
        $registry = $this->get_accessible_reflection_property('registry');

        $recipe = [ 'id' => [ 'singleton' => TRUE ] ];
        $this->set_reflection_property_value('cache', $recipe);

        $this->assertArrayNotHasKey('id', $registry->getValue($this->class));
        $method->invokeArgs($this->class, ['id', 'instance']);
        $this->assertArrayHasKey('id', $registry->getValue($this->class));
    }

}

?>
