<?php

/**
 * This file contains the JPushPayloadGetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the getters of the JPushPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushPayload
 */
class JPushPayloadGetTest extends JPushPayloadTest
{

    /**
     * Test get_payload() with collapse_key being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::get_payload
     */
    public function testGetPayloadWithCollapseKey(): void
    {
        $file     = TEST_STATICS . '/Vortex/gcm/collapse_key.json';
        $elements = [ 'collapse_key' => 'test' ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, json_encode($this->class->get_payload()));
    }

    /**
     * Test get_payload() with data being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::get_payload
     */
    public function testGetPayloadWithData(): void
    {
        $file     = TEST_STATICS . '/Vortex/gcm/data.json';
        $elements = [
            'data' => [
                'key1' => 'value1',
                'key2' => 'value2',
            ],
        ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, json_encode($this->class->get_payload()));
    }

    /**
     * Test get_payload() with time_to_live being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::get_payload
     */
    public function testGetPayloadWithTimeToLive(): void
    {
        $file     = TEST_STATICS . '/Vortex/gcm/time_to_live.json';
        $elements = [ 'time_to_live' => 10 ];

        $this->set_reflection_property_value('elements', $elements);

        $this->assertStringMatchesFormatFile($file, json_encode($this->class->get_payload()));
    }

    /**
     * Test get_payload() with everything being present.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::get_payload
     */
    public function testGetPayload(): void
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

        $this->assertStringMatchesFormatFile($file, json_encode($this->class->get_payload()));
    }

}

?>
