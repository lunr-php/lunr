<?php

/**
 * This file contains the APNSPayloadBaseTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\APNS\Tests;

/**
 * This class contains the Base tests of the APNSPayload class.
 *
 * @covers Lunr\Vortex\APNS\APNSPayload
 */
class APNSPayloadBaseTest extends APNSPayloadTest
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
