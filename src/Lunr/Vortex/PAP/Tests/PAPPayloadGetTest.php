<?php

/**
 * This file contains the PAPPayloadGetTest class.
 *
 * @package    Lunr\Vortex\PAP
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2013-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\PAP\Tests;

/**
 * This class contains tests for the getters of the PAPPayload class.
 *
 * @covers Lunr\Vortex\PAP\PAPPayload
 */
class PAPPayloadGetTest extends PAPPayloadTest
{

    /**
     * Test get_payload() with the message being present.
     *
     * @covers Lunr\Vortex\PAP\PAPPayload::get_payload
     */
    public function testGetPayload(): void
    {
        $file     = TEST_STATICS . '/Vortex/pap/message.json';
        $elements = [
            'key1' => 'value1',
            'key2' => 'value2',
        ];

        $this->set_reflection_property_value('data', $elements);

        $this->assertStringMatchesFormatFile($file, $this->class->get_payload());
    }

    /**
     * Test get_priority() with the priority being set.
     *
     * @covers Lunr\Vortex\PAP\PAPPayload::get_priority
     */
    public function testGetPriority(): void
    {
        $this->set_reflection_property_value('priority', 9000);

        $this->assertEquals(9000, $this->class->get_priority());
    }

}

?>
