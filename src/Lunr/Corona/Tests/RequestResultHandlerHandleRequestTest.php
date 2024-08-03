<?php

/**
 * This file contains the RequestResultHandlerHandleRequestTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2018 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Error;
use Exception;
use Lunr\Corona\Exceptions\BadRequestException;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerHandleRequestTest extends RequestResultHandlerTest
{

    /**
     * Test that handle_request works correctly with an already instantiated controller.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithInstantiatedController(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')->getMock();

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 200);

        $controller->expects($this->once())
                   ->method('foo')
                   ->with(1, 2);

        $this->class->handle_request([ $controller, 'foo' ], [ 1, 2 ]);
    }

    /**
     * Test that handle_request works correctly with a controller name as string.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithControllerAsString(): void
    {
        $controller = 'Lunr\Corona\Tests\MockController';

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 200);

        $this->class->handle_request([ $controller, 'bar' ], [ 1, 2 ]);
    }

    /**
     * Test that handle_request behaves well with a non-existent controller.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithNonExistentController(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(500);

        if (PHP_VERSION_ID > 80000)
        {
            $message  = 'call_user_func_array(): Argument #1 ($callback) must be a valid callback, ';
            $message .= 'class "String" not found';
        }
        else
        {
            $message  = 'call_user_func_array() expects parameter 1 to be a valid callback, ';
            $message .= "class 'String' not found";
        }

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', $message);

        $this->class->handle_request([ 'String', 'bar' ], []);
    }

    /**
     * Test that handle_request behaves well with invalid controller values.
     *
     * @param mixed $value Invalid controller name.
     *
     * @dataProvider invalidControllerNameProvider
     * @covers       Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithInvalidControllerValues($value): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(500);

        if (PHP_VERSION_ID > 80000)
        {
            $message  = 'call_user_func_array(): Argument #1 ($callback) must be a valid callback, ';
            $message .= 'first array member is not a valid class name or object';
        }
        else
        {
            $message  = 'call_user_func_array() expects parameter 1 to be a valid callback, ';
            $message .= 'first array member is not a valid class name or object';
        }

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', $message);

        $this->class->handle_request([ $value, 'bar' ], []);
    }

    /**
     * Test handle_request() with an HttpException.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithHttpException(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException(new BadRequestException('Bad Request!')));

        $this->request->expects($this->exactly(3))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 400);

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(400);

        $message = 'Bad Request!';

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', $message);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() with an Exception.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithException(): void
    {
        $exception = new Exception('Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(500);

        $message = 'Error!';

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() with an Error.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithError(): void
    {
        $exception = new Error('Fatal Error!');

        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo')
                   ->will($this->throwException($exception));

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 500);

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(500);

        $message = 'Fatal Error!';

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', $message);

        $this->logger->expects($this->once())
                     ->method('error')
                     ->with($message, [ 'exception' => $exception ]);

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

    /**
     * Test handle_request() when the request was successful.
     *
     * @covers Lunr\Corona\RequestResultHandler::handle_request
     */
    public function testHandleRequestWithSuccess(): void
    {
        $controller = $this->getMockBuilder('Lunr\Corona\Tests\MockController')
                           ->getMock();

        $controller->expects($this->once())
                   ->method('foo');

        $this->request->expects($this->exactly(1))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->exactly(1))
                       ->method('get_return_code')
                       ->willReturn(NULL);

        $this->response->expects($this->exactly(1))
                       ->method('set_return_code')
                       ->with('controller/method', 200);

        $this->response->expects($this->never())
                       ->method('set_error_message');

        $this->class->handle_request([ $controller, 'foo' ], []);
    }

}

?>
