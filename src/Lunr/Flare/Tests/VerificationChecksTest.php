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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;

/**
 * This class contains the tests for the check functions
 * of the Verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
class VerificationChecksTest extends VerificationTest
{

    /**
     * TestCase Constructor.
     */
    public function setUp()
    {
        parent::setUp();

        $this->set_reflection_property_value('pointer', 'test');
    }

    /**
     * Test that an unimplemented check returns FALSE.
     *
     * @covers Lunr\Flare\Verification::__call
     */
    public function testUnimplementedStoresFalse()
    {
        $this->class->unimplemented();

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('unimplemented', $value['test']);
        $this->assertFalse($value['test']['unimplemented']);
    }

    /**
     * Test the fluid interface of an unimplemented call (2).
     *
     * @covers Lunr\Flare\Verification::__call
     */
    public function testUnimplementedReturnsSelfReference()
    {
        $value = $this->class->unimplemented();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that ignore() sets the whole element as TRUE in result.
     *
     * @covers Lunr\Flare\Verification::ignore
     */
    public function testIgnoreSetsResultTrue()
    {
        $this->class->ignore();

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertTrue($value['test']);
    }

    /**
     * Test the fluid interface of ignore() (2).
     *
     * @covers Lunr\Flare\Verification::ignore
     */
    public function testIgnoreReturnsSelfReference()
    {
        $value = $this->class->ignore();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that ignore resets the pointer on successful ignore.
     *
     * @covers Lunr\Flare\Verification::ignore
     */
    public function testIgnoreResetsPointer()
    {
        $this->class->ignore();

        $this->assertNull($this->get_reflection_property_value('pointer'));
    }

    /**
     * Test that is_length stores TRUE when the length is correct.
     *
     * @covers Lunr\Flare\Verification::is_length
     */
    public function testIsLengthStoresTrueForCorrectLength()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $this->class->is_length(5);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_length_5', $value['test']);
        $this->assertTrue($value['test']['is_length_5']);
    }

    /**
     * Test that is_length stores FALSE when the length is incorrect.
     *
     * @covers Lunr\Flare\Verification::is_length
     */
    public function testIsLengthStoresFalseForIncorrectLength()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $this->class->is_length(1);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_length_1', $value['test']);
        $this->assertFalse($value['test']['is_length_1']);
    }

    /**
     * Test the fluid interface of is_length() (2).
     *
     * @covers Lunr\Flare\Verification::is_length
     */
    public function testIsLengthReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $value = $this->class->is_length(5);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_type stores TRUE for valid type matches.
     *
     * @param String $type  Type definition
     * @param mixed  $value Value of that type
     *
     * @dataProvider validTypeProvider
     * @covers       Lunr\Flare\Verification::is_type
     */
    public function testIsTypeStoresTrueForValidTypesAndValidValues($type, $value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_type($type);

        $value = $this->get_reflection_property_value('result');
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
     * @covers       Lunr\Flare\Verification::is_type
     */
    public function testIsTypeStoresFalseForValidTypesAndInvalidValues($type, $value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_type($type);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_type_' . $type, $value['test']);
        $this->assertFalse($value['test']['is_type_' . $type]);
    }

    /**
     * Test that is_type stores FALSE for types that don't have check functions.
     *
     * @covers Lunr\Flare\Verification::is_type
     */
    public function testIsTypeStoresFalseForInvalidTypes()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $this->class->is_type('type');

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_type_type', $value['test']);
        $this->assertFalse($value['test']['is_type_type']);
    }

    /**
     * Test the fluid interface of is_type() (2).
     *
     * @covers Lunr\Flare\Verification::is_type
     */
    public function testIsTypeReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $value = $this->class->is_type('string');

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_not_empty() stores TRUE for non-empty values.
     *
     * @covers Lunr\Flare\Verification::is_not_empty
     */
    public function testIsNotEmptyStoresTrueForNonEmptyValues()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $this->class->is_not_empty();

        $value = $this->get_reflection_property_value('result');
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
     * @covers       Lunr\Flare\Verification::is_not_empty
     */
    public function testIsNotEmptyStoresFalseForEmptyValues($value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_not_empty();

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_not_empty', $value['test']);
        $this->assertFalse($value['test']['is_not_empty']);
    }

    /**
     * Test the fluid interface of is_not_empty() (2).
     *
     * @covers Lunr\Flare\Verification::is_not_empty
     */
    public function testIsNotEmptyReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $value = $this->class->is_not_empty();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_numerical_boolean stores TRUE for valid values.
     *
     * @param mixed $value Valid numerical boolean
     *
     * @dataProvider validNumericalBooleanProvider
     * @covers       Lunr\Flare\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanStoresTrueForValidValues($value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_numerical_boolean();

        $value = $this->get_reflection_property_value('result');
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
     * @covers       Lunr\Flare\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanStoresFalseForInvalidValues($value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_numerical_boolean();

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_boolean', $value['test']);
        $this->assertFalse($value['test']['is_numerical_boolean']);
    }

    /**
     * Test the fluid interface of is_numerical_boolean() (2).
     *
     * @covers Lunr\Flare\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $value = $this->class->is_numerical_boolean();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_numerical_troolean stores TRUE for valid values.
     *
     * @param mixed $value Valid numerical troolean
     *
     * @dataProvider validNumericalTrooleanProvider
     * @covers       Lunr\Flare\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanStoresTrueForValidValues($value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_numerical_troolean();

        $value = $this->get_reflection_property_value('result');
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
     * @covers       Lunr\Flare\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanStoresFalseForInvalidValues($value)
    {
        $test = array('test' => $value);

        $this->set_reflection_property_value('data', $test);

        $this->class->is_numerical_troolean();

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_numerical_troolean', $value['test']);
        $this->assertFalse($value['test']['is_numerical_troolean']);
    }

    /**
     * Test the fluid interface of is_numerical_troolean() (2).
     *
     * @covers Lunr\Flare\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $value = $this->class->is_numerical_troolean();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_mail() stores TRUE for valid emails.
     *
     * @covers Lunr\Flare\Verification::is_mail
     */
    public function testIsMailStoresTrueForValidEmails()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $mail = $this->getMock('Lunr\Network\Mail');
        $mail->expects($this->once())
             ->method('is_valid')
             ->will($this->returnValue(TRUE));

        $this->class->is_mail($mail);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_mail', $value['test']);
        $this->assertTrue($value['test']['is_mail']);
    }

    /**
     * Test that is_mail() stores FALSE for invalid emails.
     *
     * @covers Lunr\Flare\Verification::is_mail
     */
    public function testIsMailStoresFalseForInvalidEmails()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $mail = $this->getMock('Lunr\Network\Mail');
        $mail->expects($this->once())
             ->method('is_valid')
             ->will($this->returnValue(FALSE));

        $this->class->is_mail($mail);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_mail', $value['test']);
        $this->assertFalse($value['test']['is_mail']);
    }

    /**
     * Test the fluid interface of is_mail() (2).
     *
     * @covers Lunr\Flare\Verification::is_mail
     */
    public function testIsMailReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $mail = $this->getMock('Lunr\Network\Mail');
        $mail->expects($this->once())
             ->method('is_valid');

        $value = $this->class->is_mail($mail);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_date() stores TRUE for valid dates.
     *
     * @covers Lunr\Flare\Verification::is_date
     */
    public function testIsDateStoresTrueForValidDates()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date')
             ->will($this->returnValue(TRUE));

        $this->class->is_date($date);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_date', $value['test']);
        $this->assertTrue($value['test']['is_date']);
    }

    /**
     * Test that is_date() stores FALSE for invalid dates.
     *
     * @covers Lunr\Flare\Verification::is_date
     */
    public function testIsDateStoresFalseForInvalidDates()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date')
             ->will($this->returnValue(FALSE));

        $this->class->is_date($date);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_date', $value['test']);
        $this->assertFalse($value['test']['is_date']);
    }

    /**
     * Test the fluid interface of is_date() (2).
     *
     * @covers Lunr\Flare\Verification::is_date
     */
    public function testIsDateReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_date');

        $value = $this->class->is_date($date);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_time() stores TRUE for valid times.
     *
     * @covers Lunr\Flare\Verification::is_time
     */
    public function testIsTimeStoresTrueForValidTimes()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time')
             ->will($this->returnValue(TRUE));

        $this->class->is_time($date);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_time', $value['test']);
        $this->assertTrue($value['test']['is_time']);
    }

    /**
     * Test that is_time() stores FALSE for invalid times.
     *
     * @covers Lunr\Flare\Verification::is_time
     */
    public function testIsTimeStoresFalseForInvalidTimes()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time')
             ->will($this->returnValue(FALSE));

        $this->class->is_time($date);

        $value = $this->get_reflection_property_value('result');
        $this->assertArrayHasKey('test', $value);
        $this->assertArrayHasKey('is_time', $value['test']);
        $this->assertFalse($value['test']['is_time']);
    }

    /**
     * Test the fluid interface of is_time() (2).
     *
     * @covers Lunr\Flare\Verification::is_time
     */
    public function testIsTimeReturnsSelfReference()
    {
        $test = array('test' => 'value');

        $this->set_reflection_property_value('data', $test);

        $date = $this->getMock('Lunr\Core\DateTime');
        $date->expects($this->once())
             ->method('is_time');

        $value = $this->class->is_time($date);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

}

?>
