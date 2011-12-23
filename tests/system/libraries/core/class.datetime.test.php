<?php

namespace Lunr\Libraries\Core;
use Lunr\Libraries\Core\DateTime;
use PHPUnit_Framework_TestCase;
use ReflectionClass;

/**
 * This tests Lunr's DateTime class
 * @covers Lunr\Libraries\Core\DateTime
 */
abstract class DateTimeTest extends PHPUnit_Framework_TestCase
{

    /**
     * Instance of the DateTime class.
     * @var DateTime
     */
    protected $datetime;

    /**
     * Reflection instance of the DateTime class.
     * @var ReflectionClass
     */
    protected $reflection_datetime;

    public function setUp()
    {
        $this->reflection_datetime = new ReflectionClass('Lunr\Libraries\Core\DateTime');
        $this->datetime = new DateTime();
    }

    public function tearDown()
    {
        unset($this->datetime);
        unset($this->reflection_datetime);
    }

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


    public function timestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array(time());
        $timestamps[] = array(strtotime("+30 minutes"));
        $timestamps[] = array(strtotime("+1 week"));

        return $timestamps;
    }

    public function invalidTimestampProvider()
    {
        $timestamps   = array();
        $timestamps[] = array('String');
        $timestamps[] = array(FALSE);
        $timestamps[] = array(NULL);

        return $timestamps;
    }

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

    public function invalidDelayProvider()
    {
        $delay   = array();
        $delay[] = array('');
        $delay[] = array('String');
        $delay[] = array(NULL);
        $delay[] = array(FALSE);

        return $delay;
    }

    public function equalDatetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-02"), array("13:20","13:20"));
    }

    public function datetimeProvider()
    {
        return array(array("2010-02-02", "2010-02-03"), array("10:20", "15:15"), array("2010-02-02 13:10", "2010-02-02-15:10"));
    }

    public function datetimeFormatProvider()
    {
        $formats = $this->invalidDatetimeFormatProvider();
        $formats[] = array('%A');

        return $formats;
    }

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

}

?>
