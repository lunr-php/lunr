<?php

/**
 * This file contains the APNSPayloadGetTest class.
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
 * This class contains tests for the getters of the APNSPayload class.
 *
 * @covers Lunr\Vortex\APNS\APNSPayload
 */
class APNSPayloadGetTest extends APNSPayloadTest
{

    /**
     * Test get_payload() with alert being present.
     *
     * @param String $file       The path to the payload file
     * @param array  $data_array The data to compare get_payload against
     *
     * @dataProvider payloadProvider
     * @covers       Lunr\Vortex\APNS\APNSPayload::get_payload
     */
    public function testGetPayloadWithAlert($file, $data_array)
    {
        $file     = TEST_STATICS . $file;
        $elements = $data_array;

        $this->set_reflection_property_value('elements', $elements);

        $this->assertJsonStringEqualsJsonFile($file, $this->class->get_payload());
    }

}

?>
