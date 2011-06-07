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

}

?>
