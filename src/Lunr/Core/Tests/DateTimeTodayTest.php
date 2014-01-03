<?php

/**
 * This file contains the DateTimeTodayTest class.
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
 * This class contains the tests for the today() and now() methods
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\DateTime
 */
class DateTimeTodayTest extends DateTimeTest
{

    /**
     * Test the function today() with the default datetime format.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Core\DateTime::today
     */
    public function testTodayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->class->today());
    }

    /**
     * Test the function today() with a custom datetime format and default locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Core\DateTime::today
     */
    public function testTodayWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->class->set_datetime_format('%A. %d.%m.%Y')->today());
    }

    /**
     * Test the function today() with a custom datetime format and custom locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Core\DateTime::today
     */
    public function testTodayWithLocalizedCustomDatetimeFormat()
    {
        $day           = strftime('%u');
        $localized_day = $this->class->set_datetime_format('%A')->set_locale('de_DE')->today();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function today() with a custom but invalid datetime format and default locale.
     *
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Core\DateTime::today
     */
    public function testTodayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->class->set_datetime_format($format)->today());
    }

    /**
     * Test the function now() with the default datetime format.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Core\DateTime::now
     */
    public function testNowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->class->now());
    }

    /**
     * Test the function now() with a custom datetime format and default locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Core\DateTime::now
     */
    public function testNowWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->class->set_datetime_format('%A. %d.%m.%Y')->now());
    }

    /**
     * Test the function now() with a custom datetime format and custom locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Core\DateTime::now
     */
    public function testNowWithLocalizedCustomDatetimeFormat()
    {
        $day           = strftime('%u');
        $localized_day = $this->class->set_datetime_format('%A')->set_locale('de_DE')->now();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function now() with a custom but invalid datetime format and default locale.
     *
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Core\DateTime::now
     */
    public function testNowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->class->set_datetime_format($format)->now());
    }

}

?>
