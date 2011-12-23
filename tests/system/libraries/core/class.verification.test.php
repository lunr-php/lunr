<?php

use Lunr\Libraries\Core\Verification;

/**
 * This tests Lunr's Verification class
 * @covers Lunr\Libraries\Core\Verification
 */
class VerificationTest extends PHPUnit_Framework_TestCase
{

    /**
     * Test the is_ignore part of __callStatic
     * @covers Lunr\Libraries\Core\Verification::__callStatic
     */
    public function testIsIgnore()
    {
        $this->assertTrue(Verification::is_ignore());
    }

    /**
     * Test the not implemented part of __callStatic
     * @covers Lunr\Libraries\Core\Verification::__callStatic
     */
    public function testIsNotImplemented()
    {
        $this->assertFalse(Verification::graftznwiq3rz89());
    }

    /**
     * Test the static function is_length()
     * @dataProvider validLengthProvider
     * @covers Lunr\Libraries\Core\Verification::is_length
     */
    public function testValidIsLength($length, $value)
    {
        $result = Verification::is_length($length, $value);

        $this->assertTrue($result);

        $method = "is_length" . $length;
        $result = Verification::$method($value);

        $this->assertTrue($result);
    }

    /**
     * Test the static function is_length()
     * @dataProvider invalidLengthProvider
     * @covers Lunr\Libraries\Core\Verification::is_length
     */
    public function testInvalidIsLength($length, $value)
    {
        $result = Verification::is_length($length, $value);

        $this->assertFalse($result);

        $method = "is_length" . $length;
        $result = Verification::$method($value);

        $this->assertFalse($result);
    }

    /**
     * Test the static function is_nulerical_boolean()
     * @dataProvider validNumericalBooleanProvider
     * @covers Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testValidIsNumericBoolean($value)
    {
        $this->assertTrue(Verification::is_numerical_boolean($value));
    }

    /**
     * Test the static function is_nulerical_boolean()
     * @dataProvider invalidNumericalBooleanProvider
     * @covers Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testInvalidIsNumericBoolean($value)
    {
        $this->assertFalse(Verification::is_numerical_boolean($value));
    }

    /**
     * Test the static function is_time()
     * @dataProvider validTimeProvider
     * @covers Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsValidTime($time)
    {
        $this->assertTrue(Verification::is_time($time));
    }

    /**
     * Test the static function is_time()
     * @dataProvider invalidTimeProvider
     * @covers Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsInvalidTime($time)
    {
        $this->assertFalse(Verification::is_time($time));
    }

    /**
     * Test the static function is_date()
     * @dataProvider validDateProvider
     * @covers Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsValidDate($date)
    {
        $this->assertTrue(Verification::is_date($date));
    }

    /**
     * Test the static function is_date()
     * @dataProvider invalidDateProvider
     * @covers Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsInvalidDate($date)
    {
        $this->assertFalse(Verification::is_date($date));
    }

    public function validLengthProvider()
    {
        return array(array(1,"a"), array(5,"heinz"), array(10,"transcript"));
    }

    public function invalidLengthProvider()
    {
        return array(array(2,"a"), array(3,"heinz"), array(76,"transcript"));
    }

    public function validNumericalBooleanProvider()
    {
        return array(array(0), array(1), array("0"), array("1"));
    }

    public function invalidNumericalBooleanProvider()
    {
        return array(array(2), array("2"), array(true), array(false));
    }

    public function validTimeProvider()
    {
        return array(array("23:30"), array("23:30:01"), array("23:30:21"), array("30:10"), array("124:10:23"));
    }

    public function invalidTimeProvider()
    {
        return array(array("23:20:67"), array("23:61"), array("30:61"), array("30:61:10"), array("1345:10"));
    }

    public function validDateProvider()
    {
        return array(array("2010-02-10"), array("1-01-02"), array("2096-02-29"), array("2011-01-31"),
                    array("2400-02-29")
                    );
    }

    public function invalidDateProvider()
    {
        return array(array("string"), array("1020367"), array(FALSE), array("2010-02-30"), array("2010-13-10"),
                    array("2011-04-31"), array("2095-02-29"), array("2100-02-29"), array("2200-02-29")
                    );
    }


}

?>
