<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeTodayTest extends DateTimeTest
{

    /**
     * Test the function today() with the default datetime format.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::today
     */
    public function testTodayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->today());
    }

    /**
     * Test the function today() with a custom datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::today
     */
    public function testTodayWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->today());
    }

    /**
     * Test the function today() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers Lunr\Libraries\Core\DateTime::today
     */
    public function testTodayWithLocalizedCustomDatetimeFormat()
    {
        $day = strftime('%u');
        $localized_day = $this->datetime->set_datetime_format('%A')->set_locale('de_DE')->today();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function today() with a custom but invalid datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::today
     */
    public function testTodayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->today());
    }

    /**
     * Test the function now() with the default datetime format.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->now());
    }

    /**
     * Test the function now() with a custom datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->now());
    }

    /**
     * Test the function now() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithLocalizedCustomDatetimeFormat()
    {
        $day = strftime('%u');
        $localized_day = $this->datetime->set_datetime_format('%A')->set_locale('de_DE')->now();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function now() with a custom but invalid datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->now());
    }

}

?>
