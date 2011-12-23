<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeGetDateTimeTest extends DateTimeTest
{

    /**
     * Test get_datetime() with the default datetime format and current timestamp as base.
     *
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->get_datetime());
    }

    /**
     * Test get_datetime() with a custom datetime format and current timestamp as base.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->get_datetime());
    }

    /**
     * Test get_datetime() with a custom but invalid datetime format and current timestamp as base.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->get_datetime());
    }

    /**
     * Test get_datetime() with a custom datetime format, custom locale and current timestamp as base.
     *
     * @runInSeparateProcess
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithLocalizedCustomDatetimeFormat()
    {
        $day = strftime('%u');
        $localized_day = $this->datetime->set_datetime_format('%A')->set_locale('de_DE')->get_datetime();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test get_datetime() with the default datetime format and a custom timestamp as base.
     *
     * @dataProvider validTimestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomTimestampAsBase($timestamp)
    {
        $this->assertEquals(strftime('%Y-%m-%d', $timestamp), $this->datetime->get_datetime($timestamp));
    }

    /**
     * Test get_datetime() with the default datetime format and a custom but invalid timestamp as base.
     *
     * @dataProvider invalidTimestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomInvalidTimestampAsBase($timestamp)
    {
        $this->assertFalse($this->datetime->get_datetime($timestamp));
    }

}

?>
