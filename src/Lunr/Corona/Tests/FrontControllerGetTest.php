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
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
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

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array($result)));

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

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array()));

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns an empty string if finding caused error.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringIfFindFailed()
    {
        $dir = __DIR__;

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(FALSE));

        $value = $this->class->get_controller($dir);

        $this->assertEquals('', $value);
    }

    /**
     * Test that get_controller() returns an empty string if there is no controller info available.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetControllerReturnsEmptyStringIfNoControllerInfoAvailable()
    {
        $dir = __DIR__;

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue(NULL));

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
    public function testGetControllerReturnsFirstMatchIfMultipleFound()
    {
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array($result, 'nr2')));

        $value = $this->class->get_controller($dir);

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that get_controller() returns an empty string if the controller to find is blacklisted.
     *
     * @covers Lunr\Corona\FrontController::get_controller
     */
    public function testGetBlacklistedControllerReturnsEmptyString()
    {
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

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
    public function testGetNotWhitelistedControllerReturnsEmptyString()
    {
        $dir = __DIR__;

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

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
    public function testGetWhitelistedControllerReturnsFQCNForExistingController()
    {
        $dir    = __DIR__;
        $result = __DIR__ . '/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->with('controller')
                      ->will($this->returnValue('function'));

        $this->fao->expects($this->once())
                  ->method('find_matches')
                  ->with('/^.+functioncontroller.php/i', $dir)
                  ->will($this->returnValue(array($result)));

        $value = $this->class->get_controller($dir, [ 'function' ], FALSE);

        $this->assertEquals($fqcn, $value);
    }

}
