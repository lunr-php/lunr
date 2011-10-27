<?php

use Lunr\Libraries\Core\M2DateTime;

/**
 * This tests Lunr's M2DateTime class
 * @covers Lunr\Libraries\Core\M2DateTime
 */
class M2DateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function today()
     * @covers Lunr\Libraries\Core\M2DateTime::today
     */
    public function testToday()
    {
        $this->assertEquals(date("Y-m-d"), M2DateTime::today());
    }

    /**
     * Test the static function yesterday()
     * @covers Lunr\Libraries\Core\M2DateTime::yesterday
     */
    public function testYesterday()
    {
        $this->assertEquals(date("Y-m-d", strtotime("-1 day")), M2DateTime::yesterday());
    }

    /**
     * Test the static function tomorrow()
     * @covers Lunr\Libraries\Core\M2DateTime::tomorrow
     */
    public function testTomorrow()
    {
        $this->assertEquals(date("Y-m-d", strtotime("+1 day")), M2DateTime::tomorrow());
    }

    /**
     * Test the static function delayed_date()
     * @depends testTomorrow
     * @depends testYesterday
     * @covers Lunr\Libraries\Core\M2DateTime::delayed_date
     */
    public function testDelayedDate()
    {
        $this->assertEquals(M2DateTime::yesterday(), M2DateTime::delayed_date("-1 day"));
        $this->assertEquals(M2DateTime::tomorrow(), M2DateTime::delayed_date("+1 day"));
    }

    /**
     * Test the static function delayed_timestamp()
     * @covers Lunr\Libraries\Core\M2DateTime::delayed_timestamp
     */
    public function testDelayedTimestamp()
    {
        $this->assertEquals(strtotime("+1 day"), M2DateTime::delayed_timestamp("+1 day"));
    }

    /**
     * Test the static function delayed_datetime()
     * @depends testDelayedTimestamp
     * @covers Lunr\Libraries\Core\M2DateTime::delayed_datetime
     */
    public function testDelayedDatetime()
    {
        $timestamp = M2DateTime::delayed_timestamp("+1 day");
        $this->assertEquals(date('Y-m-d H:i:s', strtotime("+1 day", time())), M2DateTime::delayed_datetime("+1 day"));
        $this->assertEquals(date('Y-m-d H:i:s', strtotime("+2 days")), M2DateTime::delayed_datetime("+1 day", $timestamp));
    }

   /**
    * Test the static function delayed_text_date()
    * @depends testDelayedTimestamp
    * @covers Lunr\Libraries\Core\M2DateTime::delayed_text_date
    */
    public function testDelayedTextDate()
    {
        $timestamp = M2DateTime::delayed_timestamp("+1 day");
        $this->assertEquals(ucwords(strftime('%d %B, %Y', strtotime("+1 day", time()))), M2DateTime::delayed_text_date("+1 day"));
        $this->assertEquals(ucwords(strftime('%d %B, %Y', strtotime("+2 days"))), M2DateTime::delayed_text_date("+1 day", 'en_US', $timestamp));
        $timestamp = M2DateTime::delayed_timestamp("2011-10-07 15:00:00");
        $this->assertEquals("07 Settembre, 2011", M2DateTime::delayed_text_date("-1 month", "it_IT", $timestamp));
    }

    /**
     * Test the static function now()
     * @covers Lunr\Libraries\Core\M2DateTime::now
     */
    public function testNow()
    {
        $this->assertEquals(strftime("%H:%M:%S", time()), M2DateTime::now());
    }

    /**
     * Test the static function get_short_textmonth()
     * @covers Lunr\Libraries\Core\M2DateTime::get_short_textmonth
     * @runInSeparateProcess
     */
    public function testGetShortTextMonth()
    {
        $timestamp = strtotime('2011-09-29');
        $this->assertEquals(strtoupper(strftime('%b')), M2DateTime::get_short_textmonth());
        $this->assertEquals('SEP', M2DateTime::get_short_textmonth($timestamp));
        $this->assertEquals('WRZ', M2DateTime::get_short_textmonth($timestamp, 'pl_PL'));
    }

    /**
     * Test the static function get_date()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\M2DateTime::get_date
     */
    public function testGetDate($timestamp)
    {
        $this->assertEquals(date("Y-m-d", $timestamp), M2DateTime::get_date($timestamp));
    }

    /**
     * Test the static function get_time()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\M2DateTime::get_time
     */
    public function testGetTime($timestamp)
    {
        $this->assertEquals(strftime("%H:%M:%S", $timestamp), M2DateTime::get_time($timestamp));
    }

    /**
     * Test the static function get_datetime()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers Lunr\Libraries\Core\M2DateTime::get_datetime
     */
    public function testGetDatetimeTimestamp($timestamp)
    {
        $this->assertEquals(date("Y-m-d H:i", $timestamp), M2DateTime::get_datetime($timestamp));
    }

    /**
     * Test the static function get_datetime()
     * @depends testDelayedTimestamp
     * @covers Lunr\Libraries\Core\M2DateTime::get_datetime
     */
    public function testGetDatetimeNow()
    {
        $this->assertEquals(date("Y-m-d H:i"), M2DateTime::get_datetime());
    }

    /**
     * Test the static function get_short_date()
     * @depends testDelayedTimestamp
     * @covers Lunr\Libraries\Core\M2DateTime::get_short_date
     * @runInSeparateProcess
     */
    public function testGetShortDate()
    {
        $timestamp = M2DateTime::delayed_timestamp("2011-02-28 10:00:00");
        $this->assertEquals(strtoupper(strftime('%d %b')), M2DateTime::get_short_date());
        $this->assertEquals("28 FEB", M2DateTime::get_short_date($timestamp));
        $this->assertEquals("28 LUT", M2DateTime::get_short_date($timestamp, "pl_PL"));
    }

    /**
     * Test the static function get_text_date()
     * @depends testDelayedTimestamp
     * @covers Lunr\Libraries\Core\M2DateTime::get_text_date
     * @runInSeparateProcess
     */
    public function testGetTextDate()
    {
        $timestamp = M2DateTime::delayed_timestamp("2011-08-04 15:00:00");
        $this->assertEquals(ucwords(strftime('%d %B, %Y')), M2DateTime::get_text_date());
        $this->assertEquals("04 August, 2011", M2DateTime::get_text_date($timestamp));
        $this->assertEquals("04 Agost, 2011", M2DateTime::get_text_date($timestamp, "ca_ES"));
    }

    /**
     * Test the static function is_time()
     * @dataProvider validTimeProvider
     * @covers Lunr\Libraries\Core\M2DateTime::is_time
     */
    public function testIsValidTime($time)
    {
        $this->assertTrue(M2DateTime::is_time($time));
    }

    /**
     * Test the static function is_time()
     * @dataProvider invalidTimeProvider
     * @covers Lunr\Libraries\Core\M2DateTime::is_time
     */
    public function testIsInvalidTime($time)
    {
        $this->assertFalse(M2DateTime::is_time($time));
    }

    /**
     * Test the static function is_date()
     * @dataProvider validDateProvider
     * @covers Lunr\Libraries\Core\M2DateTime::is_date
     */
    public function testIsValidDate($date)
    {
        $this->assertTrue(M2DateTime::is_date($date));
    }

    /**
     * Test the static function is_date()
     * @dataProvider invalidDateProvider
     * @covers Lunr\Libraries\Core\M2DateTime::is_date
     */
    public function testIsInvalidDate($date)
    {
        $this->assertFalse(M2DateTime::is_date($date));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider equalDatetimeProvider
     * @covers Lunr\Libraries\Core\M2DateTime::sort_compare_datetime
     */
    public function testDatetimeIsEqual($date1, $date2)
    {
        $this->assertEquals(0, M2DateTime::sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\M2DateTime::sort_compare_datetime
     */
    public function testDatetimeIsLower($date1, $date2)
    {
        $this->assertEquals(-1, M2DateTime::sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\M2DateTime::sort_compare_datetime
     */
    public function testDatetimeIsGreater($date1, $date2)
    {
        $this->assertEquals(1, M2DateTime::sort_compare_datetime($date2, $date1));
    }

    public function timestampProvider()
    {
        return array(
                array(strtotime("+30 minutes")),
                array(strtotime("+1 week"))
                );
    }

    public function validTimeProvider()
    {
        return array(array("23:30"), array("23:30:01"), array("23:30:21"), array("30:10"), array("124:10:23"));
    }

    public function invalidTimeProvider()
    {
        return array(array("23:20:67"), array("23:61"), array("30:61"), array("30:61:10"), array("1345:10"));
    }

    public function validDateProvider()
    {
        return array(array("2010-02-10"), array("1-01-02"), array("2096-02-29"), array("2011-01-31"),
                    array("2400-02-29")
                    );
    }

    public function invalidDateProvider()
    {
        return array(array("string"), array("1020367"), array(FALSE), array("2010-02-30"), array("2010-13-10"),
                    array("2011-04-31"), array("2095-02-29"), array("2100-02-29"), array("2200-02-29")
                    );
    }

    public function equalDatetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-02"), array("13:20","13:20"));
    }

    public function datetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-03"), array("10:20", "15:15"), array("2010-02-02 13:10", "2010-02-02-15:10"));
    }

}

?>
