<?php

/**
 * This file contains the APNSPayloadSetTest class.
 *
 * @package    Lunr\Vortex\APNS
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
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
    public function testSetAlert(): void
    {
        $this->class->set_alert('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('body', $value);
        $this->assertEquals('test', $value['body']);
    }

    /**
     * Test set_body() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_alert
     */
    public function testSetBody(): void
    {
        $this->class->set_body('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('body', $value);
        $this->assertEquals('test', $value['body']);
    }

    /**
     * Test fluid interface of set_alert().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_alert
     */
    public function testSetAlertReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_alert('alert'));
    }

    /**
     * Test set_sound() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_sound
     */
    public function testSetSound(): void
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
    public function testSetSoundReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

    /**
     * Test set_thread_id() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_thread_id
     */
    public function testSetThreadId(): void
    {
        $this->class->set_thread_id('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('thread_id', $value);
        $this->assertEquals('test', $value['thread_id']);
    }

    /**
     * Test fluid interface of set_thread_id().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_thread_id
     */
    public function testSetThreadIdReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_thread_id('sound'));
    }

    /**
     * Test set_category() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_category
     */
    public function testSetCategory(): void
    {
        $this->class->set_category('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('category', $value);
        $this->assertEquals('test', $value['category']);
    }

    /**
     * Test fluid interface of set_category().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_category
     */
    public function testSetCategoryReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_category('sound'));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_content_available
     */
    public function testSetContentAvailable(): void
    {
        $this->class->set_content_available(true);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('content_available', $value);
        $this->assertEquals(true, $value['content_available']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_content_available
     */
    public function testSetContentAvailableReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_content_available(true));
    }

    /**
     * Test set_title() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_title
     */
    public function testSetTitle(): void
    {
        $this->class->set_title('title');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('title', $value);
        $this->assertEquals('title', $value['title']);
    }

    /**
     * Test fluid interface of set_title().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_title
     */
    public function testSetTitleReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_title('title'));
    }

    /**
     * Test set_custom_data() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_custom_data
     */
    public function testSetCustomData(): void
    {
        $this->class->set_custom_data('key', 'value');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('custom_data', $value);
        $this->assertEquals([ 'key' => 'value' ], $value['custom_data']);
    }

    /**
     * Test fluid interface of set_custom_data().
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_custom_data
     */
    public function testSetCustomDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_custom_data('key', 'value'));
    }

    /**
     * Test set_badge() works correctly.
     *
     * @covers Lunr\Vortex\APNS\APNSPayload::set_badge
     */
    public function testSetBadge(): void
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
    public function testSetBadgeReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_badge('badge'));
    }

    /**
     * Test set_collapse_key() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_collapse_key
     */
    public function testCollapseKey(): void
    {
        $this->class->set_collapse_key('key');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('collapse_key', $value);
        $this->assertEquals('key', $value['collapse_key']);
    }

    /**
     * Test fluid interface of set_collapse_key().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_collapse_key
     */
    public function testSetCollapseKeyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_collapse_key('badge'));
    }

    /**
     * Test set_topic() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_topic
     */
    public function testTopic(): void
    {
        $this->class->set_topic('key');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('topic', $value);
        $this->assertEquals('key', $value['topic']);
    }

    /**
     * Test fluid interface of set_topic().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_topic
     */
    public function testSetTopicReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_topic('badge'));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_priority
     */
    public function testPriority(): void
    {
        $this->class->set_priority(5);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals(5, $value['priority']);
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_priority
     */
    public function testPriorityIgnoresWrongValues(): void
    {
        $this->class->set_priority(7);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value);
        $this->assertEquals(10, $value['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_priority('badge'));
    }

    /**
     * Test set_identifier() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_identifier
     */
    public function testIdentifier(): void
    {
        $this->class->set_identifier('key');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('identifier', $value);
        $this->assertEquals('key', $value['identifier']);
    }

    /**
     * Test fluid interface of set_identifier().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_identifier
     */
    public function testSetIdentifierReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_identifier('badge'));
    }

    /**
     * Test set_mutable_content() works correctly.
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_mutable_content
     */
    public function testMutableContent(): void
    {
        $this->class->set_mutable_content(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('mutable_content', $value);
        $this->assertEquals(TRUE, $value['mutable_content']);
    }

    /**
     * Test fluid interface of set_mutable_content().
     *
     * @covers \Lunr\Vortex\APNS\APNSPayload::set_mutable_content
     */
    public function testSetMutableContentReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_mutable_content(TRUE));
    }

}

?>
