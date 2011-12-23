<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
class DateTimeBaseTest extends DateTimeTest
{

    /**
     * Check that default DateTime format is as expected.
     */
    public function testDefaultDatetimeFormat()
    {
        $datetime_format = $this->reflection_datetime->getProperty('datetime_format');
        $datetime_format->setAccessible(TRUE);
        $this->assertEquals('%Y-%m-%d', $datetime_format->getValue($this->datetime));
    }

    /**
     * Test the set_datetime_format() method.
     *
     * @dataProvider datetimeFormatProvider
     * @covers Lunr\Libraries\Core\DateTime::set_datetime_format
     */
    public function testSetCustomDatetimeFormat($format)
    {
        $datetime_format = $this->reflection_datetime->getProperty('datetime_format');
        $datetime_format->setAccessible(TRUE);
        $this->datetime->set_datetime_format($format);
        $this->assertEquals($format, $datetime_format->getValue($this->datetime));
    }

    /**
     * Check that default Locale is as expected.
     */
    public function testDefaultLocale()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->assertEquals('en_US.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, without charset supplied.
     *
     * @runInSeparateProcess
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithDefaultCharset()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale('de_DE');
        $this->assertEquals('de_DE.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('de_DE.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method, with charset supplied.
     *
     * @runInSeparateProcess
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomLocaleWithCustomCharset()
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale('de_DE', 'ISO-8859-1');
        $this->assertEquals('de_DE.ISO-8859-1', $locale->getValue($this->datetime));
        $this->assertEquals('de_DE.ISO-8859-1', setlocale(LC_ALL, 0));
    }

    /**
     * Test the set_locale() method with invalid locale values, without charset supplied.
     *
     * @runInSeparateProcess
     * @depends testDefaultLocale
     * @dataProvider invalidLocaleProvider
     * @covers Lunr\Libraries\Core\DateTime::set_locale
     */
    public function testSetCustomInvalidLocaleWithDefaultCharset($value)
    {
        $locale = $this->reflection_datetime->getProperty('locale');
        $locale->setAccessible(TRUE);
        $this->datetime->set_locale($value);
        $this->assertEquals('en_US.UTF-8', $locale->getValue($this->datetime));
        $this->assertEquals('en_US.UTF-8', setlocale(LC_ALL, 0));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider equalDatetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsEqual($date1, $date2)
    {
        $this->assertEquals(0, $this->datetime->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsLower($date1, $date2)
    {
        $this->assertEquals(-1, $this->datetime->sort_compare_datetime($date1, $date2));
    }

    /**
     * Test the static function sort_compare_datetime()
     * @dataProvider datetimeProvider
     * @covers Lunr\Libraries\Core\DateTime::sort_compare_datetime
     */
    public function testDatetimeIsGreater($date1, $date2)
    {
        $this->assertEquals(1, $this->datetime->sort_compare_datetime($date2, $date1));
    }

}

?>
