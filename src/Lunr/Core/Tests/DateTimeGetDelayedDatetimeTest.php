<?php

/**
 * This file contains the DateTimeGetDelayedDatetimeTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\DateTime;

/**
 * This class contains the tests for the get_delayed_datetime() method
 *
 * @covers     Lunr\Core\DateTime
 */
class DateTimeGetDelayedDatetimeTest extends DateTimeTest
{

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom timestamp as base.
     *
     * @param integer $timestamp UNIX Timestamp
     *
     * @depends      Lunr\Core\Tests\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider validTimestampProvider
     * @covers       Lunr\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomTimestampAsBase($timestamp): void
    {
        $value = $this->class->get_delayed_datetime('+1 day', $timestamp);
        $this->assertEquals(strftime('%Y-%m-%d', strtotime('+1 day', $timestamp)), $value);
    }

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom but invalid timestamp as base.
     *
     * @param mixed $timestamp Various invalid timestamp values
     *
     * @dataProvider invalidTimestampProvider
     * @covers       Lunr\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomInvalidTimestampAsBase($timestamp): void
    {
        $this->assertFalse($this->class->get_delayed_datetime('+1 day', $timestamp));
    }

    /**
     * Test get_delayed_datetime() with a valid delay, default datetime format and current timestamp as base.
     *
     * @param string $delay Various valid delay definitions
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testDefaultDatetimeFormat
     * @depends      Lunr\Core\Tests\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider validDelayProvider
     * @covers       Lunr\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithValidDelay($delay): void
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime($delay)), $this->class->get_delayed_datetime($delay));
    }

    /**
     * Test get_delayed_datetime() with an invalid delay, default datetime format and current timestamp as base.
     *
     * @param mixed $delay Various invalid delay definitions
     *
     * @depends      Lunr\Core\Tests\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider invalidDelayProvider
     * @covers       Lunr\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithInvalidDelay($delay): void
    {
        $this->assertFalse($this->class->get_delayed_datetime($delay));
    }

}

?>
