<?php

/**
 * This file contains the MPNSToastPayloadGetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\MPNS
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013-2017, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\MPNS\Tests;

/**
 * This class contains tests for the getters of the MPNSToastPayload class.
 *
 * @covers Lunr\Vortex\MPNS\MPNSToastPayload
 */
class MPNSToastPayloadGetTest extends MPNSToastPayloadTest
{

    /**
     * Test get_payload() with title being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSToastPayload::get_payload
     */
    public function testGetPayloadWithTitle()
    {
        $file     = TEST_STATICS . '/Vortex/mpns/toast_title.xml';
        $elements = [ 'title' => 'Title' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with message being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSToastPayload::get_payload
     */
    public function testGetPayloadWithMessage()
    {
        $file     = TEST_STATICS . '/Vortex/mpns/toast_message.xml';
        $elements = [ 'message' => 'Message' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with deeplink being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSToastPayload::get_payload
     */
    public function testGetPayloadWithDeeplink()
    {
        $file     = TEST_STATICS . '/Vortex/mpns/toast_deeplink.xml';
        $elements = [ 'deeplink' => 'Deeplink' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\MPNS\MPNSToastPayload::get_payload
     */
    public function testGetPayload()
    {
        $file     = TEST_STATICS . '/Vortex/mpns/toast.xml';
        $elements = [ 'title' => 'Title', 'message' => 'Message', 'deeplink' => 'Deeplink' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
