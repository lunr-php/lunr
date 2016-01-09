<?php

/**
 * This file contains the HTMLViewHelpersTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2016, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @covers     Lunr\Corona\HTMLView
 */
class HTMLViewHelpersTest extends HTMLViewTest
{

    /**
     * Test generating stylesheet include links for no stylesheets.
     *
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncluceStylesheetsWithNoStylesheets()
    {
        $this->set_reflection_property_value('stylesheets', []);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->assertSame('', $method->invoke($this->class));
    }

    /**
     * Test generating stylesheet include links for one stylesheet.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithOneStylesheet()
    {
        $this->set_reflection_property_value('stylesheets', [ 'style1.css' ]);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_1.html', $method->invoke($this->class));

        $this->unmock_function('filemtime');
    }

    /**
     * Test generating stylesheet include links for multiple stylesheets.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithMultipleStylesheets()
    {
        $this->set_reflection_property_value('stylesheets', [ 'style2.css', 'style1.css' ]);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->request->expects($this->at(2))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(3))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_2.html', $method->invoke($this->class));

        $this->unmock_function('filemtime');
    }

    /**
     * Test generating stylesheet include links for multiple sorted stylesheets.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithMultipleStylesheetsSorted()
    {
        $this->set_reflection_property_value('stylesheets', [ 'style2.css', 'style1.css' ]);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->request->expects($this->at(2))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(3))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_3.html', $method->invokeArgs($this->class, [ TRUE ]));

        $this->unmock_function('filemtime');
    }

    /**
     * Test generating javascript include links for no javascript files.
     *
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncluceJavascriptWithNoJSFiles()
    {
        $this->set_reflection_property_value('javascript', []);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->assertSame('', $method->invoke($this->class));
    }

    /**
     * Test generating javascript include links for one javascript file.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithOneJSFile()
    {
        $this->set_reflection_property_value('javascript', [ 'script1.js' ]);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_1.html', $method->invoke($this->class));

        $this->unmock_function('filemtime');
    }

    /**
     * Test generating javascript include links for multiple javascript files.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithMultipleJSFiles()
    {
        $this->set_reflection_property_value('javascript', [ 'script2.js', 'script1.js' ]);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->request->expects($this->at(2))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(3))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_2.html', $method->invoke($this->class));

        $this->unmock_function('filemtime');
    }

    /**
     * Test generating javascript include links for multiple sorted javascript files.
     *
     * @requires extension runkit
     * @covers   Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithMultipleJSFilesSorted()
    {
        $this->set_reflection_property_value('javascript', [ 'script2.js', 'script1.js' ]);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->request->expects($this->at(0))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(1))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->request->expects($this->at(2))
                      ->method('__get')
                      ->with($this->equalTo('application_path'))
                      ->will($this->returnValue('/full/path/to/'));

        $this->request->expects($this->at(3))
                      ->method('__get')
                      ->with($this->equalTo('base_path'))
                      ->will($this->returnValue('/to/'));

        $this->mock_function('filemtime', 'return 1438183002;');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_3.html', $method->invokeArgs($this->class, [ TRUE ]));

        $this->unmock_function('filemtime');
    }

    /**
     * Tests the css_alternate method of the View class.
     *
     * @param String $basename         css rule basename
     * @param String $alternation_hint hint on whether to use 'even' or 'odd'
     * @param String $suffix           custom suffix instead of 'even' or 'odd'
     * @param String $result           expected combined result
     *
     * @dataProvider cssAlternateProvider
     * @covers       Lunr\Corona\HTMLView::css_alternate
     */
    public function testCssAlternate($basename, $alternation_hint, $suffix, $result)
    {
        $method = $this->get_accessible_reflection_method('css_alternate');

        $this->assertEquals($result, $method->invokeArgs($this->class, [ $basename, $alternation_hint, $suffix ]));
    }

}

?>
