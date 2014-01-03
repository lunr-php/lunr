<?php

/**
 * This file contains the CentralAuthenticationStoreBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Spark\Tests;

use Lunr\Spark\CentralAuthenticationStore;
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains tests for the CentralAuthenticationStore class.
 *
 * @category   Libraries
 * @package    Spark
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Spark\CentralAuthenticationStore
 */
class CentralAuthenticationStoreBaseTest extends CentralAuthenticationStoreTest
{

    /**
     * Test that the store is an empty array by default.
     */
    public function testStoreIsEmptyByDefault()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('store'));
    }

    /**
     * Test add() creates the module index in the store if it does not yet exist.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::add
     */
    public function testAddCreatesModuleIndexIfNotExists()
    {
        $this->class->add('module', 'key', 'value');

        $this->assertArrayHasKey('module', $this->get_reflection_property_value('store'));
    }

    /**
     * Test add() adds a new value to the store.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::add
     */
    public function testAddAddsNewValue()
    {
        $this->class->add('module', 'key', 'value');

        $module = $this->get_reflection_property_value('store')['module'];

        $this->assertArrayHasKey('key', $module);
        $this->assertEquals('value', $module['key']);
    }

    /**
     * Test add() overwrites the old value in the store.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::add
     */
    public function testAddOverwritesOldValue()
    {
        $this->set_reflection_property_value('store', [ 'module' => ['key' => 'value1'] ]);

        $this->class->add('module', 'key', 'value');

        $module = $this->get_reflection_property_value('store')['module'];

        $this->assertArrayHasKey('key', $module);
        $this->assertEquals('value', $module['key']);
    }

    /**
     * Test delete() removes a value from the store.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::delete
     */
    public function testDeleteUnsetsExistingIndex()
    {
        $this->set_reflection_property_value('store', [ 'module' => ['key' => 'value'] ]);

        $this->class->delete('module', 'key');

        $module = $this->get_reflection_property_value('store')['module'];

        $this->assertArrayEmpty($module);
    }

    /**
     * Test delete() does not modify the store when the index requested to be deleted does not exist.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::delete
     */
    public function testDeleteDoesNothingWhenIndexDoesNotExist()
    {
        $this->set_reflection_property_value('store', [ 'module' => ['key' => 'value'] ]);

        $before = $this->get_reflection_property_value('store');

        $this->class->delete('module', 'key1');

        $after = $this->get_reflection_property_value('store');

        $this->assertSame($before, $after);
    }

    /**
     * Test get() returns NULL when the module index does not exist.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::get
     */
    public function testGetReturnsNullWhenModuleIndexDoesNotExist()
    {
        $this->assertNull($this->class->get('module', 'key'));
    }

    /**
     * Test get() returns NULL when the index does not exist.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::get
     */
    public function testGetReturnsNullWhenIndexDoesNotExist()
    {
        $this->set_reflection_property_value('store', [ 'module' => ['key' => 'value'] ]);

        $this->assertNull($this->class->get('module', 'key1'));
    }

    /**
     * Test get() returns the value when the index does exist.
     *
     * @covers Lunr\Spark\CentralAuthenticationStore::get
     */
    public function testGetReturnsValueWhenIndexExists()
    {
        $this->set_reflection_property_value('store', [ 'module' => ['key' => 'value'] ]);

        $this->assertEquals('value', $this->class->get('module', 'key'));
    }

}

?>
