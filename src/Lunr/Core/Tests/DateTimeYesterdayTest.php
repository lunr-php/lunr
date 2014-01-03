<?php

/**
 * This file contains the DateTimeYesterdayTest class.
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
 * This class contains the tests for the yesterday() method
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Libraries
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\DateTime
 */
class DateTimeYesterdayTest extends DateTimeTest
{

    /**
     * Test the function yesterday() with the default datetime format.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Core\DateTime::yesterday
     */
    public function testYesterdayWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime('-1 day')), $this->class->yesterday());
    }

    /**
     * Test the function yesterday() with a custom datetime format and default locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Core\DateTime::yesterday
     */
    public function testYesterdayWithCustomDatetimeFormat()
    {
        $value = $this->class->set_datetime_format('%A. %d.%m.%Y')->yesterday();
        $this->assertEquals(strftime('%A. %d.%m.%Y', strtotime('-1 day')), $value);
    }

    /**
     * Test the function yesterday() with a custom datetime format and custom locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Core\DateTime::yesterday
     */
    public function testYesterdayWithLocalizedCustomDatetimeFormat()
    {
        $day           = strftime('%u', strtotime('-1 day'));
        $localized_day = $this->class->set_datetime_format('%A')->set_locale('de_DE')->yesterday();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function yesterday() with a custom but invalid datetime format and default locale.
     *
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Core\DateTime::yesterday
     */
    public function testYesterdayWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->class->set_datetime_format($format)->yesterday());
    }

}

?>
