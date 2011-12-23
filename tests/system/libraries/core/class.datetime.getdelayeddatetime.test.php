<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeGetDelayedDatetimeTest extends DateTimeTest
{

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom timestamp as base.
     *
     * @depends Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomTimestampAsBase($timestamp)
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime("+1 day", $timestamp)), $this->datetime->get_delayed_datetime("+1 day", $timestamp));
    }

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom but invalid timestamp as base.
     *
     * @dataProvider invalidTimestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomInvalidTimestampAsBase($timestamp)
    {
        $this->assertFalse($this->datetime->get_delayed_datetime("+1 day", $timestamp));
    }

    /**
     * Test get_delayed_datetime() with a valid delay, default datetime format and current timestamp as base.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider validDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithValidDelay($delay)
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime($delay)), $this->datetime->get_delayed_datetime($delay));
    }

    /**
     * Test get_delayed_datetime() with an invalid delay, default datetime format and current timestamp as base.
     *
     * @depends Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider invalidDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithInvalidDelay($delay)
    {
        $this->assertFalse($this->datetime->get_delayed_datetime($delay));
    }

}

?>
