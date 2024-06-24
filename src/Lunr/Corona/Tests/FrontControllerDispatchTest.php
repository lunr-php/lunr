<?php

/**
 * This file contains the FrontControllerDispatchTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2013 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for dispatching controllers with the FrontController class.
 *
 * @covers     Lunr\Corona\FrontController
 */
class FrontControllerDispatchTest extends FrontControllerTest
{

    /**
     * Test that dispatch works correctly with an already instantiated controller.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithInstantiatedController(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->disableOriginalConstructor()
                           ->getMock();

        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $controller, 'foo' ], [ 1, 2 ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'method', 'foo' ],
                          [ 'params', [ 1, 2 ]],
                      ]);

        $this->class->dispatch($controller);
    }

    /**
     * Test that dispatch works correctly with a controller name as string.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithControllerAsString(): void
    {
        $controller = 'Lunr\Corona\Tests\MockController';

        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $controller, 'bar' ], [ 1, 2 ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'method', 'bar' ],
                          [ 'params', [ 1, 2 ]],
                      ]);

        $this->class->dispatch($controller);
    }

    /**
     * Test that dispatch behaves well with a non-existent controller.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithNonExistentController(): void
    {
        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ 'String', 'bar' ], [ 1, 2 ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'method', 'bar' ],
                          [ 'params', [ 1, 2 ]],
                      ]);

        $this->class->dispatch('String');
    }

    /**
     * Test that dispatch behaves well with invalid controller values.
     *
     * @param mixed $value Invalid controller name.
     *
     * @dataProvider invalidControllerNameProvider
     * @covers       Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithInvalidControllerValues($value): void
    {
        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $value, 'bar' ], [ 1, 2 ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'method', 'bar' ],
                          [ 'params', [ 1, 2 ]],
                      ]);

        $this->class->dispatch($value);
    }

}

?>
