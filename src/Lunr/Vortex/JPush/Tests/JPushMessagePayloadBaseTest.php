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
class JPushMessagePayloadBaseTest extends JPushMessagePayloadTest
{

    /**
     * Test elements is initialized.
     *
     * @covers \Lunr\Vortex\JPush\JPushMessagePayload::__construct
     */
    public function testElementsIsInitialized(): void
    {
        $this->assertPropertySame('elements', [
            'platform' => [ 'ios', 'android' ],
            'audience' => [],
            'notification' => [],
            'message' => []
        ]);
    }

}

?>
