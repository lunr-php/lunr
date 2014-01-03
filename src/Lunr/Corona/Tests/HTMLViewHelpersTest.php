<?php

/**
 * This file contains the HTMLViewHelpersTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * This class tests the helper methods of the view class.
 *
 * @category   Libraries
 * @package    Corona
 * @subpackage Tests
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
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
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithOneStylesheet()
    {
        $this->set_reflection_property_value('stylesheets', [ 'style1.css' ]);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_1.html', $method->invoke($this->class));
    }

    /**
     * Test generating stylesheet include links for multiple stylesheets.
     *
     * @covers Lunr\Corona\HTMLView::include_stylesheets
     */
    public function testIncludeStylesheetsWithMultipleStylesheets()
    {
        $this->set_reflection_property_value('stylesheets', [ 'style1.css', 'style2.css' ]);

        $method = $this->get_accessible_reflection_method('include_stylesheets');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/stylesheet_2.html', $method->invoke($this->class));
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
     * @covers Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithOneJSFile()
    {
        $this->set_reflection_property_value('javascript', [ 'script1.js' ]);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_1.html', $method->invoke($this->class));
    }

    /**
     * Test generating javascript include links for multiple javascript files.
     *
     * @covers Lunr\Corona\HTMLView::include_javascript
     */
    public function testIncludeJavascriptWithMultipleJSFiles()
    {
        $this->set_reflection_property_value('javascript', [ 'script1.js', 'script2.js' ]);

        $method = $this->get_accessible_reflection_method('include_javascript');

        $this->assertStringEqualsFile(TEST_STATICS . '/Corona/javascript_2.html', $method->invoke($this->class));
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
