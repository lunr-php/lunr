<?php

/**
 * This file contains the APNSPayloadSetTest class.
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
 * This class contains tests for the setters of the APNSPayload class.
 *
 * @covers Lunr\Vortex\APNS\APNSPayload
 */
class APNSPayloadSetTest extends APNSPayloadTest
{

    /**
     * Test set_alert() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_alert
     */
    public function testSetAlert()
    {
        $this->class->set_alert('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('alert', $value);
        $this->assertEquals('test', $value['alert']);
    }

    /**
     * Test fluid interface of set_alert().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_alert
     */
    public function testSetAlertReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_alert('alert'));
    }

    /**
     * Test set_sound() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_sound
     */
    public function testSetSound()
    {
        $this->class->set_sound('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('sound', $value);
        $this->assertEquals('test', $value['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

    /**
     * Test set_custom_data() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_custom_data
     */
    public function testSetCustomData()
    {
        $this->class->set_custom_data('key', 'value');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('custom_data', $value);
        $this->assertEquals(['key' => 'value'], $value['custom_data']);
    }

    /**
     * Test fluid interface of set_custom_data().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_custom_data
     */
    public function testSetCustomDataReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_custom_data('key', 'value'));
    }

    /**
     * Test set_badge() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_badge
     */
    public function testSetBadge()
    {
        $this->class->set_badge(5);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('badge', $value);
        $this->assertEquals(5, $value['badge']);
    }

    /**
     * Test fluid interface of set_badge().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_badge
     */
    public function testSetBadgeReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_badge('badge'));
    }

}

?>
