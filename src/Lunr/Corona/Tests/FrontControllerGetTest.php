<?php

/**
 * This file contains the FrontControllerGetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Corona\FrontController
 */
class FrontControllerGetTest extends FrontControllerTest
{

    /**
     * Test that get_controller() returns a FQCN.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsFQCNForExistingController()
    {
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array($result)));

        $this->response->expects($this->never())
                       ->method('__set');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns an emoty string if controller not found.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringForNonExistingController()
    {
        $dir = __DIR__;

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array()));

        $this->response->expects($this->at(0))
                       ->method('__set')
                       ->with('errmsg', 'Undefined controller');

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns an emoty string if finding caused error.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringIfFindFailed()
    {
        $dir = __DIR__;

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(FALSE));

        $this->response->expects($this->at(0))
                       ->method('__set')
                       ->with('errmsg', 'Undefined controller');

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() sets an error number if controller not found and enums are set.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerSetsErrorNumberIfPresentAndNonExistingController()
    {
        $ERROR['not_implemented'] = 503;

        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);
        $property->setValue($this->class, $ERROR);

        $dir = __DIR__;

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array()));

        $this->response->expects($this->at(0))
                       ->method('__set')
                       ->with('errmsg', 'Undefined controller');

        $this->response->expects($this->at(1))
                       ->method('__set')
                       ->with('return_code', 503);

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns the first result if more than one exists.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsFirstMatchIfMultipleFound()
    {
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array($result, 'nr2')));

        $this->response->expects($this->never())
                       ->method('__set');

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

}
