<?php

/**
 * This file contains the FrontControllerBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains base tests for the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerBaseTest extends FrontControllerTest
{

    /**
     * Test that the Request class was passed correctly.
     */
    public function testRequestPassedCorrectly()
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the FilesystemAccessObject class was passed correctly.
     */
    public function testFAOPassedCorrectly()
    {
        $this->assertPropertySame('fao', $this->fao);
    }

    /**
     * Test that register_lookup_path() registers the passed path
     *
     * @covers Lunr\Corona\FrontController::register_lookup_path
     */
    public function testRegisterLookupPath()
    {
        $property = $this->get_accessible_reflection_property('paths');

        $this->assertArrayEmpty($property->getValue($this->class));

        $this->class->register_lookup_path('test', '/path/to/tests/');

        $paths = $property->getValue($this->class);

        $this->assertArrayNotEmpty($paths);
        $this->assertArrayHasKey('test', $paths);
        $this->assertEquals('/path/to/tests/', $paths['test']);
    }

    /**
     * Test that add_routing_rule() adds a static routing rule
     *
     * @covers Lunr\Corona\FrontController::add_routing_rule
     */
    public function testAddRoutingRuleWithoutRoute()
    {
        $property = $this->get_accessible_reflection_property('routes');

        $this->assertArrayEmpty($property->getValue($this->class));

        $this->class->add_routing_rule('foo/bar');

        $routes = $property->getValue($this->class);

        $this->assertArrayNotEmpty($routes);
        $this->assertArrayHasKey('foo/bar', $routes);
        $this->assertArrayEmpty($routes['foo/bar']);
    }

    /**
     * Test that add_routing_rule() adds a static routing rule
     *
     * @covers Lunr\Corona\FrontController::add_routing_rule
     */
    public function testAddRoutingRuleWithRoute()
    {
        $property = $this->get_accessible_reflection_property('routes');

        $this->assertArrayEmpty($property->getValue($this->class));

        $this->class->add_routing_rule('foo/bar', [ 'baz' ]);

        $routes = $property->getValue($this->class);

        $this->assertArrayNotEmpty($routes);
        $this->assertArrayHasKey('foo/bar', $routes);
        $this->assertEquals([ 'baz' ], $routes['foo/bar']);
    }

}

?>
