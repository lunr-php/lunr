<?php

/**
 * This file contains the ControllerResultTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\HttpCode;

/**
 * This class contains test methods for the Controller class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\Controller
 */
class ControllerResultTest extends ControllerTest
{

    /**
     * Test calling unimplemented methods with error enums set.
     *
     * @covers Lunr\Corona\Controller::__call
     */
    public function testNonImplementedCall()
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with($this->equalTo('controller/method'), $this->equalTo('Not implemented!'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $this->class->unimplemented();
    }

    /**
     * Test setting a result return code with error enums set.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testSetResultReturnCode()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result without error message.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testSetResultErrorMessageNull()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $this->response->expects($this->never())
                       ->method('set_error_message');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting a result error message.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testSetResultErrorMessage()
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $this->response->expects($this->once())
                       ->method('set_error_message')
                       ->with($this->equalTo('controller/method'), $this->equalTo('errmsg'));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, 'errmsg' ]);
    }

    /**
     * Test setting a result without error information.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testSetResultErrorInfoNull()
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $this->response->expects($this->never())
                       ->method('set_error_info');

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED ]);
    }

    /**
     * Test setting result error information.
     *
     * @covers Lunr\Corona\Controller::set_result
     */
    public function testSetResultErrorInfoNotNull()
    {
        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $this->response->expects($this->once())
                       ->method('set_return_code')
                       ->with($this->equalTo('controller/method'), $this->equalTo(HttpCode::NOT_IMPLEMENTED));

        $this->response->expects($this->once())
                       ->method('set_error_info')
                       ->with($this->equalTo('controller/method'), $this->equalTo('errinfo'));

        $method = $this->get_accessible_reflection_method('set_result');

        $method->invokeArgs($this->class, [ HttpCode::NOT_IMPLEMENTED, NULL, 'errinfo' ]);
    }

}

?>
