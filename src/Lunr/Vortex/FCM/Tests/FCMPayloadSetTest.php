<?php

/**
 * This file contains the FCMPayloadSetTest class.
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
 * This class contains tests for the setters of the FCMPayload class.
 *
 * @covers Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadSetTest extends FCMPayloadTest
{

    /**
     * Test set_collapse_key() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_collapse_key
     */
    public function testSetCollapseKey()
    {
        $this->class->set_collapse_key('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('collapse_key', $value);
        $this->assertEquals('test', $value['collapse_key']);
    }

    /**
     * Test fluid interface of set_collapse_key().
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_collapse_key
     */
    public function testSetCollapseKeyReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_collapse_key('collapse_key'));
    }

    /**
     * Test set_data() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetData()
    {
        $this->class->set_data(['key' => 'value']);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('data', $value);
        $this->assertEquals(['key' => 'value'], $value['data']);
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

    /**
     * Test set_time_to_live() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_time_to_live
     */
    public function testSetTimeToLive()
    {
        $this->class->set_time_to_live(5);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('time_to_live', $value);
        $this->assertEquals(5, $value['time_to_live']);
    }

    /**
     * Test fluid interface of set_time_to_live().
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_time_to_live
     */
    public function testSetTimeToLiveReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_time_to_live('time_to_live'));
    }

}

?>
