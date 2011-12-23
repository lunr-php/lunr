<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeYesterdayTest extends DateTimeTest
{

    /**
     * Test the function yesterday() with the default datetime format.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime("-1 day")), $this->datetime->yesterday());
    }

    /**
     * Test the function yesterday() with a custom datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y', strtotime("-1 day")), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->yesterday());
    }

    /**
     * Test the function yesterday() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithLocalizedCustomDatetimeFormat()
    {
        $day = strftime('%u', strtotime("-1 day"));
        $localized_day = $this->datetime->set_datetime_format('%A')->set_locale('de_DE')->yesterday();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function yesterday() with a custom but invalid datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->yesterday());
    }

}

?>
