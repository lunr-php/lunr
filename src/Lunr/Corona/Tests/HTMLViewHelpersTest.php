<?php

/**
 * This file contains the HTMLViewHelpersTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2012 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @covers     Lunr\Corona\HTMLView
 */
class HTMLViewHelpersTest extends HTMLViewTestCase
{

    /**
     * Test generating stylesheet include links for no stylesheets.
     *
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncluceStylesheetsWithNoStylesheets(): void
    {
        $this->setReflectionPropertyValue('stylesheets', []);

        $method = $this->getReflectionMethod('include_stylesheets');

        $this->assertSame('', $method->invoke($this->class));
    }

    /**
     * Test generating stylesheet include links for one stylesheet.
     *
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithOneStylesheet(): void
    {
        $this->setReflectionPropertyValue('stylesheets', [ 'style1.css' ]);

        $method = $this->getReflectionMethod('include_stylesheets');

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_1.html', $method->invoke($this->class));

        $this->unmockFunction('filemtime');
    }

    /**
     * Test generating stylesheet include links for multiple stylesheets.
     *
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithMultipleStylesheets(): void
    {
        $this->setReflectionPropertyValue('stylesheets', [ 'style2.css', 'style1.css' ]);

        $method = $this->getReflectionMethod('include_stylesheets');

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_2.html', $method->invoke($this->class));

        $this->unmockFunction('filemtime');
    }

    /**
     * Test generating stylesheet include links for external stylesheets.
     *
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithExternalStylesheets(): void
    {
        $stylesheets = [
            'http://www.website.com/style3.css',
            'https://www.website.com/style2.css',
            '//www.website.com/style1.css',
        ];

        $this->setReflectionPropertyValue('stylesheets', $stylesheets);

        $method = $this->getReflectionMethod('include_stylesheets');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('application_path')
                      ->willReturn('/full/path/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('base_path')
                      ->willReturn('/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('application_path')
                      ->willReturn('/full/path/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('base_path')
                      ->willReturn('/to/');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_external.html', $method->invoke($this->class));
    }

    /**
     * Test generating stylesheet include links for multiple sorted stylesheets.
     *
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithMultipleStylesheetsSorted(): void
    {
        $this->setReflectionPropertyValue('stylesheets', [ 'style2.css', 'style1.css' ]);

        $method = $this->getReflectionMethod('include_stylesheets');

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_3.html', $method->invokeArgs($this->class, [ TRUE ]));

        $this->unmockFunction('filemtime');
    }

    /**
     * Test generating javascript include links for no javascript files.
     *
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncluceJavascriptWithNoJSFiles(): void
    {
        $this->setReflectionPropertyValue('javascript', []);

        $method = $this->getReflectionMethod('include_javascript');

        $this->assertSame('', $method->invoke($this->class));
    }

    /**
     * Test generating javascript include links for one javascript file.
     *
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithOneJSFile(): void
    {
        $this->setReflectionPropertyValue('javascript', [ 'script1.js' ]);

        $method = $this->getReflectionMethod('include_javascript');

        $this->request->expects($this->exactly(2))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_1.html', $method->invoke($this->class));

        $this->unmockFunction('filemtime');
    }

    /**
     * Test generating javascript include links for multiple javascript files.
     *
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithMultipleJSFiles(): void
    {
        $this->setReflectionPropertyValue('javascript', [ 'script2.js', 'script1.js' ]);

        $method = $this->getReflectionMethod('include_javascript');

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_2.html', $method->invoke($this->class));

        $this->unmockFunction('filemtime');
    }

    /**
     * Test generating javascript include links for external javascript files.
     *
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithExternalJSFiles(): void
    {
        $javascript = [
            'http://www.website.com/script3.js',
            'https://www.website.com/script2.js',
            '//www.website.com/script1.js',
        ];

        $this->setReflectionPropertyValue('javascript', $javascript);

        $method = $this->getReflectionMethod('include_javascript');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('application_path')
                      ->willReturn('/full/path/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('base_path')
                      ->willReturn('/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('application_path')
                      ->willReturn('/full/path/to/');

        $this->request->expects($this->never())
                      ->method('__get')
                      ->with('base_path')
                      ->willReturn('/to/');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_external.html', $method->invoke($this->class));
    }

    /**
     * Test generating javascript include links for multiple sorted javascript files.
     *
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithMultipleJSFilesSorted(): void
    {
        $this->setReflectionPropertyValue('javascript', [ 'script2.js', 'script1.js' ]);

        $method = $this->getReflectionMethod('include_javascript');

        $this->request->expects($this->exactly(4))
                      ->method('__get')
                      ->willReturnMap([
                          [ 'application_path', '/full/path/to/' ],
                          [ 'base_path', '/to/' ],
                      ]);

        $this->mockFunction('filemtime', function () { return 1438183002; });

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_3.html', $method->invokeArgs($this->class, [ TRUE ]));

        $this->unmockFunction('filemtime');
    }

    /**
     * Tests the css_alternate method of the View class.
     *
     * @param string $basename         CSS rule basename
     * @param string $alternation_hint Hint on whether to use 'even' or 'odd'
     * @param string $suffix           Custom suffix instead of 'even' or 'odd'
     * @param string $result           Expected combined result
     *
     * @dataProvider cssAlternateProvider
     * @covers       Lunr\Corona\HTMLView::css_alternate
     */
    public function testCssAlternate($basename, $alternation_hint, $suffix, $result): void
    {
        $method = $this->getReflectionMethod('css_alternate');

        $this->assertEquals($result, $method->invokeArgs($this->class, [ $basename, $alternation_hint, $suffix ]));
    }

}

?>
