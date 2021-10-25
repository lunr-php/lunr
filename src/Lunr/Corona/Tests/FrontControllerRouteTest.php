<?php

/**
 * This file contains the FrontControllerRouteTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2015-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains tests for getting controllers from the FrontController class.
 *
 * @covers Lunr\Corona\FrontController
 */
class FrontControllerRouteTest extends FrontControllerTest
{

    /**
     * Test that route() returns an empty string for a blacklisted controller.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithBlacklistedController(): void
    {
        $this->set_reflection_property_value('routes', [ 'controller' => NULL ]);

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->will($this->returnValueMap([
                          [ 'call', 'controller/method' ],
                          [ 'controller', 'controller' ],
                      ]));

        $value = $this->class->route();

        $this->assertEquals('', $value);
    }

    /**
     * Test that route() returns an empty string for a blacklisted call.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithBlacklistedCall(): void
    {
        $this->set_reflection_property_value('routes', [ 'controller/method' => NULL ]);

        $this->request->expects($this->once())
                      ->method('__get')
                      ->with($this->equalTo('call'))
                      ->will($this->returnValue('controller/method'));

        $value = $this->class->route();

        $this->assertEquals('', $value);
    }

    /**
     * Test that route() returns the controller for a whitelisted call.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithWhitelistedCall(): void
    {
        $this->set_reflection_property_value('routes', [ 'function' => NULL, 'function/bar' => [] ]);
        $this->set_reflection_property_value('paths', [ 'test' => '/foo/bar', 'live' => '/foo/baz' ]);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $result = '/foo/baz/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(5))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->fao->expects($this->exactly(2))
                  ->method('find_matches')
                  ->withConsecutive(
                      [ '/^.+\/functioncontroller.php/i', '/foo/bar' ],
                      [ '/^.+\/functioncontroller.php/i', '/foo/baz' ]
                  )
                  ->willReturnOnConsecutiveCalls([], [ $result ]);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name for a restricted lookup path.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithRestrictedController(): void
    {
        $this->set_reflection_property_value('routes', [ 'function' => [ 'live' ] ]);
        $this->set_reflection_property_value('paths', [ 'test' => '/foo/bar', 'live' => '/foo/baz' ]);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $result = '/foo/baz/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->fao->expects($this->exactly(1))
                  ->method('find_matches')
                  ->withConsecutive(
                      [ '/^.+\/functioncontroller.php/i', '/foo/baz' ]
                  )
                  ->willReturnOnConsecutiveCalls([ $result ]);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name for a restricted lookup path.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithRestrictedCall(): void
    {
        $this->set_reflection_property_value('routes', [ 'function/bar' => [ 'live' ] ]);
        $this->set_reflection_property_value('paths', [ 'test' => '/foo/bar', 'live' => '/foo/baz' ]);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $result = '/foo/baz/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(3))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->fao->expects($this->exactly(1))
                  ->method('find_matches')
                  ->withConsecutive(
                      [ '/^.+\/functioncontroller.php/i', '/foo/baz' ]
                  )
                  ->willReturnOnConsecutiveCalls([ $result ]);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

    /**
     * Test that route() returns the controller name when there are no special rules.
     *
     * @covers Lunr\Corona\FrontController::route
     */
    public function testRouteWithNoRules(): void
    {
        $this->set_reflection_property_value('paths', [ 'test' => '/foo/bar', 'live' => '/foo/baz' ]);

        $map = [
            [ 'call', 'function/bar' ],
            [ 'controller', 'function' ],
        ];

        $result = '/foo/baz/Project/Package/FunctionController.php';
        $fqcn   = 'Project\\Package\\FunctionController';

        $this->request->expects($this->exactly(6))
                      ->method('__get')
                      ->will($this->returnValueMap($map));

        $this->fao->expects($this->exactly(2))
                  ->method('find_matches')
                  ->withConsecutive(
                      [ '/^.+\/functioncontroller.php/i', '/foo/bar' ],
                      [ '/^.+\/functioncontroller.php/i', '/foo/baz' ]
                  )
                  ->willReturnOnConsecutiveCalls([], [ $result ]);

        $value = $this->class->route();

        $this->assertEquals($fqcn, $value);
    }

}
