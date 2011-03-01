<?php

require_once(str_replace("tests", "", dirname(__FILE__)) . "/class.m2datetime.inc.php");

/**
 * This tests Lunr's M2DateTime class
 * @author Heinz Wiesinger
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
     * @covers M2DateTime::get_date
     */
    public function testGetDate()
    {
        $timestamp = M2DateTime::delayed_timestamp("+30 minutes");
        $timestamp2 = M2DateTime::delayed_timestamp("+1 week");
        $this->assertEquals(M2DateTime::get_date($timestamp), date("Y-m-d", $timestamp));
        $this->assertEquals(M2DateTime::get_date($timestamp2), date("Y-m-d", $timestamp2));
    }

    /**
     * Test the static function get_time()
     * @depends testDelayedTimestamp
     * @covers M2DateTime::get_time
     */
    public function testGetTime()
    {
        $timestamp = M2DateTime::delayed_timestamp("+30 minutes");
        $timestamp2 = M2DateTime::delayed_timestamp("+1 week");
        $this->assertEquals(M2DateTime::get_time($timestamp), strftime("%H:%M:%S", $timestamp));
        $this->assertEquals(M2DateTime::get_time($timestamp2), strftime("%H:%M:%S", $timestamp2));
    }

    /**
     * Test the static function get_datetime()
     * @depends testDelayedTimestamp
     * @covers M2DateTime::get_datetime
     */
    public function testGetDateTime()
    {
        $timestamp = M2DateTime::delayed_timestamp("+30 minutes");
        $timestamp2 = M2DateTime::delayed_timestamp("+1 week");
        $this->assertEquals(M2DateTime::get_datetime(), date("Y-m-d H:i"));
        $this->assertEquals(M2DateTime::get_datetime($timestamp), date("Y-m-d H:i", $timestamp));
        $this->assertEquals(M2DateTime::get_datetime($timestamp2), date("Y-m-d H:i", $timestamp2));
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
     * @covers M2DateTime::is_time
     */
    public function testIsValidTime()
    {
        $this->assertTrue(M2DateTime::is_time("23:30"));
        $this->assertTrue(M2DateTime::is_time("23:30:01"));
        $this->assertTrue(M2DateTime::is_time("23:30:21"));
    }

    /**
     * Test the static function is_time()
     * @covers M2DateTime::is_time
     */
    public function testIsInvalidTime()
    {
        $this->assertFalse(M2DateTime::is_time("23:20:67"));
        $this->assertFalse(M2DateTime::is_time("23:61"));
        $this->assertFalse(M2DateTime::is_time("30:61"));
        $this->assertFalse(M2DateTime::is_time("30:61:10"));
        $this->assertFalse(M2DateTime::is_time("30:10"));
    }
}

?>
