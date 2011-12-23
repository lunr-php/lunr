<?php

use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    private $datetime;

    /**
     * Reflection instance of the DateTime class.
     * @var ReflectionClass
     */
    private $reflection_datetime;

    public function setUp()
    {
        $this->reflection_datetime = new ReflectionClass('Lunr\Libraries\Core\DateTime');
        $this->datetime = new DateTime();
    }

    public function tearDown()
    {
        unset($this->datetime);
        unset($this->reflection_datetime);
    }

    /**
     * Check that default DateTime format is as expected.
     */
    public function testDefaultDatetimeFormat()
    {
        $datetime_format = $this->reflection_datetime->getProperty('datetime_format');
        $datetime_format->setAccessible(TRUE);
        $this->assertEquals('%Y-%m-%d', $datetime_format->getValue($this->datetime));
    }

    /**
     * Test the set_datetime_format() method.
     *
     * @dataProvider datetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::set_datetime_format
     */
    public function testSetCustomDatetimeFormat($format)
    {
        $datetime_format = $this->reflection_datetime->getProperty('datetime_format');
        $datetime_format->setAccessible(TRUE);
        $this->datetime->set_datetime_format($format);
        $this->assertEquals($format, $datetime_format->getValue($this->datetime));
    }

    /**
     * Check that default Locale is as expected.
     */
    public function testDefaultLocale()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->assertEquals('en_US.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, without charset supplied.
     *
     * @runInSeparateProcess
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithDefaultCharset()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale('de_DE');
        $this->assertEquals('de_DE.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('de_DE.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, with charset supplied.
     *
     * @runInSeparateProcess
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithCustomCharset()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale('de_DE', 'ISO-8859-1');
        $this->assertEquals('de_DE.ISO-8859-1', $locale->getValue($this->datetime));
        $this->assertEquals('de_DE.ISO-8859-1', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method with invalid locale values, without charset supplied.
     *
     * @runInSeparateProcess
     * @depends testDefaultLocale
     * @dataProvider invalidLocaleProvider
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomInvalidLocaleWithDefaultCharset($value)
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale($value);
        $this->assertEquals('en_US.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the function today() with the default datetime format.
     *
     * @depends testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::today
     */
    public function testTodayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->today());
    }

    /**
     * Test the function today() with a custom datetime format and default locale.
     *
     * @depends testSetCustomDatetimeFormat
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
     * @depends testSetCustomDatetimeFormat
     * @depends testSetCustomLocaleWithDefaultCharset
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
     * @depends testSetCustomDatetimeFormat
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
     * @depends testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->now());
    }

    /**
     * Test the function now() with a custom datetime format and default locale.
     *
     * @depends testSetCustomDatetimeFormat
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
     * @depends testSetCustomDatetimeFormat
     * @depends testSetCustomLocaleWithDefaultCharset
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
     * @depends testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::now
     */
    public function testNowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->now());
    }

    /**
     * Test the function yesterday() with the default datetime format.
     *
     * @depends testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime("-1 day")), $this->datetime->yesterday());
    }

    /**
     * Test the function yesterday() with a custom datetime format and default locale.
     *
     * @depends testSetCustomDatetimeFormat
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
     * @depends testSetCustomDatetimeFormat
     * @depends testSetCustomLocaleWithDefaultCharset
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
     * @depends testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::yesterday
     */
    public function testYesterdayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->yesterday());
    }

    /**
     * Test the function tomorrow() with the default datetime format.
     *
     * @depends testDefaultDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::tomorrow
     */
    public function testTomorrowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime("+1 day")), $this->datetime->tomorrow());
    }

    /**
     * Test the function tomorrow() with a custom datetime format and default locale.
     *
     * @depends testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::tomorrow
     */
    public function testTomorrowWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y', strtotime("+1 day")), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->tomorrow());
    }

    /**
     * Test the function tomorrow() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     * @depends testSetCustomDatetimeFormat
     * @depends testSetCustomLocaleWithDefaultCharset
     * @covers Lunr\Libraries\Core\DateTime::tomorrow
     */
    public function testTomorrowWithLocalizedCustomDatetimeFormat()
    {
        $day = strftime('%u', strtotime("+1 day"));
        $localized_day = $this->datetime->set_datetime_format('%A')->set_locale('de_DE')->tomorrow();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function tomorrow() with a custom but invalid datetime format and default locale.
     *
     * @depends testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::tomorrow
     */
    public function testTomorrowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->tomorrow());
    }

    /**
     * Test get_delayed_timestamp() with the current timestamp as base.
     *
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCurrentTimestampAsBase()
    {
        $this->assertEquals(strtotime("+1 day"), $this->datetime->get_delayed_timestamp("+1 day"));
    }

    /**
     * Test get_delayed_timestamp() with a custom timestamp as base.
     *
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomTimestampAsBase($base)
    {
        $this->assertEquals(strtotime("+1 day", $base), $this->datetime->get_delayed_timestamp("+1 day", $base));
    }

    /**
     * Test get_delayed_timestamp() with a custom but invalid timestamp as base.
     *
     * @dataProvider invalidTimestampProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithCustomInvalidTimestampAsBase($base)
    {
        $this->assertFalse($this->datetime->get_delayed_timestamp("+1 day", $base));
    }

    /**
     * Test get_delayed_timestamp() with a valid delay and current timestamp as base.
     *
     * @dataProvider validDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithValidDelay($delay)
    {
        $this->assertEquals(strtotime($delay), $this->datetime->get_delayed_timestamp($delay));
    }

    /**
     * Test get_delayed_timestamp() with an invalid delay and current timestamp as base.
     *
     * @dataProvider invalidDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_timestamp
     */
    public function testGetDelayedTimestampWithInvalidDelay($delay)
    {
        $this->assertFalse($this->datetime->get_delayed_timestamp($delay));
    }

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
     * @depends testSetCustomDatetimeFormat
     * @covers Lunr\Libraries\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->get_datetime());
    }

    /**
     * Test get_datetime() with a custom but invalid datetime format and current timestamp as base.
     *
     * @depends testSetCustomDatetimeFormat
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
     * @depends testSetCustomDatetimeFormat
     * @depends testSetCustomLocaleWithDefaultCharset
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
     * @dataProvider timestampProvider
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

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom timestamp as base.
     *
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
     * @depends testDefaultDatetimeFormat
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
     * @dataProvider invalidDelayProvider
     * @covers Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithInvalidDelay($delay)
    {
        $this->assertFalse($this->datetime->get_delayed_datetime($delay));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider equalDatetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsEqual($date1, $date2)
    {
        $this->assertEquals(0, $this->datetime->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsLower($date1, $date2)
    {
        $this->assertEquals(-1, $this->datetime->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsGreater($date1, $date2)
    {
        $this->assertEquals(1, $this->datetime->sort_compare_datetime($date2, $date1));
    }

    private function check_localized_day($day, $localized_day)
    {
        switch ($day)
        {
            case 1:
                $this->assertEquals('Montag', $localized_day);
                break;
            case 2:
                $this->assertEquals('Dienstag', $localized_day);
                break;
            case 3:
                $this->assertEquals('Mittwoch', $localized_day);
                break;
            case 4:
                $this->assertEquals('Donnerstag', $localized_day);
                break;
            case 5:
                $this->assertEquals('Freitag', $localized_day);
                break;
            case 6:
                $this->assertEquals('Samstag', $localized_day);
                break;
            case 7:
                $this->assertEquals('Sonntag', $localized_day);
                break;
            default:
                return FALSE;
        }
        return TRUE;
    }


    public function timestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array(time());
        $timestamps[] = array(strtotime("+30 minutes"));
        $timestamps[] = array(strtotime("+1 week"));

        return $timestamps;
    }

    public function invalidTimestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array('String');
        $timestamps[] = array(FALSE);
        $timestamps[] = array(NULL);

        return $timestamps;
    }

    public function validDelayProvider()
    {
        $delay   = array();
        $delay[] = array('+1 day');
        $delay[] = array('-1 week');
        $delay[] = array('+1 month');
        $delay[] = array('-1 year');
        $delay[] = array('2011-10-10');

        return $delay;
    }

    public function invalidDelayProvider()
    {
        $delay   = array();
        $delay[] = array('');
        $delay[] = array('String');
        $delay[] = array(NULL);
        $delay[] = array(FALSE);

        return $delay;
    }

    public function equalDatetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-02"), array("13:20","13:20"));
    }

    public function datetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-03"), array("10:20", "15:15"), array("2010-02-02 13:10", "2010-02-02-15:10"));
    }

    public function datetimeFormatProvider()
    {
        $formats = $this->invalidDatetimeFormatProvider();
        $formats[] = array('%A');

        return $formats;
    }

    public function invalidDatetimeFormatProvider()
    {
        $formats   = array();
        $formats[] = array('');
        $formats[] = array(10);
        $formats[] = array('String');
        $formats[] = array(FALSE);
        $formats[] = array(NULL);

        return $formats;
    }

    public function invalidLocaleProvider()
    {
        $locales   = array();
        $locales[] = array('');
        $locales[] = array(10);
        $locales[] = array('String');
        $locales[] = array(FALSE);
        $locales[] = array(NULL);

        return $locales;
    }

}

?>
