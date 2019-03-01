<?php

/**
 * This file contains the FCMPayloadBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Dinos Theodorou <dinos@m2mobi.com>
 * @copyright  2013-2016, M2Mobi BV, Amsterdam, The Netherlands
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
     * Test elements is initialized as an empty array.
     */
    public function testElementsIsInitializedAsEmptyArray()
    {
        $this->assertArrayEmpty($this->get_reflection_property_value('elements'));
    }

}

?>
