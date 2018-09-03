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
     * Test set_notification() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_notification
     */
    public function testSetNotification()
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
    public function testSetNotificationReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_notification('data'));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_priority
     */
    public function testSetPriority()
    {
        $this->class->set_priority('high');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals('high', $value['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_priority('high'));
    }

    /**
     * Test set_mutable_content() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_mutable_content
     */
    public function testSetMutableContent()
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
    public function testSetMutableContentReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_mutable_content(TRUE));
    }

    /**
     * Test set_data() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_data
     */
    public function testSetData()
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
    public function testSetDataReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_data('data'));
    }

    /**
     * Test set_topic() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_topic
     */
    public function testSetTopic()
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
    public function testSetTopicReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_topic('data'));
    }

    /**
     * Test set_condition() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_condition
     */
    public function testSetCondition()
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
    public function testSetConditionReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_condition('data'));
    }

    /**
     * Test set_low_priority() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_low_priority
     */
    public function testSetLowPriority()
    {
        $this->class->set_low_priority(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals('normal', $value['priority']);
    }

    /**
     * Test fluid interface of set_low_priority().
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_low_priority
     */
    public function testSetLowPriorityReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_low_priority(TRUE));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\FCM\FCMPayload::set_content_available
     */
    public function testSetContentAvailable()
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
    public function testSetContentAvailableReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_content_available(TRUE));
    }

}

?>
