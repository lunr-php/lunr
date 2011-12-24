<?php

/**
 * This file contains the DateTimeTodayTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     M2Mobi <info@m2mobi.com>
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 */

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This class contains the tests for the today() and now() methods
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\DateTime
 */
class DateTimeTodayTest extends DateTimeTest
{

    /**
     * Test the function today() with the default datetime format.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Libraries\Core\DateTime::today
     *
     * @return void
     */
    public function testTodayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->today());
    }

    /**
     * Test the function today() with a custom datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Libraries\Core\DateTime::today
     *
     * @return void
     */
    public function testTodayWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->today());
    }

    /**
     * Test the function today() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Libraries\Core\DateTime::today
     *
     * @return void
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
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Libraries\Core\DateTime::today
     *
     * @return void
     */
    public function testTodayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->today());
    }

    /**
     * Test the function now() with the default datetime format.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Libraries\Core\DateTime::now
     *
     * @return void
     */
    public function testNowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d'), $this->datetime->now());
    }

    /**
     * Test the function now() with a custom datetime format and default locale.
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Libraries\Core\DateTime::now
     *
     * @return void
     */
    public function testNowWithCustomDatetimeFormat()
    {
        $this->assertEquals(strftime('%A. %d.%m.%Y'), $this->datetime->set_datetime_format('%A. %d.%m.%Y')->now());
    }

    /**
     * Test the function now() with a custom datetime format and custom locale.
     *
     * @runInSeparateProcess
     *
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Libraries\Core\DateTime::now
     *
     * @return void
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
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Libraries\Core\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Libraries\Core\DateTime::now
     *
     * @return void
     */
    public function testNowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->datetime->set_datetime_format($format)->now());
    }

}

?>
