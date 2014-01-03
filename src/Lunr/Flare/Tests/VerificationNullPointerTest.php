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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;

/**
 * This class contains the tests for the check functions
 * of the Verification class when having a NULL pointer.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
class VerificationNullPointerTest extends VerificationTest
{

    /**
     * Test that ignore() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::ignore
     */
    public function testIgnoreDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->ignore();

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of ignore() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::ignore
     */
    public function testIgnoreReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->ignore();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_length() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_length
     */
    public function testIsLengthDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_length(0);

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_length() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_length
     */
    public function testIsLengthReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_length(0);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_type() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_type
     */
    public function testIsTypeDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_type('null');

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_type() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_type
     */
    public function testIsTypeReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_type('null');

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_not_empty() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_not_empty
     */
    public function testIsNotEmptyDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_not_empty();

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_not_empty() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_not_empty
     */
    public function testIsNotEmptyReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_not_empty();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_mail() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_mail
     */
    public function testIsMailDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_mail(NULL);

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_mail() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_mail
     */
    public function testIsMailReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_mail(NULL);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_numerical_boolean() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_numerical_boolean();

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_numerical_boolean() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_numerical_boolean
     */
    public function testIsNumericalBooleanReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_numerical_boolean();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_numerical_troolean() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_numerical_troolean();

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_numerical_troolean() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_numerical_troolean
     */
    public function testIsNumericalTrooleanReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_numerical_troolean();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_date() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_date
     */
    public function testIsDateDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_date(NULL);

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_date() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_date
     */
    public function testIsDateReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_date(NULL);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that is_time() does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_time
     */
    public function testIsTimeDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->is_time(NULL);

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of is_time() (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::is_time
     */
    public function testIsTimeReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->is_time(NULL);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that an unimplemented check does nothing when no element is being inspected.
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::__call
     */
    public function testUnimplementedDoesNothingWhenPointerIsNull()
    {
        $before = $this->get_reflection_property_value('result');

        $this->class->unimplemented();

        $after = $this->get_reflection_property_value('result');

        $this->assertNull($this->get_reflection_property_value('pointer'));
        $this->assertEquals($before, $after);
    }

    /**
     * Test the fluid interface of an unimplemented call (1).
     *
     * @depends Lunr\Flare\Tests\VerificationBaseTest::testPointerIsNullByDefault
     * @covers  Lunr\Flare\Verification::__call
     */
    public function testUnimplementedReturnsSelfReferenceWhenPointerIsNull()
    {
        $value = $this->class->unimplemented();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

}

?>
