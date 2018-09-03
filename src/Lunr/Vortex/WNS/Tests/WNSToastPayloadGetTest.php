<?php

/**
 * This file contains the WNSToastPayloadGetTest class.
 *
 * @package    Lunr\Vortex\WNS
 * @author     Sean Molenaar <sean@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\WNS\Tests;

/**
 * This class contains tests for the getters of the WNSToastPayload class.
 *
 * @covers Lunr\Vortex\WNS\WNSToastPayload
 */
class WNSToastPayloadGetTest extends WNSToastPayloadTest
{

    /**
     * Test get_payload() with title being present.
     *
     * @covers Lunr\Vortex\WNS\WNSToastPayload::get_payload
     */
    public function testGetPayloadWithTitle()
    {
        $file     = TEST_STATICS . '/Vortex/wns/toast_title.xml';
        $elements = [ 'text' => [ 'Title' ] ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with message being present.
     *
     * @covers Lunr\Vortex\WNS\WNSToastPayload::get_payload
     */
    public function testGetPayloadWithMessage()
    {
        $file     = TEST_STATICS . '/Vortex/wns/toast_message.xml';
        $elements = [ 'text' => [ 'Message' ] ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with deeplink being present.
     *
     * @covers Lunr\Vortex\WNS\WNSToastPayload::get_payload
     */
    public function testGetPayloadWithDeeplinkAndTemplate()
    {
        $file     = TEST_STATICS . '/Vortex/wns/toast_deeplink.xml';
        $elements = [ 'text' => [], 'template' => 'ToastText01', 'launch' => 'Deeplink' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\WNS\WNSToastPayload::get_payload
     */
    public function testGetPayload()
    {
        $file     = TEST_STATICS . '/Vortex/wns/toast.xml';
        $elements = [ 'text' => [ 'Title', 'Message', 'Hello' ], 'template' => 'ToastText04', 'image' => 'image', 'launch' => 'Deeplink' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
