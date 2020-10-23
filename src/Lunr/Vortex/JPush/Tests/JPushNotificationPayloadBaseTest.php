<?php

/**
 * This file contains the JPushPayloadBaseTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains the Base tests of the JPushPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushNotificationPayload
 */
class JPushNotificationPayloadBaseTest extends JPushNotificationPayloadTest
{

    /**
     * Test elements is initialized with high priority.
     */
    public function testElementsIsInitializedWithHighPriority(): void
    {
        $this->assertPropertySame('elements', [
            'platform' => [ 'ios', 'android' ],
            'audience' => [],
            'notification' => [
                'android' => [ 'priority' => 2 ],
            ],
            'message' => []
        ]);
    }

}

?>
