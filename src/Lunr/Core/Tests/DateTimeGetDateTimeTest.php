<?php

/**
 * This file contains the DateTimeGetDateTimeTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\DateTime;

/**
 * This class contains the tests for the get_datetime() method
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\DateTime
 */
class DateTimeGetDateTimeTest extends DateTimeTest
{

    /**
     * Test get_datetime() with the default datetime format and current timestamp as base.
     *
     * @covers Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->class->get_datetime());
    }

    /**
     * Test get_datetime() with a custom datetime format and current timestamp as base.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomDatetimeFormat()
    {
        $value = $this->class->set_datetime_format('%A. %d.%m.%Y')->get_datetime();
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $value);
    }

    /**
     * Test get_datetime() with a custom but invalid datetime format and current timestamp as base.
     *
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->class->set_datetime_format($format)->get_datetime());
    }

    /**
     * Test get_datetime() with a custom datetime format, custom locale and current timestamp as base.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithLocalizedCustomDatetimeFormat()
    {
        $day           = strftime('%u');
        $localized_day = $this->class->set_datetime_format('%A')->set_locale('de_DE')->get_datetime();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test get_datetime() with the default datetime format and a custom timestamp as base.
     *
     * @param Integer $timestamp UNIX Timestamp
     *
     * @dataProvider validTimestampProvider
     * @covers       Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomTimestampAsBase($timestamp)
    {
        $this->assertEquals(strftime('%Y-%m-%d', $timestamp), $this->class->get_datetime($timestamp));
    }

    /**
     * Test get_datetime() with the default datetime format and a custom but invalid timestamp as base.
     *
     * @param mixed $timestamp Various invalid timestamp values
     *
     * @dataProvider invalidTimestampProvider
     * @covers       Lunr\Core\DateTime::get_datetime
     */
    public function testGetDatetimeWithCustomInvalidTimestampAsBase($timestamp)
    {
        $this->assertFalse($this->class->get_datetime($timestamp));
    }

}

?>
