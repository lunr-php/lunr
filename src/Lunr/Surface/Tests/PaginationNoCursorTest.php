<?php

/**
 * This file contains the PaginationNoCursorTest class.
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
class PaginationNoCursorTest extends PaginationTest
{

    /**
     * Testcase Constructor.
     */
    public function setUp()
    {
        parent::setUpWithoutCursor();
    }

    /**
     * Test that the items per page value is initialized correctly.
     */
    public function testPerPageIsInitializedCorrectly()
    {
        $this->assertEquals(25, $this->get_reflection_property_value('per_page'));
    }

    /**
     * Test that the page range value is initialized correctly.
     */
    public function testRangeIsInitializedCorrectly()
    {
        $this->assertEquals(2, $this->get_reflection_property_value('range'));
    }

    /**
     * Test that the total number of items is initialized correctly.
     */
    public function testTotalIsInitializedCorrectly()
    {
        $this->assertEquals(-1, $this->get_reflection_property_value('total'));
    }

    /**
     * Test that the total number of pages is initialized correctly.
     */
    public function testPagesTotalIsInitializedCorrectly()
    {
        $this->assertEquals(0, $this->get_reflection_property_value('pages_total'));
    }

    /**
     * Test that the initial cursor is set correctly.
     */
    public function testCursorIsInitializedCorrectly()
    {
        $this->assertEquals(1, $this->get_reflection_property_value('cursor'));
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
     * Test that the navigation buttons are initialized correctly.
     */
    public function testButtonsAreInitializedCorrectly()
    {
        $buttons = $this->get_reflection_property_value('buttons');

        $this->assertInternalType('array', $buttons);

        $this->assertArrayHasKey('first', $buttons);
        $this->assertArrayHasKey('previous', $buttons);
        $this->assertArrayHasKey('next', $buttons);
        $this->assertArrayHasKey('last', $buttons);

        foreach (['first', 'previous', 'next', 'last'] as $index)
        {
            $this->assertInternalType('array', $buttons[$index]);
            $this->assertArrayHasKey('text', $buttons[$index]);
            $this->assertArrayHasKey('enabled', $buttons[$index]);
            $this->assertTrue($buttons[$index]['enabled']);
        }

        $this->assertEquals('&#8810;', $buttons['first']['text']);
        $this->assertEquals('&lt;', $buttons['previous']['text']);
        $this->assertEquals('&gt;', $buttons['next']['text']);
        $this->assertEquals('&#8811;', $buttons['last']['text']);
    }

}

?>
