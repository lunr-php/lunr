<?php

/**
 * This file contains the RequestResultHandlerSetResultTest class.
 *
 * @package   Lunr\Corona
 * @author    Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright 2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license   http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpCode;

/**
 * This class contains test methods for the RequestResultHandler class.
 *
 * @covers Lunr\Corona\RequestResultHandler
 */
class RequestResultHandlerSetResultTest extends RequestResultHandlerTest
{

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Corona\RequestResultHandler::set_result
     */
    public function testSetResultReturnCode(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Corona\RequestResultHandler::set_result
     */
    public function testSetResultErrorMessageNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->never())
                       ->method('set_error_message');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Corona\RequestResultHandler::set_result
     */
    public function testSetResultErrorMessage(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with('controller/method', 'errmsg');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, 'errmsg' ]);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Corona\RequestResultHandler::set_result
     */
    public function testSetResultErrorInfoNull(): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->never())
                       ->method('set_error_info');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Corona\RequestResultHandler::set_result
     */
    public function testSetResultErrorInfoNotNull(): void
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('call')
                      ->willReturn('controller/method');

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with('controller/method', HttpCode::NOT_IMPLEMENTED);

        $this->response->expects($this->once())
                       ->method('set_error_info')
                       ->with('controller/method', 9999);

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, NULL, 9999 ]);
    }

}

?>
