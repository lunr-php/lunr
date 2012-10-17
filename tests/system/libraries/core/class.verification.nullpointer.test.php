<?php

/**
 * This file contains the VerificationNullPointerTest class.
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
 * of the Verification class when having a NULL pointer.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Libraries\Core\Verification
 */
class VerificationNullPointerTest extends VerificationTest
{

    /**
     * Test that ignore() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::ignore
     */
    public function testIgnoreDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->ignore();

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of ignore() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::ignore
     */
    public function testIgnoreReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->ignore();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_length() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_length
     */
    public function testIsLengthDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_length(0);

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_length() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_length
     */
    public function testIsLengthReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_length(0);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_type() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_type('null');

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_type() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_type
     */
    public function testIsTypeReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_type('null');

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_not_empty() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_not_empty
     */
    public function testIsNotEmptyDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_not_empty();

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_not_empty() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_not_empty
     */
    public function testIsNotEmptyReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_not_empty();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_mail() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_mail
     */
    public function testIsMailDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_mail(NULL);

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_mail() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_mail
     */
    public function testIsMailReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_mail(NULL);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_numerical_boolean() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_numerical_boolean();

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_numerical_boolean() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_numerical_boolean();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_numerical_troolean() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_numerical_troolean();

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_numerical_troolean() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_numerical_troolean();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_date() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsDateDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_date(NULL);

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_date() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_date
     */
    public function testIsDateReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_date(NULL);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that is_time() does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsTimeDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->is_time(NULL);

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_time() (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::is_time
     */
    public function testIsTimeReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->is_time(NULL);

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that an unimplemented check does nothing when no element is being inspected.
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::__call
     */
    public function testUnimplementedDoesNothingWhenPointerIsNull()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $result = $this->verification_reflection->getProperty('result');
        $result->setAccessible(TRUE);

        $before = $result->getValue($this->verification);

        $this->verification->unimplemented();

        $after = $result->getValue($this->verification);

        $this->assertNull($property->getValue($this->verification));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of an unimplemented call (1).
     *
     * @depends Lunr\Libraries\Core\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Libraries\Core\Verification::__call
     */
    public function testUnimplementedReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->verification->unimplemented();

        $this->assertInstanceOf('Lunr\Libraries\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

}

?>
