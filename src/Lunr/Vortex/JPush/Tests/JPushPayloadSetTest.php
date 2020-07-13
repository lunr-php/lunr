<?php

/**
 * This file contains the JPushPayloadSetTest class.
 *
 * @package    Lunr\Vortex\JPush
 * @author     Sean Molenaar <s.molenaar@m2mobi.com>
 * @copyright  2020, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Vortex\JPush\Tests;

/**
 * This class contains tests for the setters of the JPushPayload class.
 *
 * @covers \Lunr\Vortex\JPush\JPushPayload
 */
class JPushPayloadSetTest extends JPushPayloadTest
{

    /**
     * Test set_collapse_key() works correctly.
     *
     * @covers Lunr\Vortex\JPush\JPushPayload::set_collapse_key
     */
    public function testSetCollapseKey(): void
    {
        $this->class->set_collapse_key('test');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('apns_collapse_id', $value['options']);
        $this->assertEquals('test', $value['options']['apns_collapse_id']);
    }

    /**
     * Test fluid interface of set_collapse_key().
     *
     * @covers Lunr\Vortex\JPush\JPushPayload::set_collapse_key
     */
    public function testSetCollapseKeyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_collapse_key('collapse_key'));
    }

    /**
     * Test set_time_to_live() works correctly.
     *
     * @covers Lunr\Vortex\JPush\JPushPayload::set_time_to_live
     */
    public function testSetTimeToLive(): void
    {
        $this->class->set_time_to_live(5);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('time_to_live', $value['options']);
        $this->assertEquals(5, $value['options']['time_to_live']);
    }

    /**
     * Test fluid interface of set_time_to_live().
     *
     * @covers Lunr\Vortex\JPush\JPushPayload::set_time_to_live
     */
    public function testSetTimeToLiveReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_time_to_live('time_to_live'));
    }

    /**
     * Test set_priority() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_priority
     */
    public function testSetPriority(): void
    {
        $this->class->set_priority(1);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value['notification']['android']);
        $this->assertEquals(1, $value['notification']['android']['priority']);
    }

    /**
     * Test set_priority() works correctly with an invalid priority.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_priority
     */
    public function testSetPriorityInvalid(): void
    {
        $this->class->set_priority('cow');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('priority', $value['notification']['android']);
        $this->assertEquals(2, $value['notification']['android']['priority']);
    }

    /**
     * Test fluid interface of set_priority().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_priority
     */
    public function testSetPriorityReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_priority('high'));
    }

    /**
     * Test set_mutable_content() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_mutable_content
     */
    public function testSetMutableContent(): void
    {
        $this->class->set_mutable_content(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('mutable-content', $value['notification']['ios']);
        $this->assertEquals(TRUE, $value['notification']['ios']['mutable-content']);
    }

    /**
     * Test fluid interface of set_mutable_content().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_mutable_content
     */
    public function testSetMutableContentReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_mutable_content(TRUE));
    }

    /**
     * Test set_data() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_data
     */
    public function testSetData(): void
    {
        $this->class->set_data([ 'key' => 'value' ]);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('extras', $value['notification']['android']);
        $this->assertEquals([ 'key' => 'value' ], $value['notification']['android']['extras']);
    }

    /**
     * Test fluid interface of set_data().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_data
     */
    public function testSetDataReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_data('data'));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_content_available
     */
    public function testSetContentAvailable(): void
    {
        $this->class->set_content_available(TRUE);

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('content-available', $value['notification']['ios']);
        $this->assertEquals(TRUE, $value['notification']['ios']['content-available']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_content_available
     */
    public function testSetContentAvailableReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_content_available(TRUE));
    }

    /**
     * Test set_notification_identifier() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_notification_identifier
     */
    public function testSetNotificationIdentifier(): void
    {
        $this->class->set_notification_identifier('ID');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('cid', $value);
        $this->assertEquals('ID', $value['cid']);
    }

    /**
     * Test fluid interface of set_notification_identifier().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_notification_identifier
     */
    public function testSetNotificationIdentifierReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_notification_identifier('ID'));
    }

    /**
     * Test set_body() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_body
     */
    public function testSetBody(): void
    {
        $this->class->set_body('BODY');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('alert', $value['notification']['android']);
        $this->assertEquals('BODY', $value['notification']['android']['alert']);
    }

    /**
     * Test fluid interface of set_body().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_body
     */
    public function testSetBodyReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_body('body'));
    }

    /**
     * Test set_title() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_title
     */
    public function testSetTitle(): void
    {
        $this->class->set_title('Title');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('title', $value['notification']['android']);
        $this->assertEquals('Title', $value['notification']['android']['title']);
    }

    /**
     * Test fluid interface of set_title().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_title
     */
    public function testSetTitleReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_title('title'));
    }

    /**
     * Test set_category() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_category
     */
    public function testSetCategory(): void
    {
        $this->class->set_category('cats');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('category', $value['notification']['android']);
        $this->assertEquals('cats', $value['notification']['android']['category']);
    }

    /**
     * Test fluid interface of set_category().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_category
     */
    public function testSetCategoryReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_category('cats'));
    }

    /**
     * Test set_sound() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_sound
     */
    public function testSetSound(): void
    {
        $this->class->set_sound('sound');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('sound', $value['notification']['android']);
        $this->assertEquals('sound', $value['notification']['android']['sound']);
    }

    /**
     * Test fluid interface of set_sound().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_sound
     */
    public function testSetSoundReturnsSelfReference(): void
    {
        $this->assertSame($this->class, $this->class->set_sound('sound'));
    }

    /**
     * Test set_content_available() works correctly.
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_content_available
     */
    public function testSetOptions()
    {
        $this->class->set_options('analytics_label', 'fooBar');

        $value = $this->get_reflection_property_value('elements');

        $this->assertArrayHasKey('options', $value);
        $this->assertArrayHasKey('analytics_label', $value['options']);
        $this->assertEquals('fooBar', $value['options']['analytics_label']);
    }

    /**
     * Test fluid interface of set_content_available().
     *
     * @covers \Lunr\Vortex\JPush\JPushPayload::set_content_available
     */
    public function testSetOptionsReturnsSelfReference()
    {
        $this->assertSame($this->class, $this->class->set_options('analytics_label', 'fooBar'));
    }

}

?>
