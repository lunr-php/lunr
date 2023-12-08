<?php

/**
 * This file contains the FrontControllerBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testRequestPassedCorrectly(): void
    {
        $this->assertPropertySame('request', $this->request);
    }

    /**
     * Test that the RequestResultHandler class was passed correctly.
     */
    public function testRequestResultHandlerPassedCorrectly(): void
    {
        $this->assertPropertySame('handler', $this->handler);
    }

    /**
     * Test that register_lookup_path() registers the passed path
     *
     * @covers Lunr\Corona\FrontController::register_lookup_path
     */
    public function testRegisterLookupPath(): void
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
    public function testAddRoutingRuleWithoutRoute(): void
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
    public function testAddRoutingRuleWithRoute(): void
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
