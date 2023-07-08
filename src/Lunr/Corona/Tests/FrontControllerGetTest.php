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
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/functioncontroller.php/i', $dir)
                  ->willReturn([ $result ]);

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
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/functioncontroller.php/i', $dir)
                  ->willReturn([]);

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns an empty string if finding caused error.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringIfFindFailed(): void
    {
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/functioncontroller.php/i', $dir)
                  ->willReturn(FALSE);

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
        $dir = __DIR__;

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn(NULL);

        $this->fao->expects($this->never())
                  ->method('find_matches');

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
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/functioncontroller.php/i', $dir)
                  ->willReturn([ $result, 'nr2' ]);

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
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->never())
                  ->method('find_matches');

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
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->never())
                  ->method('find_matches');

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
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('function');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/functioncontroller.php/i', $dir)
                  ->willReturn([ $result ]);

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

        $this->fao->expects($this->never())
                  ->method('find_matches');

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
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/AnonymousTapsController.php';
        $fqcn   = 'Project\\Package\\AnonymousTapsController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->willReturn('anonymous-taps');

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+\/anonymoustapscontroller.php/i', $dir)
                  ->willReturn([ $result ]);

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

}

?>
