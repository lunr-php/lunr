<?php

/**
 * This file contains the FrontControllerGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @covers     Lunr\Corona\FrontController
 */
class FrontControllerGetTest extends FrontControllerTest
{

    /**
     * Test that get_controller() returns a FQCN.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns an empty string if controller not found.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringForNonExistingController(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('method');

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns an empty string if there is no controller info available.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringIfNoControllerInfoAvailable(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn(NULL);

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns the first result if more than one exists.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsFirstMatchIfMultipleFound(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package2\\FooController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('foo');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns an empty string if the controller to find is blacklisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetBlacklistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [ 'function' ]);

        $this->assertSame('', $value);
    }

    /**
     * Test that get_controller() returns an empty string if the controller to find is not whitelisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetNotWhitelistedControllerReturnsEmptyString(): void
    {
        $dir = TEST_STATICS . '/Corona/';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [], FALSE);

        $this->assertSame('', $value);
    }

    /**
     * Test that get_controller() returns a FQCN if the controller to find is whitelisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetWhitelistedControllerReturnsFQCNForExistingController(): void
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $value = $this->class->get_controller($dir, [ 'function' ], FALSE);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns '' for invalid controller.
     *
     * @param array $controller_name Invalid controller names
     *
     * @dataProvider invalidControllerNameValuesProvider
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsDefault($controller_name): void
    {
        $dir = 'src';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn($controller_name);

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns a FQCN for dashes in the controller
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerForDashesInController()
    {
        $dir  = TEST_STATICS . '/Corona/';
        $fqcn = 'Project\\Package1\\AnonymousTapsController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('anonymous-taps');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

}

?>
