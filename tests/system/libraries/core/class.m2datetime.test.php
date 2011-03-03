<?php

require_once("class.m2datetime.inc.php");

/**
 * This tests Lunr's M2DateTime class
 * @covers M2DateTime
 */
class M2DateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the static function today()
     * @covers M2DateTime::today
     */
    public function testToday()
    {
        $this->assertEquals(M2DateTime::today(), date("Y-m-d"));
    }

    /**
     * Test the static function yesterday()
     * @covers M2DateTime::yesterday
     */
    public function testYesterday()
    {
        $this->assertEquals(M2DateTime::yesterday(), date("Y-m-d", strtotime("-1 day")));
    }

    /**
     * Test the static function tomorrow()
     * @covers M2DateTime::tomorrow
     */
    public function testTomorrow()
    {
        $this->assertEquals(M2DateTime::tomorrow(), date("Y-m-d", strtotime("+1 day")));
    }

    /**
     * Test the static function delayed_date()
     * @depends testTomorrow
     * @depends testYesterday
     * @covers M2DateTime::delayed_date
     */
    public function testDelayedDate()
    {
        $this->assertEquals(M2DateTime::delayed_date("-1 day"), M2DateTime::yesterday());
        $this->assertEquals(M2DateTime::delayed_date("+1 day"), M2DateTime::tomorrow());
    }

    /**
     * Test the static function delayed_timestamp()
     * @covers M2DateTime::delayed_timestamp
     */
    public function testDelayedTimestamp()
    {
        $this->assertEquals(M2DateTime::delayed_timestamp("+1 day"), strtotime("+1 day"));
    }

    /**
     * Test the static function now()
     * @covers M2DateTime::now
     */
    public function testNow()
    {
        $this->assertEquals(M2DateTime::now(), strftime("%H:%M:%S", time()));
    }

    /**
     * Test the static function get_date()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers M2DateTime::get_date
     */
    public function testGetDate($timestamp)
    {
        $this->assertEquals(M2DateTime::get_date($timestamp), date("Y-m-d", $timestamp));
    }

    /**
     * Test the static function get_time()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers M2DateTime::get_time
     */
    public function testGetTime($timestamp)
    {
        $this->assertEquals(M2DateTime::get_time($timestamp), strftime("%H:%M:%S", $timestamp));
    }

    /**
     * Test the static function get_datetime()
     * @depends testDelayedTimestamp
     * @dataProvider timestampProvider
     * @covers M2DateTime::get_datetime
     */
    public function testGetDatetimeTimestamp($timestamp)
    {
        $this->assertEquals(M2DateTime::get_datetime($timestamp), date("Y-m-d H:i", $timestamp));
    }

    /**
     * Test the static function get_datetime()
     * @depends testDelayedTimestamp
     * @covers M2DateTime::get_datetime
     */
    public function testGetDatetimeNow()
    {
        $this->assertEquals(M2DateTime::get_datetime(), date("Y-m-d H:i"));
    }

    /**
     * Test the static function get_human_readable_date_short()
     * @depends testDelayedTimestamp
     * @covers M2DateTime::get_human_readable_date_short
     */
    public function testGetHumanReadableDateShort()
    {
        $timestamp = M2DateTime::delayed_timestamp("2011-02-28 10:00:00");
        $this->assertEquals(M2DateTime::get_human_readable_date_short(), strtoupper(strftime('%d %b')));
        $this->assertEquals(M2DateTime::get_human_readable_date_short($timestamp), "28 FEB");
        $this->assertEquals(M2DateTime::get_human_readable_date_short($timestamp, "fr_FR.utf8"), "28 FéVR.");
    }

    /**
     * Test the static function is_time()
     * @dataProvider validTimeProvider
     * @covers M2DateTime::is_time
     */
    public function testIsValidTime($time)
    {
        $this->assertTrue(M2DateTime::is_time($time));
    }

    /**
     * Test the static function is_time()
     * @dataProvider invalidTimeProvider
     * @covers M2DateTime::is_time
     */
    public function testIsInvalidTime($time)
    {
        $this->assertFalse(M2DateTime::is_time($time));
    }

    /**
     * Test the static function is_date()
     * @dataProvider validDateProvider
     * @covers M2DateTime::is_date
     */
    public function testIsValidDate($date)
    {
        $this->assertTrue(M2DateTime::is_date($date));
    }

    /**
     * Test the static function is_date()
     * @dataProvider invalidDateProvider
     * @covers M2DateTime::is_date
     */
    public function testIsInvalidDate($date)
    {
        $this->assertFalse(M2DateTime::is_date($date));
    }

    public function timestampProvider()
    {
        return array(
                array(M2DateTime::delayed_timestamp("+30 minutes")),
                array(M2DateTime::delayed_timestamp("+1 week"))
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
        return array(array("2010-02-10"), array("923-01-02"));
    }

    public function invalidDateProvider()
    {
        return array(array("string"), array("1020367"), array(FALSE), array("2010-02-30"), array("2010-13-10"));
    }
}

?>
