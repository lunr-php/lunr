<?php

/**
 * This file contains the GCMPayloadGetTest class.
 *
 * @package    Lunr\Vortex\GCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\GCM\Tests;

/**
 * This class contains tests for the getters of the GCMPayload class.
 *
 * @covers Lunr\Vortex\GCM\GCMPayload
 */
class GCMPayloadGetTest extends GCMPayloadTest
{

    /**
     * Test get_payload() with collapse_key being present.
     *
     * @covers Lunr\Vortex\GCM\GCMPayload::get_payload
     */
    public function testGetPayloadWithCollapseKey()
    {
        $file     = TEST_STATICS . '/Vortex/gcm/collapse_key.json';
        $elements = [ 'collapse_key' => 'test' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with data being present.
     *
     * @covers Lunr\Vortex\GCM\GCMPayload::get_payload
     */
    public function testGetPayloadWithData()
    {
        $file     = TEST_STATICS . '/Vortex/gcm/data.json';
        $elements = [
            'data' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with time_to_live being present.
     *
     * @covers Lunr\Vortex\GCM\GCMPayload::get_payload
     */
    public function testGetPayloadWithTimeToLive()
    {
        $file     = TEST_STATICS . '/Vortex/gcm/time_to_live.json';
        $elements = [ 'time_to_live' => 10 ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers Lunr\Vortex\GCM\GCMPayload::get_payload
     */
    public function testGetPayload()
    {
        $file     = TEST_STATICS . '/Vortex/gcm/gcm.json';
        $elements = [
            'registration_ids' => [ 'one', 'two', 'three' ],
            'collapse_key'     => 'test',
            'data'             => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
            'time_to_live'     => 10,
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

}

?>
