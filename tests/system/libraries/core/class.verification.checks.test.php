<?php

/**
 * This file contains the VerificationChecksTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2012, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Libraries\Core;

/**
 * This class contains the tests for the check functions
 * of the Verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Verification
 */
class VerificationChecksTest extends VerificationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);
        $property->setValue($this->verification, 'test');
    }

    /**
     * Test that an unimplemented check returns FALSE.
     *
     * @covers Lunr\Libraries\Core\Verification::__call
     */
    public function testUnimplementedStoresFalse()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $this->verification->unimplemented();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('unimplemented', $value['test']);
        $this->assertFalse($value['test']['unimplemented']);
    }

    /**
     * Test the fluid interface of an unimplemented call (2).
     *
     * @covers Lunr\Libraries\Core\Verification::__call
     */
    public function testUnimplementedReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $value = $this->verification->unimplemented();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that ignore() sets the whole element as TRUE in result.
     *
     * @covers  Lunr\Libraries\Core\Verification::ignore
     */
    public function testIgnoreSetsResultTrue()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $this->verification->ignore();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertTrue($value['test']);
    }

    /**
     * Test the fluid interface of ignore() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::ignore
     */
    public function testIgnoreReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $value = $this->verification->ignore();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that ignore resets the pointer on successful ignore.
     *
     * @covers Lunr\Libraries\Core\Verification::ignore
     */
    public function testIgnoreResetsPointer()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $this->verification->ignore();

        $this->assertNull($property->getValue($this->verification));
    }

    /**
     * Test that is_length stores TRUE when the length is correct.
     *
     * @covers Lunr\Libraries\Core\Verification::is_length
     */
    public function testIsLengthStoresTrueForCorrectLength()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_length(5);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_length_5', $value['test']);
        $this->assertTrue($value['test']['is_length_5']);
    }

    /**
     * Test that is_length stores FALSE when the length is incorrect.
     *
     * @covers Lunr\Libraries\Core\Verification::is_length
     */
    public function testIsLengthStoresFalseForIncorrectLength()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_length(1);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_length_1', $value['test']);
        $this->assertFalse($value['test']['is_length_1']);
    }

    /**
     * Test the fluid interface of is_length() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_length
     */
    public function testIsLengthReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $value = $this->verification->is_length(5);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_type stores TRUE for valid type matches.
     *
     * @param String $type  Type definition
     * @param mixed  $value Value of that type
     *
     * @dataProvider validTypeProvider
     * @covers       Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeStoresTrueForValidTypesAndValidValues($type, $value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_type($type);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_type_' . $type, $value['test']);
        $this->assertTrue($value['test']['is_type_' . $type]);
    }

    /**
     * Test that is_type stores FALSE for invalid type matches.
     *
     * @param String $type  Type definition
     * @param mixed  $value Value not of that type
     *
     * @dataProvider invalidTypeProvider
     * @covers Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeStoresFalseForValidTypesAndInvalidValues($type, $value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_type($type);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_type_' . $type, $value['test']);
        $this->assertFalse($value['test']['is_type_' . $type]);
    }

    /**
     * Test that is_type stores FALSE for types that don't have check functions.
     *
     * @covers       Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeStoresFalseForInvalidTypes()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_type('type');

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_type_type', $value['test']);
        $this->assertFalse($value['test']['is_type_type']);
    }

    /**
     * Test the fluid interface of is_type() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $value = $this->verification->is_type('string');

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_not_empty() stores TRUE for non-empty values.
     *
     * @covers Lunr\Libraries\Core\Verification::is_not_empty
     */
    public function testIsNotEmptyStoresTrueForNonEmptyValues()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_not_empty();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_not_empty', $value['test']);
        $this->assertTrue($value['test']['is_not_empty']);
    }

    /**
     * Test that is_not_empty() stores FALSE for empty values.
     *
     * @param mixed $value non-empty-value
     *
     * @dataProvider emptyValueProvider
     * @covers       Lunr\Libraries\Core\Verification::is_not_empty
     */
    public function testIsNotEmptyStoresFalseForEmptyValues($value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_not_empty();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_not_empty', $value['test']);
        $this->assertFalse($value['test']['is_not_empty']);
    }

    /**
     * Test the fluid interface of is_not_empty() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_not_empty
     */
    public function testIsNotEmptyReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $value = $this->verification->is_not_empty();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_numerical_boolean stores TRUE for valid values.
     *
     * @param mixed $value Valid numerical boolean
     *
     * @dataProvider validNumericalBooleanProvider
     * @covers       Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanStoresTrueForValidValues($value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_numerical_boolean();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_boolean', $value['test']);
        $this->assertTrue($value['test']['is_numerical_boolean']);
    }

    /**
     * Test that is_numerical_boolean stores FALSE for invalid values.
     *
     * @param mixed $value Invalid numerical boolean
     *
     * @dataProvider invalidNumericalBooleanProvider
     * @covers       Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanStoresFalseForInvalidValues($value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_numerical_boolean();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_boolean', $value['test']);
        $this->assertFalse($value['test']['is_numerical_boolean']);
    }

    /**
     * Test the fluid interface of is_numerical_boolean() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $value = $this->verification->is_numerical_boolean();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_numerical_troolean stores TRUE for valid values.
     *
     * @param mixed $value Valid numerical troolean
     *
     * @dataProvider validNumericalTrooleanProvider
     * @covers       Lunr\Libraries\Core\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanStoresTrueForValidValues($value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_numerical_troolean();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_troolean', $value['test']);
        $this->assertTrue($value['test']['is_numerical_troolean']);
    }

    /**
     * Test that is_numerical_troolean stores FALSE for invalid values.
     *
     * @param mixed $value Valid numerical troolean
     *
     * @dataProvider invalidNumericalTrooleanProvider
     * @covers       Lunr\Libraries\Core\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanStoresFalseForInvalidValues($value)
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => $value);

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $this->verification->is_numerical_troolean();

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_troolean', $value['test']);
        $this->assertFalse($value['test']['is_numerical_troolean']);
    }

    /**
     * Test the fluid interface of is_numerical_troolean() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $value = $this->verification->is_numerical_troolean();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_mail() stores TRUE for valid emails.
     *
     * @covers Lunr\Libraries\Core\Verification::is_mail
     */
    public function testIsMailStoresTrueForValidEmails()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $mail = $this->getMock('Lunr\Libraries\Core\Mail');
        $mail->expects($this->once())
             ->method('is_valid')
             ->will($this->returnValue(TRUE));

        $this->verification->is_mail($mail);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_mail', $value['test']);
        $this->assertTrue($value['test']['is_mail']);
    }

    /**
     * Test that is_mail() stores FALSE for invalid emails.
     *
     * @covers Lunr\Libraries\Core\Verification::is_mail
     */
    public function testIsMailStoresFalseForInvalidEmails()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $mail = $this->getMock('Lunr\Libraries\Core\Mail');
        $mail->expects($this->once())
             ->method('is_valid')
             ->will($this->returnValue(FALSE));

        $this->verification->is_mail($mail);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_mail', $value['test']);
        $this->assertFalse($value['test']['is_mail']);
    }

    /**
     * Test the fluid interface of is_mail() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_mail
     */
    public function testIsMailReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $mail = $this->getMock('Lunr\Libraries\Core\Mail');
        $mail->expects($this->once())
             ->method('is_valid');

        $value = $this->verification->is_mail($mail);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_date() stores TRUE for valid dates.
     *
     * @covers Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsDateStoresTrueForValidDates()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date')
             ->will($this->returnValue(TRUE));

        $this->verification->is_date($date);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_date', $value['test']);
        $this->assertTrue($value['test']['is_date']);
    }

    /**
     * Test that is_date() stores FALSE for invalid dates.
     *
     * @covers Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsDateStoresFalseForInvalidDates()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date')
             ->will($this->returnValue(FALSE));

        $this->verification->is_date($date);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_date', $value['test']);
        $this->assertFalse($value['test']['is_date']);
    }

    /**
     * Test the fluid interface of is_date() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsDateReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date');

        $value = $this->verification->is_date($date);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_time() stores TRUE for valid times.
     *
     * @covers Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsTimeStoresTrueForValidTimes()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time')
             ->will($this->returnValue(TRUE));

        $this->verification->is_time($date);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_time', $value['test']);
        $this->assertTrue($value['test']['is_time']);
    }

    /**
     * Test that is_time() stores FALSE for invalid times.
     *
     * @covers Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsTimeStoresFalseForInvalidTimes()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time')
             ->will($this->returnValue(FALSE));

        $this->verification->is_time($date);

        $value = $result->getValue($this->verification);
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_time', $value['test']);
        $this->assertFalse($value['test']['is_time']);
    }

    /**
     * Test the fluid interface of is_time() (2).
     *
     * @covers Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsTimeReturnsSelfReference()
    {
        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $date = $this->getMock('Lunr\Libraries\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time');

        $value = $this->verification->is_time($date);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

}

?>
