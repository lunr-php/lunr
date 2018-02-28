<?php

/**
 * This file contains the FCMPayloadSetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Vortex\FCM
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\FCM\Tests;

/**
 * This class contains tests for the setters of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadSetTest extends FCMPayloadTest
{

    /**
     * Test set_data() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetData()
    {
        $this->class->set_data(['key' => 'value']);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertEquals(['key' => 'value'], $value['notification']);
    }

    /**
     * Test fluid interface of set_data().
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetDataReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_data('data'));
    }

}

?>
