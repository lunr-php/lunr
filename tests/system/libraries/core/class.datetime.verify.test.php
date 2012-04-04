<?php

/**
 * This file contains the DateTimeVerifyTest class.
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

/**
 * This class contains the tests for the verification methods
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\DateTime
 */
class DateTimeVerifyTest extends DateTimeTest
{

    /**
     * Test the function is_time()
     *
     * @dataProvider validTimeProvider
     * @covers       Lunr\Libraries\Core\DateTime::is_time
     */
    public function testIsValidTime($time)
    {
        $this->assertTrue($this->datetime->is_time($time));
    }

    /**
     * Test the function is_time()
     *
     * @dataProvider invalidTimeProvider
     * @covers       Lunr\Libraries\Core\DateTime::is_time
     */
    public function testIsInvalidTime($time)
    {
        $this->assertFalse($this->datetime->is_time($time));
    }

    /**
     * Test is_leap_year() with valid leap year values.
     *
     * @dataProvider validLeapYearProvider
     * @covers       Lunr\Libraries\Core\DateTime::is_leap_year
     */
    public function testIsValidLeapYear($year)
    {
        $this->assertTrue($this->datetime->is_leap_year($year));
    }

    /**
     * Test is_leap_year() with invalid leap year values.
     *
     * @dataProvider invalidLeapYearProvider
     * @covers       Lunr\Libraries\Core\DateTime::is_leap_year
     */
    public function testIsInvalidLeapYear($year)
    {
        $this->assertFalse($this->datetime->is_leap_year($year));
    }

    /**
     * Test the function is_date()
     *
     * @dataProvider validDateProvider
     * @depends      testIsValidLeapYear
     * @depends      testIsInvalidLeapYear
     * @covers       Lunr\Libraries\Core\DateTime::is_date
     */
    public function testIsValidDate($date)
    {
        $this->assertTrue($this->datetime->is_date($date));
    }

    /**
     * Test the function is_date()
     *
     * @dataProvider invalidDateProvider
     * @depends      testIsValidLeapYear
     * @depends      testIsInvalidLeapYear
     * @covers Lunr\Libraries\Core\DateTime::is_date
     */
    public function testIsInvalidDate($date)
    {
        $this->assertFalse($this->datetime->is_date($date));
    }

}

?>
