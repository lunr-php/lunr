<?php

/**
 * This file contains the DateTimeTest class.
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
use Lunr\Halo\LunrBaseTest;
use ReflectionClass;

/**
 * This class contains common setup routines, providers
 * and shared attributes for testing the DateTime class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\DateTime
 */
abstract class DateTimeTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        $this->class      = new DateTime();
        $this->reflection = new ReflectionClass('Lunr\Core\DateTime');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown()
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Assert that a day name is localized correctly.
     *
     * This checks against the German localized day names.
     *
     * @param String $day           Day name to check against
     * @param String $localized_day Day name to check
     *
     * @return Boolean $return TRUE on known values, FALSE on unknown values
     */
    protected function check_localized_day($day, $localized_day)
    {
        switch ($day)
        {
            case 1:
                $this->assertEquals('Montag', $localized_day);
                break;
            case 2:
                $this->assertEquals('Dienstag', $localized_day);
                break;
            case 3:
                $this->assertEquals('Mittwoch', $localized_day);
                break;
            case 4:
                $this->assertEquals('Donnerstag', $localized_day);
                break;
            case 5:
                $this->assertEquals('Freitag', $localized_day);
                break;
            case 6:
                $this->assertEquals('Samstag', $localized_day);
                break;
            case 7:
                $this->assertEquals('Sonntag', $localized_day);
                break;
            default:
                return FALSE;
        }

        return TRUE;
    }

    /**
     * Unit Test Data Provider for valid Timestamps.
     *
     * @return array $timestamps Set of valid timestamps
     */
    public function validTimestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array(time());
        $timestamps[] = array(strtotime('+30 minutes'));
        $timestamps[] = array(strtotime('+1 week'));

        return $timestamps;
    }

    /**
     * Unit Test Data Provider for invalid Timestamps.
     *
     * @return array $timestamps Set of invalid timestamps
     */
    public function invalidTimestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array('String');
        $timestamps[] = array(FALSE);
        $timestamps[] = array(NULL);

        return $timestamps;
    }

    /**
     * Unit Test Data Provider for valid delay specifiers.
     *
     * @return array $delay Set of valid delay specifiers
     */
    public function validDelayProvider()
    {
        $delay   = array();
        $delay[] = array('+1 day');
        $delay[] = array('-1 week');
        $delay[] = array('+1 month');
        $delay[] = array('-1 year');
        $delay[] = array('2011-10-10');

        return $delay;
    }

    /**
     * Unit Test Data Provider for invalid delay specifiers.
     *
     * @return array $delay Set of invalid delay specifiers
     */
    public function invalidDelayProvider()
    {
        $delay   = array();
        $delay[] = array('');
        $delay[] = array('String');
        $delay[] = array(NULL);
        $delay[] = array(FALSE);

        return $delay;
    }

    /**
     * Unit Test Data Provider for equal dates.
     *
     * @return array $delay Set of equal dates
     */
    public function equalDatetimeProvider()
    {
        $datetimes   = array();
        $datetimes[] = array('2010-02-02', '2010-02-02');
        $datetimes[] = array('13:20', '13:20');

        return $datetimes;
    }

    /**
     * Unit Test Data Provider for inequal dates.
     *
     * @return array $delay Set of inequal dates
     */
    public function inequalDatetimeProvider()
    {
        $datetimes   = array();
        $datetimes[] = array('2010-02-02', '2010-02-03');
        $datetimes[] = array('10:20', '15:15');
        $datetimes[] = array('2010-02-02 13:10', '2010-02-02 15:10');

        return $datetimes;
    }

    /**
     * Unit Test Data Provider for valid and invalid datetime formats.
     *
     * strftime() compatible
     *
     * @return array $delay Set of datetime formats
     */
    public function datetimeFormatProvider()
    {
        $formats   = $this->invalidDatetimeFormatProvider();
        $formats[] = array('%A');

        return $formats;
    }

    /**
     * Unit Test Data Provider for invalid datetime formats.
     *
     * strftime() compatible
     *
     * @return array $delay Set of invalid datetime formats
     */
    public function invalidDatetimeFormatProvider()
    {
        $formats   = array();
        $formats[] = array('');
        $formats[] = array(10);
        $formats[] = array('String');
        $formats[] = array(FALSE);
        $formats[] = array(NULL);

        return $formats;
    }

    /**
     * Unit Test Data Provider for invalid POSIX locale definitions.
     *
     * @return array $delay Set of invalid POSIX locale definitions
     */
    public function invalidLocaleProvider()
    {
        $locales   = array();
        $locales[] = array('');
        $locales[] = array(10);
        $locales[] = array('String');
        $locales[] = array(FALSE);
        $locales[] = array(NULL);

        return $locales;
    }

    /**
     * Unit Test Data Provider for valid Time definitions.
     *
     * @return array $times Set of valid time definitions
     */
    public function validTimeProvider()
    {
        $times   = array();
        $times[] = array('23:30');
        $times[] = array('23:30:01');
        $times[] = array('23:30:21');
        $times[] = array('30:10');
        $times[] = array('124:10:23');

        return $times;
    }

    /**
     * Unit Test Data Provider for invalid Time definitions.
     *
     * @return array $times Set of invalid time definitions
     */
    public function invalidTimeProvider()
    {
        $times   = array();
        $times[] = array('23:20:67');
        $times[] = array('23:61');
        $times[] = array('30:61');
        $times[] = array('30:61:10');
        $times[] = array('1345:10');

        return $times;
    }

    /**
     * Unit Test Data Provider for valid Leapyear definitions.
     *
     * @return array $years Set of valid leap definitions
     */
    public function validLeapYearProvider()
    {
        $years   = array();
        $years[] = array(1996);
        $years[] = array(2000);

        return $years;
    }

    /**
     * Unit Test Data Provider for invalid Leapyear definitions.
     *
     * @return array $years Set of invalid leap definitions
     */
    public function invalidLeapYearProvider()
    {
        $years   = array();
        $years[] = array(1998);
        $years[] = array(2001);
        $years[] = array(3000);

        return $years;
    }

    /**
     * Unit Test Data Provider for valid Date definitions.
     *
     * @return array $dates Set of valid date definitions
     */
    public function validDateProvider()
    {
        $dates   = array();
        $dates[] = array('2010-02-10');
        $dates[] = array('1-01-02');
        $dates[] = array('2096-02-29');
        $dates[] = array('2011-01-31');
        $dates[] = array('2400-02-29');

        return $dates;
    }

    /**
     * Unit Test Data Provider for invalid Date definitions.
     *
     * @return array $dates Set of invalid date definitions
     */
    public function invalidDateProvider()
    {
        $dates   = array();
        $dates[] = array('string');
        $dates[] = array('1020367');
        $dates[] = array(FALSE);
        $dates[] = array('2010-02-30');
        $dates[] = array('2010-13-10');
        $dates[] = array('2011-04-31');
        $dates[] = array('2095-02-29');
        $dates[] = array('2100-02-29');
        $dates[] = array('2200-02-29');

        return $dates;
    }

}

?>
