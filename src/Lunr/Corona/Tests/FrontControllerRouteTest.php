<?php

/**
 * This file contains the FrontControllerRouteTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerRouteTest extends FrontControllerTest
{

    /**
     * Test that route() returns an empty string for a blacklisted controller.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithBlacklistedController(): void
    {
        $this->set_reflection_property_value('routes', [ 'controller' => NULL ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'call', 'controller/method' ],
                          [ 'controller', 'controller' ],
                      ]);

        $value = $this->class->route();

        $this->assertEquals('', $value);
    }

    /**
     * Test that route() returns an empty string for a blacklisted call.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithBlacklistedCall(): void
    {
        $this->set_reflection_property_value('routes', [ 'controller/method' => NULL ]);

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $value = $this->class->route();

        $this->assertEquals('', $value);
    }

    /**
     * Test that route() returns the controller for a whitelisted call.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithWhitelistedCall(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../support/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('routes', [ 'function' => NULL, 'function/bar' => [] ]);
        $this->set_reflection_property_value('paths', $paths);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(7))
                      ->method('__get')
                      ->willReturnMap($map);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name for a restricted lookup path.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithRestrictedController(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../support/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('routes', [ 'front' => [ 'live' ] ]);
        $this->set_reflection_property_value('paths', $paths);

        $map = [
            [ 'call', 'front/bar' ],
            [ 'controller', 'front' ],
        ];

        $fqcn = 'FrontController';

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->willReturnMap($map);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name for a restricted lookup path.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithRestrictedCall(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../support/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('routes', [ 'front/bar' => [ 'live' ] ]);
        $this->set_reflection_property_value('paths', $paths);

        $map = [
            [ 'call', 'front/bar' ],
            [ 'controller', 'front' ],
        ];

        $fqcn = 'FrontController';

        $this->request->expects($this->exactly(3))
                      ->method('__get')
                      ->willReturnMap($map);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name when there are no special rules.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithNoRules(): void
    {
        $paths = [
            'live' => TEST_STATICS . '/../../src/Lunr/Corona/',
            'acc'  => TEST_STATICS . '/../../support/',
            'test' => TEST_STATICS . '/Corona/',
        ];

        $this->set_reflection_property_value('paths', $paths);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(8))
                      ->method('__get')
                      ->willReturnMap($map);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

}

?>
