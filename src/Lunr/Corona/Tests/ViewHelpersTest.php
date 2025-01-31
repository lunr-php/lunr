<?php

/**
 * This file contains the ViewHelpersTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @covers     Lunr\Corona\View
 */
class ViewHelpersTest extends ViewTestCase
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
                      ->willReturn($baseurl);

        $method = $this->getReflectionMethod('base_url');

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
                      ->willReturn($base);
        $this->sub_configuration->expects($this->once())
                                ->method('offsetGet')
                                ->willReturn($statics);

        $method = $this->getReflectionMethod('statics');

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
        $method = $this->getReflectionMethod('is_fatal_error');

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
        $method = $this->getReflectionMethod('is_fatal_error');

        $this->assertFalse($method->invokeArgs($this->class, [ $error ]));
    }

}

?>
