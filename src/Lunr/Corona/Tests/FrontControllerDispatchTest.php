<?php

/**
 * This file contains the FrontControllerDispatchTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
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
    public function testDispatchWithInstantiatedController()
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')->getMock();

        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $controller, 'foo' ], [ 1, 2 ]);

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('method')
                      ->willReturn('foo');

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with('params')
                      ->willReturn([ 1, 2 ]);

        $this->class->dispatch($controller);
    }

    /**
     * Test that dispatch works correctly with a controller name as string.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithControllerAsString()
    {
        $controller = 'Lunr\Corona\Tests\MockController';

        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $controller, 'bar'], [ 1, 2 ]);

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('method')
                      ->willReturn('bar');

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with('params')
                      ->willReturn([ 1, 2 ]);

        $this->class->dispatch($controller);
    }

    /**
     * Test that dispatch behaves well with a non-existant controller.
     *
     * @covers Lunr\Corona\FrontController::dispatch
     */
    public function testDispatchWithNonExistantController()
    {
        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ 'String', 'bar' ], [ 1, 2 ]);

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('method')
                      ->willReturn('bar');

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with('params')
                      ->willReturn([ 1, 2 ]);

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
    public function testDispatchWithInvalidControllerValues($value)
    {
        $this->handler->expects($this->once())
                      ->method('handle_request')
                      ->with([ $value, 'bar' ], [ 1, 2 ]);

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('method')
                      ->willReturn('bar');

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with('params')
                      ->willReturn([ 1, 2 ]);

        $this->class->dispatch($value);
    }

}
