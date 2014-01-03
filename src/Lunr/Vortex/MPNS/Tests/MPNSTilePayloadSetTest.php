<?php

/**
 * This file contains the MPNSTilePayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

/**
 * This class contains tests for the setters of the MPNSTilePayload class.
 *
 * @category   Tests
 * @package    Vortex
 * @subpackage MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Vortex\MPNS\MPNSTilePayload
 */
class MPNSTilePayloadSetTest extends MPNSTilePayloadTest
{

    /**
     * Test set_title() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_title
     */
    public function testSetTitle()
    {
        $this->class->set_title('&title');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('title', $value);
        $this->assertEquals('&amp;title', $value['title']);
    }

    /**
     * Test fluid interface of set_title().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_title
     */
    public function testSetTitleReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_title('title'));
    }

    /**
     * Test set_background_image() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_background_image
     */
    public function testSetBackgroundImage()
    {
        $this->class->set_background_image('&image');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('background_image', $value);
        $this->assertEquals('&amp;image', $value['background_image']);
    }

    /**
     * Test fluid interface of set_background_image().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_background_image
     */
    public function testSetBackgroundImageReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_background_image('image'));
    }

    /**
     * Test set_count() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_count
     */
    public function testSetCount()
    {
        $this->class->set_count('&count');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('count', $value);
        $this->assertEquals('&amp;count', $value['count']);
    }

    /**
     * Test fluid interface of set_count().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_count
     */
    public function testSetCountReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_count('count'));
    }

    /**
     * Test set_back_background_image() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_background_image
     */
    public function testSetBackBackgroundImage()
    {
        $this->class->set_back_background_image('&image');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('back_background_image', $value);
        $this->assertEquals('&amp;image', $value['back_background_image']);
    }

    /**
     * Test fluid interface of set_back_background_image().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_background_image
     */
    public function testSetBackBackgroundImageReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_back_background_image('image'));
    }

    /**
     * Test set_back_title() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_title
     */
    public function testSetBackTitle()
    {
        $this->class->set_back_title('&title');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('back_title', $value);
        $this->assertEquals('&amp;title', $value['back_title']);
    }

    /**
     * Test fluid interface of set_back_title().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_title
     */
    public function testSetBackTitleReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_back_title('title'));
    }

    /**
     * Test set_back_content() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_content
     */
    public function testSetBackContent()
    {
        $this->class->set_back_content('&content');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('back_content', $value);
        $this->assertEquals('&amp;content', $value['back_content']);
    }

    /**
     * Test fluid interface of set_back_content().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_back_content
     */
    public function testSetBackContentReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_back_content('content'));
    }

    /**
     * Test set_id() works correctly.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_id
     */
    public function testSetId()
    {
        $this->class->set_id('&id');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('id', $value);
        $this->assertEquals('&amp;id', $value['id']);
    }

    /**
     * Test fluid interface of set_id().
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::set_id
     */
    public function testSetIdReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_id('id'));
    }

}

?>
