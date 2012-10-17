<?php

/**
 * This file contains the ControllerTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This class contains test methods for the Controller class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Controller
 */
class ControllerTest extends PHPUnit_Framework_TestCase
{

    /**
     * Mock instance of the response class.
     * @var Response
     */
    private $response;

    /**
     * Instance of the controller class.
     * @var Controller
     */
    private $controller;

    /**
     * Reflection instance of the controller class.
     * @var ReflectionClass
     */
    private $controller_reflection;

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->response = $this->getMock('Lunr\Libraries\Core\Response');

        $this->controller = $this->getMockBuilder('Lunr\Libraries\Core\Controller')
                                 ->setConstructorArgs(array(&$this->response))
                                 ->getMockForAbstractClass();

        $this->controller_reflection = new ReflectionClass('Lunr\Libraries\Core\Controller');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->response);
        unset($this->controller);
        unset($this->controller_reflection);
    }

    /**
     * Test that there are no error enums set by default.
     */
    public function testErrorEmptyByDefault()
    {
        $property = $this->controller_reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->controller);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the response class is set correctly.
     */
    public function testResponseSetCorrectly()
    {
        $property = $this->controller_reflection->getProperty('response');
        $property->setAccessible(TRUE);

        $this->assertEquals($this->response, $property->getValue($this->controller));
        $this->assertSame($this->response, $property->getValue($this->controller));
    }

    /**
     * Test calling unimplemented methods without error enums set.
     *
     * @depends testErrorEmptyByDefault
     * @covers  Lunr\Libraries\Core\Controller::__call
     */
    public function testNonImplementedCallWithoutEnumsSet()
    {
        $this->response->expects($this->once())
                       ->method('__set')
                       ->with($this->equalTo('errmsg'));

        $this->controller->unimplemented();
    }

    /**
     * Test setting error enums.
     *
     * @covers Lunr\Libraries\Core\Controller::set_error_enums
     */
    public function testSetErrorEnums()
    {
        $ERROR['not_implemented'] = 503;

        $this->controller->set_error_enums($ERROR);

        $property = $this->controller_reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->controller);

        $this->assertEquals($ERROR, $value);
        $this->assertSame($ERROR, $value);
    }

    /**
     * Test calling unimplemented methods with error enums set.
     *
     * @depends testSetErrorEnums
     * @covers  Lunr\Libraries\Core\Controller::__call
     */
    public function testNonImplementedCallWithEnumsSet()
    {
        $this->response->expects($this->at(0))
                       ->method('__set')
                       ->with($this->equalTo('return_code'));

        $this->response->expects($this->at(1))
                       ->method('__set')
                       ->with($this->equalTo('errmsg'));

        $ERROR['not_implemented'] = 503;

        $this->controller->set_error_enums($ERROR);

        $this->controller->unimplemented();
    }

}

?>
