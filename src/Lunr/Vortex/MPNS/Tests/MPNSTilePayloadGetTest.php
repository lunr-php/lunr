<?php

/**
 * This file contains the MPNSTilePayloadGetTest class.
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
class MPNSTilePayloadGetTest extends MPNSTilePayloadTest
{

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithTitle()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_title.xml';
        $elements = [ 'title' => 'Title' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithBackgroundImage()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_background_image.xml';
        $elements = [ 'background_image' => 'BgImage' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithCount()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_count.xml';
        $elements = [ 'count' => 'Count' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithBackBackgroundImage()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_back_background_image.xml';
        $elements = [ 'back_background_image' => 'BkBgImage' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithBackTitle()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_back_title.xml';
        $elements = [ 'back_title' => 'Back Title' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithBackContent()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_back_content.xml';
        $elements = [ 'back_content' => 'Back Content' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithId()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile.xml';
        $elements = [
            'title' => 'Title',
            'background_image' => 'BgImage',
            'count' => 'Count',
            'back_background_image' => 'BkBgImage',
            'back_title' => 'Back Title',
            'back_content' => 'Back Content'
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything but ID being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSTilePayload::get_payload
     */
    public function testGetPayloadWithoutId()
    {
        $file     = TEST_STATICS . '/Vortex/mpns_tile_id.xml';
        $elements = [
            'title' => 'Title',
            'background_image' => 'BgImage',
            'count' => 'Count',
            'back_background_image' => 'BkBgImage',
            'back_title' => 'Back Title',
            'back_content' => 'Back Content',
            'id' => 'ID'
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
