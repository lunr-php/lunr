<?php

/**
 * This file contains the RequestStoreGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for storing superglobal values.
 *
 * @category      Libraries
 * @package       Corona
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @author        Leonidas Diamantis <leonidas@m2mobi.com>
 * @covers        Lunr\Corona\Request
 * @backupGlobals enabled
 */
class RequestStoreGetTest extends RequestTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->setUpEmpty();
    }

    /**
     * Test storing invalid $_GET values.
     *
     * After providing invalid get values to the store_get function, it checks
     * whether the get property is empty.
     *
     * @param mixed $get Invalid $_GET values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\Request::store_get
     */
    public function testStoreInvalidGetValuesLeavesGetPropertyEmpty($get)
    {
        $_GET = $get;

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $this->assertArrayEmpty($this->get_reflection_property_value('get'));
    }

    /**
    * Test storing invalid $_GET values.
    *
    * After providing invalid get values to the store_get function, it checks
    * whether the global GET is reset to being empty.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesResetsSuperglobalGet($get)
    {
        $_GET = $get;

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $this->assertArrayEmpty($_GET);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * After providing invalid get values to the store_get function, it checks
    * whether the method and controller fields have the default values and the
    * params array is empty.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesGetsDefaultControllerAndMethodWithEmptyParams($get)
    {
        $_GET = $get;

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('DefaultController', $request['controller']);
        $this->assertEquals('default_method', $request['method']);
        $this->assertEmpty($request['params']);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * If we have default values for controller and method, construct the
    * call value.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesStoresCallIfDefaultsSet($get)
    {
        $_GET = $get;

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $call = 'DefaultController/default_method';

        $this->assertEquals($call, $request['call']);
    }

    /**
    * Test storing invalid $_GET values.
    *
    * If we don't have default values for controller and method, skip
    * construction of the call value.
    *
    * @param mixed $get Invalid $_GET values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\Request::store_get
    */
    public function testStoreInvalidGetValuesDoesNotStoreCallIfDefaultsNotSet($get)
    {
        $this->set_reflection_property_value('request', []);

        $_GET = $get;

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertNull($request['call']);
    }

    /**
     * Test storing valid $_GET values.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testStoreValidGetValues()
    {
        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';
        $cache         = $_GET;

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $this->assertPropertyEquals('get', $cache);
    }

    /**
     * Test storing special $_GET values.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testStoreSpecialGetValues()
    {
        $this->set_reflection_property_value('request', []);

        $_GET['controller'] = 'controller';
        $_GET['method']     = 'method';
        $_GET['param1']     = 'param1';
        $_GET['param2']     = 'param2';
        $cache              = $_GET;
        $call               = 'controller/method';

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals($cache['controller'], $request['controller']);
        $this->assertEquals($cache['method'], $request['method']);
        $this->assertEquals($cache['param1'], $request['params'][0]);
        $this->assertEquals($cache['param2'], $request['params'][1]);
        $this->assertEquals($call, $request['call']);
    }

    /**
     * Test storing special $_GET values, if they are not present.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testStoreSpecialGetValuesIfNotSet()
    {
        $this->set_reflection_property_value('request', []);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';
        $call          = 'DefaultController/default_method';

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('DefaultController', $request['controller']);
        $this->assertEquals('default_method', $request['method']);
        $this->assertInternalType('array', $request['params']);
        $this->assertEmpty($request['params']);
        $this->assertEquals($call, $request['call']);
    }

    /**
     * Test storing special $_GET values, when they have superfluous slashes.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testStoreSpecialGetValuesWithMultipleSlashes()
    {
        $this->set_reflection_property_value('request', []);

        $_GET['controller'] = '/controller//';
        $_GET['method']     = '/method/';
        $_GET['param1']     = '/param1/';
        $_GET['param2']     = '//param2/';
        $call               = 'controller/method';

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertEquals('controller', $request['controller']);
        $this->assertEquals('method', $request['method']);
        $this->assertEquals('param1', $request['params'][0]);
        $this->assertEquals('param2', $request['params'][1]);
        $this->assertEquals($call, $request['call']);
    }

    /**
     * Test storing the call value if default values are not set.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testStoreCallIfDefaultsNotSet()
    {
        $this->set_reflection_property_value('request', []);

        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';

        $configuration = $this->getMock('Lunr\Core\Configuration');

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $configuration ]);

        $request = $this->get_reflection_property_value('request');

        $this->assertNull($request['call']);
    }

    /**
     * Test that $_GET is empty after storing.
     *
     * @covers Lunr\Corona\Request::store_get
     */
    public function testSuperglobalGetEmptyAfterStore()
    {
        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';

        $method = $this->get_accessible_reflection_method('store_get');
        $method->invokeArgs($this->class, [ $this->configuration ]);

        $this->assertArrayEmpty($_GET);
    }

}

?>
