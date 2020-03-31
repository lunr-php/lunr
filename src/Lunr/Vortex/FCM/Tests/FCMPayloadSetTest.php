<?php

/**
 * This file contains the FCMPayloadSetTest class.
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
 * @covers \Lunr\Vortex\FCM\FCMPayload
 */
class FCMPayloadSetTest extends FCMPayloadTest
{

    /**
     * Test set_collapse_key() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_collapse_key
     */
    public function testSetCollapseKey(): void
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
    public function testSetCollapseKeyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_collapse_key('collapse_key'));
    }

    /**
     * Test set_time_to_live() works correctly.
     *
     * @covers Lunr\Vortex\FCM\FCMPayload::set_time_to_live
     */
    public function testSetTimeToLive(): void
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
    public function testSetTimeToLiveReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_time_to_live('time_to_live'));
    }

    /**
     * Test set_notification() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_notification
     */
    public function testSetNotification(): void
    {
        $this->class->set_notification([ 'key' => 'value' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('notification', $value);
        $this->assertEquals([ 'key' => 'value' ], $value['notification']);
    }

    /**
     * Test fluid interface of set_notification().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_notification
     */
    public function testSetNotificationReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_notification('data'));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_priority
     */
    public function testSetPriority(): void
    {
        $this->class->set_priority('normal');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals('normal', $value['priority']);
    }

    /**
     * Test set_priority() works correctly with an invalid priority.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_priority
     */
    public function testSetPriorityInvalid(): void
    {
        $this->class->set_priority('cow');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals('high', $value['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_priority('high'));
    }

    /**
     * Test set_mutable_content() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_mutable_content
     */
    public function testSetMutableContent(): void
    {
        $this->class->set_mutable_content(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('mutable_content', $value);
        $this->assertEquals(TRUE, $value['mutable_content']);
    }

    /**
     * Test fluid interface of set_mutable_content().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_mutable_content
     */
    public function testSetMutableContentReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_mutable_content(TRUE));
    }

    /**
     * Test set_data() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetData(): void
    {
        $this->class->set_data([ 'key' => 'value' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('data', $value);
        $this->assertEquals([ 'key' => 'value' ], $value['data']);
    }

    /**
     * Test fluid interface of set_data().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_data('data'));
    }

    /**
     * Test set_topic() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_topic
     */
    public function testSetTopic(): void
    {
        $this->class->set_topic('News');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('topic', $value);
        $this->assertEquals('News', $value['topic']);
    }

    /**
     * Test fluid interface of set_topic().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_topic
     */
    public function testSetTopicReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_topic('data'));
    }

    /**
     * Test set_condition() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_condition
     */
    public function testSetCondition(): void
    {
        $this->class->set_condition("'TopicA' in topics && 'TopicB' in topics");

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('condition', $value);
        $this->assertEquals("'TopicA' in topics && 'TopicB' in topics", $value['condition']);
    }

    /**
     * Test fluid interface of set_condition().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_condition
     */
    public function testSetConditionReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_condition('data'));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_content_available
     */
    public function testSetContentAvailable(): void
    {
        $this->class->set_content_available(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('content_available', $value);
        $this->assertEquals(TRUE, $value['content_available']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_content_available
     */
    public function testSetContentAvailableReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_content_available(TRUE));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_content_available
     */
    public function testSetOptions()
    {
        $this->class->set_options('analytics_label', 'fooBar');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('fcm_options', $value);
        $this->assertArrayHasKey('analytics_label', $value['fcm_options']);
        $this->assertEquals('fooBar', $value['fcm_options']['analytics_label']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_content_available
     */
    public function testSetOptionsReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_options('analytics_label', 'fooBar'));
    }

}

?>
