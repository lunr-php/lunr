<?php

/**
 * This file contains the DateTimeTomorrowTest class.
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
 * This class contains the tests for the tomorrow() method
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\DateTime
 */
class DateTimeTomorrowTest extends DateTimeTest
{

    /**
     * Test the function tomorrow() with the default datetime format.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testDefaultDatetimeFormat
     * @covers  Lunr\Core\DateTime::tomorrow
     */
    public function testTomorrowWithDefaultDatetimeFormat()
    {
        $this->assertEquals(strftime('%Y-%m-%d', strtotime('+1 day')), $this->class->tomorrow());
    }

    /**
     * Test the function tomorrow() with a custom datetime format and default locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @covers  Lunr\Core\DateTime::tomorrow
     */
    public function testTomorrowWithCustomDatetimeFormat()
    {
        $value = $this->class->set_datetime_format('%A. %d.%m.%Y')->tomorrow();
        $this->assertEquals(strftime('%A. %d.%m.%Y', strtotime('+1 day')), $value);
    }

    /**
     * Test the function tomorrow() with a custom datetime format and custom locale.
     *
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @depends Lunr\Core\Tests\DateTimeBaseTest::testSetCustomLocaleWithDefaultCharset
     * @covers  Lunr\Core\DateTime::tomorrow
     */
    public function testTomorrowWithLocalizedCustomDatetimeFormat()
    {
        $day           = strftime('%u', strtotime('+1 day'));
        $localized_day = $this->class->set_datetime_format('%A')->set_locale('de_DE')->tomorrow();
        $this->assertTrue($this->check_localized_day($day, $localized_day));
    }

    /**
     * Test the function tomorrow() with a custom but invalid datetime format and default locale.
     *
     * @param mixed $format DateTime format
     *
     * @depends      Lunr\Core\Tests\DateTimeBaseTest::testSetCustomDatetimeFormat
     * @dataProvider invalidDatetimeFormatProvider
     * @covers       Lunr\Core\DateTime::tomorrow
     */
    public function testTomorrowWithCustomInvalidDatetimeFormat($format)
    {
        $this->assertEquals($format, $this->class->set_datetime_format($format)->tomorrow());
    }

}

?>
