<?php

/**
 * This file contains the CliRequestStoreRequestTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains test methods for the CliRequest class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\CliRequest
 */
class CliRequestStoreRequestTest extends CliRequestTest
{

    /**
     * Test that store_request() checks the AST for request values.
     *
     * @param String $request_value The request value
     * @param String $key           The command line parameter name
     * @param mixed  $value         The paramter value
     *
     * @dataProvider astRequestValueProvider
     * @covers       Lunr\Shadow\CliRequest::store_request
     */
    public function testStoreRequestParsesAstForRequestValues($request_value, $key, $value)
    {
        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->get_accessible_reflection_method('store_request')->invoke($this->class);

        $property = $this->get_reflection_property_value('request');
        $check    = ($request_value === 'params') ? $value : $value[0];

        $this->assertArrayHasKey($request_value, $property);
        $this->assertSame($check, $property[$request_value]);
    }

    /**
     * Test that store_request() unsets request values in the AST.
     *
     * @param String $request_value The request value
     * @param String $key           The command line parameter name
     * @param mixed  $value         The paramter value
     *
     * @dataProvider astRequestValueProvider
     * @covers       Lunr\Shadow\CliRequest::store_request
     */
    public function testStoreRequestUnsetsRequestValuesInAst($request_value, $key, $value)
    {
        $this->set_reflection_property_value('ast', [ $key => $value ]);

        $this->get_accessible_reflection_method('store_request')->invoke($this->class);

        $property = $this->get_reflection_property_value('ast');

        $this->assertArrayNotHasKey($request_value, $property);
    }

    /**
     * Test that store_request() checks the AST for superglobal values.
     *
     * @param String $key      The command line parameter name
     * @param String $value    The paramter value
     * @param array  $expected The expected parsed superglobal value
     *
     * @dataProvider astSuperglobalValueProvider
     * @covers       Lunr\Shadow\CliRequest::store_request
     */
    public function testStoreRequestParsesAstForSuperglobals($key, $value, $expected)
    {
        $this->set_reflection_property_value('ast', [ $key => [ $value ] ]);

        $this->get_accessible_reflection_method('store_request')->invoke($this->class);

        $this->assertPropertySame($key, $expected);
    }

    /**
     * Test that store_request() unsets superglobal values in the AST.
     *
     * @param String $key      The command line parameter name
     * @param String $value    The paramter value
     * @param array  $expected The expected parsed superglobal value
     *
     * @dataProvider astSuperglobalValueProvider
     * @covers       Lunr\Shadow\CliRequest::store_request
     */
    public function testStoreRequestUnsetsSuperglobalValuesInAst($key, $value, $expected)
    {
        $this->set_reflection_property_value('ast', [ $key => [ $value ] ]);

        $this->get_accessible_reflection_method('store_request')->invoke($this->class);

        $property = $this->get_reflection_property_value('ast');

        $this->assertArrayNotHasKey($key, $property);
    }

    /**
     * Test that store_request() constructs the 'call' value correctly.
     *
     * @param String $controller Controller name
     * @param String $method     Method name
     * @param String $value      Expected call value
     *
     * @dataProvider callValueProvider
     * @covers       Lunr\Shadow\CliRequest::store_request
     */
    public function testStoreRequestConstructsCallCorrectly($controller, $method, $value)
    {
        $this->set_reflection_property_value('request', [ 'controller' => $controller, 'method' => $method ]);

        $this->get_accessible_reflection_method('store_request')->invoke($this->class);

        $this->assertSame($value, $this->get_reflection_property_value('request')['call']);
    }

}

?>
