<?php

/**
 * This file contains the PaginationHTMLTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Surface\Tests;

/**
 * This class contains the tests for the Pagination class.
 *
 * @category   Libraries
 * @package    Surface
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Surface\Pagination
 */
class PaginationHTMLTest extends PaginationTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpWithCursor();
    }

    /**
     * Tets that build_page_buttons() returns an empty string if amount is less than 1.
     *
     * @covers Lunr\Surface\Pagination::build_page_buttons
     */
    public function testBuildPageButtonsReturnsEmptyStringIfAmountLessThan1()
    {
        $method = $this->get_accessible_reflection_method('build_page_buttons');
        $this->assertEquals('', $method->invokeArgs($this->class, [0, TRUE]));
    }

    /**
     * Test building the buttons before the cursor.
     *
     * @covers Lunr\Surface\Pagination::build_page_buttons
     */
    public function testBuildPreviousButtons()
    {
        $file   = TEST_STATICS . '/Surface/pagination_buttons_previous.html';
        $method = $this->get_accessible_reflection_method('build_page_buttons');
        $this->assertStringMatchesFormatFile($file, $method->invokeArgs($this->class, [2, TRUE]));
    }

    /**
     * Test building the buttons after the cursor.
     *
     * @covers Lunr\Surface\Pagination::build_page_buttons
     */
    public function testBuildNextButtons()
    {
        $file   = TEST_STATICS . '/Surface/pagination_buttons_next.html';
        $method = $this->get_accessible_reflection_method('build_page_buttons');
        $this->assertStringMatchesFormatFile($file, $method->invokeArgs($this->class, [2, FALSE]));
    }

    /**
     * Test building enabled navigation buttons.
     *
     * @param mixed $button Button ID
     *
     * @dataProvider validButtonProvider
     * @covers       Lunr\Surface\Pagination::build_button
     */
    public function testBuildButtonEnabled($button)
    {
        $file   = TEST_STATICS . '/Surface/pagination_button_' . $button . '_enabled.html';
        $method = $this->get_accessible_reflection_method('build_button');
        $this->assertStringMatchesFormatFile($file, $method->invokeArgs($this->class, [$button, 1]));
    }

    /**
     * Test building disabled navigation buttons.
     *
     * @param mixed $button Button ID
     *
     * @dataProvider validButtonProvider
     * @covers       Lunr\Surface\Pagination::build_button
     */
    public function testBuildButtonDisabled($button)
    {
        $value = $this->get_reflection_property_value('buttons');

        $value[$button]['enabled'] = FALSE;

        $this->set_reflection_property_value('buttons', $value);

        $file   = TEST_STATICS . '/Surface/pagination_button_' . $button . '_disabled.html';
        $method = $this->get_accessible_reflection_method('build_button');
        $this->assertStringMatchesFormatFile($file, $method->invokeArgs($this->class, [$button, 1]));
    }

    /**
     * Test that create_links() returns FALSE if the total number of items was not specified.
     *
     * @covers Lunr\Surface\Pagination::create_links
     */
    public function testCreateLinksReturnsFalseIfTotalNotSet()
    {
        $this->assertFalse($this->class->create_links());
    }

    /**
     * Test creating links with an invalid cursor position.
     *
     * @covers Lunr\Surface\Pagination::create_links
     */
    public function testCreateLinksWithCursorHigherThanPageTotal()
    {
        $this->set_reflection_property_value('cursor', 11);
        $this->set_reflection_property_value('total', 100);
        $this->set_reflection_property_value('per_page', 10);

        $file = TEST_STATICS . '/Surface/pagination_links_right_edge.html';
        $this->assertStringMatchesFormatFile($file, $this->class->create_links());
    }

    /**
     * Test creating links with the cursor in the middle.
     *
     * @covers Lunr\Surface\Pagination::create_links
     */
    public function testCreateLinksWithCursorInTheMiddle()
    {
        $this->set_reflection_property_value('cursor', 5);
        $this->set_reflection_property_value('total', 100);
        $this->set_reflection_property_value('per_page', 10);

        $file = TEST_STATICS . '/Surface/pagination_links_middle.html';
        $this->assertStringMatchesFormatFile($file, $this->class->create_links());
    }

    /**
     * Test creating links with the cursor on the first page.
     *
     * @covers Lunr\Surface\Pagination::create_links
     */
    public function testCreateLinksWithCursorOnLeftEdge()
    {
        $this->set_reflection_property_value('cursor', 1);
        $this->set_reflection_property_value('total', 100);
        $this->set_reflection_property_value('per_page', 10);

        $file = TEST_STATICS . '/Surface/pagination_links_left_edge.html';
        $this->assertStringMatchesFormatFile($file, $this->class->create_links());
    }

    /**
     * Test creating links with the cursor on the last page.
     *
     * @covers Lunr\Surface\Pagination::create_links
     */
    public function testCreateLinksWithCursorOnRightEdge()
    {
        $this->set_reflection_property_value('total', 100);
        $this->set_reflection_property_value('per_page', 10);

        $file = TEST_STATICS . '/Surface/pagination_links_right_edge.html';
        $this->assertStringMatchesFormatFile($file, $this->class->create_links());
    }

}

?>
