<?php

/**
 * This file contains the FCMPayloadBaseTest class.
 *
 * @package    Lunr\Vortex\FCM
 * @author     Patrick Valk <p.valk@m2mobi.com>
 * @copyright  2017-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains the Base tests of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadBaseTest extends FCMPayloadTest
{

    /**
     * Test elements is initialized with high priority.
     */
    public function testElementsIsInitializedWithHighPriority()
    {
        $this->assertSame($this->get_reflection_property_value('elements'), ['priority' => 'high']);
    }

}

?>
