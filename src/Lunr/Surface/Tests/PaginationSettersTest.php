<?php

/**
 * This file contains the PaginationSettersTest class.
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
class PaginationSettersTest extends PaginationTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpWithCursor();
    }

    /**
     * Test that the base URL value is initialized correctly.
     */
    public function testBaseURLIsInitializedCorrectly()
    {
        $baseurl = 'http://www.example.com/controller/method/param1/param2/';

        $this->assertEquals($baseurl, $this->get_reflection_property_value('base_url'));
    }

    /**
     * Test the page cursor is initialized from the URL.
     */
    public function testCursorIsInitializedFromUrl()
    {
        $this->assertSame(10, $this->get_reflection_property_value('cursor'));
    }

    /**
     * Test fluid interface of set_total_items().
     *
     * @covers Lunr\Surface\Pagination::set_total_items
     */
    public function testSetTotalReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_total_items(10));
    }

    /**
     * Test set_total_items() with valid values.
     *
     * @covers Lunr\Surface\Pagination::set_total_items
     */
    public function testSetTotalWithValidValues()
    {
        $this->class->set_total_items(10);

        $this->assertEquals(10, $this->get_reflection_property_value('total'));
    }

    /**
     * Test set_total_items() with invalid values.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider invalidTotalItemProvider
     * @covers       Lunr\Surface\Pagination::set_total_items
     */
    public function testSetTotalWithInvalidValues($value)
    {
        $property = $this->get_accessible_reflection_property('total');
        $this->assertEquals(-1, $property->GetValue($this->class));

        $this->class->set_total_items($value);

        $this->assertEquals(-1, $property->GetValue($this->class));
    }

    /**
     * Test fluid interface of set_base_url().
     *
     * @covers Lunr\Surface\Pagination::set_base_url
     */
    public function testSetBaseurlReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_base_url('URL'));
    }

    /**
     * Test set_base_url() with valid values.
     *
     * @covers Lunr\Surface\Pagination::set_base_url
     */
    public function testSetBaseurlWithValidValues()
    {
        $this->class->set_base_url('URL');

        $this->assertEquals('URL', $this->get_reflection_property_value('base_url'));
    }

    /**
     * Test set_base_url() with invalid values.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider invalidBaseURLProvider
     * @covers       Lunr\Surface\Pagination::set_base_url
     */
    public function testSetBaseurlWithInvalidValues($value)
    {
        $baseurl  = 'http://www.example.com/controller/method/param1/param2/';
        $property = $this->get_accessible_reflection_property('base_url');
        $this->assertEquals($baseurl, $property->GetValue($this->class));

        $this->class->set_base_url($value);

        $this->assertEquals($baseurl, $property->GetValue($this->class));
    }

    /**
     * Test fluid interface of set_range().
     *
     * @covers Lunr\Surface\Pagination::set_range
     */
    public function testSetRangeReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_range(10));
    }

    /**
     * Test set_range() with valid values.
     *
     * @covers Lunr\Surface\Pagination::set_range
     */
    public function testSetRangeWithValidValues()
    {
        $this->class->set_range(10);

        $this->assertEquals(10, $this->get_reflection_property_value('range'));
    }

    /**
     * Test set_range() with invalid values.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider invalidTotalItemProvider
     * @covers       Lunr\Surface\Pagination::set_range
     */
    public function testSetRangeWithInvalidValues($value)
    {
        $property = $this->get_accessible_reflection_property('range');
        $this->assertEquals(2, $property->GetValue($this->class));

        $this->class->set_total_items($value);

        $this->assertEquals(2, $property->GetValue($this->class));
    }

    /**
     * Test fluid interface of set_items_per_page().
     *
     * @covers Lunr\Surface\Pagination::set_items_per_page
     */
    public function testSetItemsPerPageReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_items_per_page(10));
    }

    /**
     * Test set_items_per_page() with valid values.
     *
     * @covers Lunr\Surface\Pagination::set_items_per_page
     */
    public function testSetItemsPerPageWithValidValues()
    {
        $this->class->set_items_per_page(10);

        $this->assertEquals(10, $this->get_reflection_property_value('per_page'));
    }

    /**
     * Test set_items_per_page() with invalid values.
     *
     * @param mixed $value Invalid value
     *
     * @dataProvider invalidTotalItemProvider
     * @covers       Lunr\Surface\Pagination::set_items_per_page
     */
    public function testSetItemsPerPageWithInvalidValues($value)
    {
        $property = $this->get_accessible_reflection_property('per_page');
        $this->assertEquals(25, $property->GetValue($this->class));

        $this->class->set_total_items($value);

        $this->assertEquals(25, $property->GetValue($this->class));
    }

    /**
     * Test fluid interface of set_button_label().
     *
     * @covers Lunr\Surface\Pagination::set_button_label
     */
    public function testSetButtonLabelReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_button_label('first', 'First'));
    }

    /**
     * Test set_button_label() for an invalid button.
     *
     * @covers Lunr\Surface\Pagination::set_button_label
     */
    public function testSetButtonLabelForInvalidButton()
    {
        $property = $this->get_accessible_reflection_property('buttons');
        $before   = $property->getValue($this->class);

        $this->class->set_button_label('middle', 'Middle');

        $this->assertEquals($before, $property->getValue($this->class));
    }

    /**
     * Test set_button_label() for a valid button.
     *
     * @param mixed $button Button ID
     *
     * @dataProvider validButtonProvider
     * @covers       Lunr\Surface\Pagination::set_button_label
     */
    public function testSetButtonLabelForValidButton($button)
    {
        $this->class->set_button_label($button, 'Label');

        $this->assertEquals('Label', $this->get_reflection_property_value('buttons')[$button]['text']);
    }

}

?>
