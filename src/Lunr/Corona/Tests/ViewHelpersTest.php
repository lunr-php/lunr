<?php

/**
 * This file contains the ViewHelpersTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @covers     Lunr\Corona\View
 */
class ViewHelpersTest extends ViewTest
{

    /**
     * Tests the base_url method of the View class.
     *
     * @param string $baseurl Baseurl value
     * @param string $path    Path to append to the baseurl
     * @param string $result  Expected combined result
     *
     * @dataProvider baseUrlProvider
     * @covers       Lunr\Corona\View::base_url
     */
    public function testBaseUrl($baseurl, $path, $result): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->will($this->returnValue($baseurl));

        $method = $this->get_accessible_reflection_method('base_url');

        $this->assertEquals($result, $method->invokeArgs($this->class, [ $path ]));
    }

    /**
     * Tests the statics method of the View class.
     *
     * @param string $base    Basepath value
     * @param string $statics Path to statics
     * @param string $path    Path to append to the statics path
     * @param string $result  Expected combined result
     *
     * @dataProvider staticsProvider
     * @covers       Lunr\Corona\View::statics
     */
    public function testStatics($base, $statics, $path, $result): void
    {
        $this->request->expects($this->once())
                      ->method('__get')
                      ->will($this->returnValue($base));
        $this->sub_configuration->expects($this->once())
                                ->method('offsetGet')
                                ->will($this->returnValue($statics));

        $method = $this->get_accessible_reflection_method('statics');

        $this->assertEquals($result, $method->invokeArgs($this->class, [ $path ]));
    }

    /**
     * Test that is_fatal_error() returns TRUE if last error is fatal.
     *
     * @param array $error Mocked error information
     *
     * @dataProvider fatalErrorInfoProvider
     * @covers       Lunr\Corona\View::is_fatal_error
     */
    public function testIsFatalErrorReturnsTrueIfErrorIsFatal($error): void
    {
        $method = $this->get_accessible_reflection_method('is_fatal_error');

        $this->assertTrue($method->invokeArgs($this->class, [ $error ]));
    }

    /**
     * Test that is_fatal_error() returns FALSE if last error is fatal.
     *
     * @param array $error Mocked error information
     *
     * @dataProvider errorInfoProvider
     * @covers       Lunr\Corona\View::is_fatal_error
     */
    public function testIsFatalErrorReturnsFalseIfErrorIsNotFatal($error): void
    {
        $method = $this->get_accessible_reflection_method('is_fatal_error');

        $this->assertFalse($method->invokeArgs($this->class, [ $error ]));
    }

}

?>
