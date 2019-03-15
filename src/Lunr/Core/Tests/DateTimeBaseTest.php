<?php

/**
 * This file contains the DateTimeBaseTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Core\Tests;

use Lunr\Core\DateTime;

/**
 * This class contains the tests for the setters and the
 * sorting method.
 *
 * @covers     Lunr\Core\DateTime
 */
class DateTimeBaseTest extends DateTimeTest
{

    /**
     * Check that default DateTime format is as expected.
     */
    public function testDefaultDatetimeFormat(): void
    {
        $this->assertPropertyEquals('datetime_format', '%Y-%m-%d');
    }

    /**
     * Test the set_datetime_format() method.
     *
     * @param mixed $format DateTime format definition
     *
     * @dataProvider datetimeFormatProvider
     * @covers       Lunr\Core\DateTime::set_datetime_format
     */
    public function testSetCustomDatetimeFormat($format): void
    {
        $this->class->set_datetime_format($format);
        $this->assertPropertyEquals('datetime_format', $format);
    }

    /**
     * Check that default Locale is as expected.
     */
    public function testDefaultLocale(): void
    {
        $this->assertPropertyEquals('locale', 'en_US.UTF-8');
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, without charset supplied.
     *
     * @covers Lunr\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithDefaultCharset(): void
    {
        $this->class->set_locale('de_DE');
        $this->assertPropertyEquals('locale', 'de_DE.UTF-8');
        $this->assertEquals('de_DE.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, with charset supplied.
     *
     * @covers Lunr\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithCustomCharset(): void
    {
        $this->class->set_locale('de_DE', 'ISO-8859-1');
        $this->assertPropertyEquals('locale', 'de_DE.ISO-8859-1');
        $this->assertEquals('de_DE.ISO-8859-1', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method with invalid locale values, without charset supplied.
     *
     * @param mixed $value POSIX locale definition
     *
     * @depends      testDefaultLocale
     * @dataProvider invalidLocaleProvider
     * @covers       Lunr\Core\DateTime::set_locale
     */
    public function testSetCustomInvalidLocaleWithDefaultCharset($value): void
    {
        $this->class->set_locale($value);
        $this->assertPropertyEquals('locale', 'en_US.UTF-8');
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the static function sort_compare_datetime().
     *
     * @param string $date1 Date/Time string
     * @param string $date2 Date/Time string
     *
     * @dataProvider equalDatetimeProvider
     * @covers       Lunr\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsEqual($date1, $date2): void
    {
        $this->assertEquals(0, $this->class->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime().
     *
     * @param string $date1 Date/Time string
     * @param string $date2 Date/Time string
     *
     * @dataProvider inequalDatetimeProvider
     * @covers       Lunr\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsLower($date1, $date2): void
    {
        $this->assertEquals(-1, $this->class->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime().
     *
     * @param string $date1 Date/Time string
     * @param string $date2 Date/Time string
     *
     * @dataProvider inequalDatetimeProvider
     * @covers       Lunr\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsGreater($date1, $date2): void
    {
        $this->assertEquals(1, $this->class->sort_compare_datetime($date2, $date1));
    }

}

?>
