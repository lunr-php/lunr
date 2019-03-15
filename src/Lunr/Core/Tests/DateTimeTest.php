<?php

/**
 * This file contains the DateTimeTest class.
 *
 * @package    Lunr\Core
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2011-2018, M2Mobi BV, Amsterdam, The Netherlands
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
 * @covers     Lunr\Core\DateTime
 */
abstract class DateTimeTest extends LunrBaseTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp(): void
    {
        $this->class      = new DateTime();
        $this->reflection = new ReflectionClass('Lunr\Core\DateTime');
    }

    /**
     * TestCase Destructor.
     */
    public function tearDown(): void
    {
        unset($this->reflection);
        unset($this->class);
    }

    /**
     * Assert that a day name is localized correctly.
     *
     * This checks against the German localized day names.
     *
     * @param string $day           Day name to check against
     * @param string $localized_day Day name to check
     *
     * @return boolean $return TRUE on known values, FALSE on unknown values
     */
    protected function check_localized_day($day, $localized_day): bool
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
    public function validTimestampProvider(): array
    {
        $timestamps   = [];
        $timestamps[] = [ time() ];
        $timestamps[] = [ strtotime('+30 minutes') ];
        $timestamps[] = [ strtotime('+1 week') ];

        return $timestamps;
    }

    /**
     * Unit Test Data Provider for invalid Timestamps.
     *
     * @return array $timestamps Set of invalid timestamps
     */
    public function invalidTimestampProvider(): array
    {
        $timestamps   = [];
        $timestamps[] = [ 'String' ];
        $timestamps[] = [ FALSE ];
        $timestamps[] = [ NULL ];

        return $timestamps;
    }

    /**
     * Unit Test Data Provider for valid delay specifiers.
     *
     * @return array $delay Set of valid delay specifiers
     */
    public function validDelayProvider(): array
    {
        $delay   = [];
        $delay[] = [ '+1 day' ];
        $delay[] = [ '-1 week' ];
        $delay[] = [ '+1 month' ];
        $delay[] = [ '-1 year' ];
        $delay[] = [ '2011-10-10' ];

        return $delay;
    }

    /**
     * Unit Test Data Provider for invalid delay specifiers.
     *
     * @return array $delay Set of invalid delay specifiers
     */
    public function invalidDelayProvider(): array
    {
        $delay   = [];
        $delay[] = [ '' ];
        $delay[] = [ 'String' ];
        $delay[] = [ NULL ];
        $delay[] = [ FALSE ];

        return $delay;
    }

    /**
     * Unit Test Data Provider for equal dates.
     *
     * @return array $delay Set of equal dates
     */
    public function equalDatetimeProvider(): array
    {
        $datetimes   = [];
        $datetimes[] = [ '2010-02-02', '2010-02-02' ];
        $datetimes[] = [ '13:20', '13:20' ];

        return $datetimes;
    }

    /**
     * Unit Test Data Provider for inequal dates.
     *
     * @return array $delay Set of inequal dates
     */
    public function inequalDatetimeProvider(): array
    {
        $datetimes   = [];
        $datetimes[] = [ '2010-02-02', '2010-02-03' ];
        $datetimes[] = [ '10:20', '15:15' ];
        $datetimes[] = [ '2010-02-02 13:10', '2010-02-02 15:10' ];

        return $datetimes;
    }

    /**
     * Unit Test Data Provider for valid and invalid datetime formats.
     *
     * strftime() compatible
     *
     * @return array $delay Set of datetime formats
     */
    public function datetimeFormatProvider(): array
    {
        $formats   = $this->invalidDatetimeFormatProvider();
        $formats[] = [ '%A' ];

        return $formats;
    }

    /**
     * Unit Test Data Provider for invalid datetime formats.
     *
     * strftime() compatible
     *
     * @return array $delay Set of invalid datetime formats
     */
    public function invalidDatetimeFormatProvider(): array
    {
        $formats   = [];
        $formats[] = [ '' ];
        $formats[] = [ 10 ];
        $formats[] = [ 'String' ];
        $formats[] = [ FALSE ];
        $formats[] = [ NULL ];

        return $formats;
    }

    /**
     * Unit Test Data Provider for invalid POSIX locale definitions.
     *
     * @return array $delay Set of invalid POSIX locale definitions
     */
    public function invalidLocaleProvider(): array
    {
        $locales   = [];
        $locales[] = [ '' ];
        $locales[] = [ 10 ];
        $locales[] = [ 'String' ];
        $locales[] = [ FALSE ];
        $locales[] = [ NULL ];

        return $locales;
    }

    /**
     * Unit Test Data Provider for valid Time definitions.
     *
     * @return array $times Set of valid time definitions
     */
    public function validTimeProvider(): array
    {
        $times   = [];
        $times[] = [ '23:30' ];
        $times[] = [ '23:30:01' ];
        $times[] = [ '23:30:21' ];
        $times[] = [ '30:10' ];
        $times[] = [ '124:10:23' ];

        return $times;
    }

    /**
     * Unit Test Data Provider for invalid Time definitions.
     *
     * @return array $times Set of invalid time definitions
     */
    public function invalidTimeProvider(): array
    {
        $times   = [];
        $times[] = [ '23:20:67' ];
        $times[] = [ '23:61' ];
        $times[] = [ '30:61' ];
        $times[] = [ '30:61:10' ];
        $times[] = [ '1345:10' ];

        return $times;
    }

    /**
     * Unit Test Data Provider for valid Leapyear definitions.
     *
     * @return array $years Set of valid leap definitions
     */
    public function validLeapYearProvider(): array
    {
        $years   = [];
        $years[] = [ 1996 ];
        $years[] = [ 2000 ];

        return $years;
    }

    /**
     * Unit Test Data Provider for invalid Leapyear definitions.
     *
     * @return array $years Set of invalid leap definitions
     */
    public function invalidLeapYearProvider(): array
    {
        $years   = [];
        $years[] = [ 1998 ];
        $years[] = [ 2001 ];
        $years[] = [ 3000 ];

        return $years;
    }

    /**
     * Unit Test Data Provider for valid Date definitions.
     *
     * @return array $dates Set of valid date definitions
     */
    public function validDateProvider(): array
    {
        $dates   = [];
        $dates[] = [ '2010-02-10' ];
        $dates[] = [ '1-01-02' ];
        $dates[] = [ '2096-02-29' ];
        $dates[] = [ '2011-01-31' ];
        $dates[] = [ '2400-02-29' ];

        return $dates;
    }

    /**
     * Unit Test Data Provider for invalid Date definitions.
     *
     * @return array $dates Set of invalid date definitions
     */
    public function invalidDateProvider(): array
    {
        $dates   = [];
        $dates[] = [ 'string' ];
        $dates[] = [ '1020367' ];
        $dates[] = [ FALSE ];
        $dates[] = [ '2010-02-30' ];
        $dates[] = [ '2010-13-10' ];
        $dates[] = [ '2011-04-31' ];
        $dates[] = [ '2095-02-29' ];
        $dates[] = [ '2100-02-29' ];
        $dates[] = [ '2200-02-29' ];

        return $dates;
    }

}

?>
