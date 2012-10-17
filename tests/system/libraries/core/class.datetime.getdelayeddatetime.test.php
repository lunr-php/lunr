<?php

/**
 * This file contains the DateTimeGetDelayedDatetimeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * This class contains the tests for the get_delayed_datetime() method
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\DateTime
 */
class DateTimeGetDelayedDatetimeTest extends DateTimeTest
{

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom timestamp as base.
     *
     * @param Integer $timestamp UNIX Timestamp
     *
     * @depends      Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider validTimestampProvider
     * @covers       Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomTimestampAsBase($timestamp)
    {
        $value = $this->datetime->get_delayed_datetime('+1 day', $timestamp);
        $this->assertEquals(strftime('%Y-%m-%d', strtotime('+1 day', $timestamp)), $value);
    }

    /**
     * Test get_delayed_datetime() with the default datetime format and a custom but invalid timestamp as base.
     *
     * @param mixed $timestamp Various invalid timestamp values
     *
     * @dataProvider invalidTimestampProvider
     * @covers       Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithCustomInvalidTimestampAsBase($timestamp)
    {
        $this->assertFalse($this->datetime->get_delayed_datetime('+1 day', $timestamp));
    }

    /**
     * Test get_delayed_datetime() with a valid delay, default datetime format and current timestamp as base.
     *
     * @param String $delay Various valid delay definitions
     *
     * @depends      Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @depends      Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider validDelayProvider
     * @covers       Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithValidDelay($delay)
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime($delay)), $this->datetime->get_delayed_datetime($delay));
    }

    /**
     * Test get_delayed_datetime() with an invalid delay, default datetime format and current timestamp as base.
     *
     * @param mixed $delay Various invalid delay definitions
     *
     * @depends      Lunr\Libraries\Core\DateTimeGetDateTimeTest::testGetDatetimeWithCustomTimestampAsBase
     * @dataProvider invalidDelayProvider
     * @covers       Lunr\Libraries\Core\DateTime::get_delayed_datetime
     */
    public function testGetDelayedDatetimeWithInvalidDelay($delay)
    {
        $this->assertFalse($this->datetime->get_delayed_datetime($delay));
    }

}

?>
