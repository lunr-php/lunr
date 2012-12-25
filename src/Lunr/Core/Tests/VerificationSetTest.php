<?php

/**
 * This file contains the VerificationSetTest class.
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

namespace Lunr\Core\Tests;

use Lunr\Core\Verification;

/**
 * This class contains the tests for the setters of the verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Verification
 */
class VerificationSetTest extends VerificationTest
{

    /**
     * Test the fluid interface of set_data().
     *
     * @covers Lunr\Core\Verification::set_data
     */
    public function testSetDataReturnsSelfReference()
    {
        $set   = array('1');
        $value = $this->verification->set_data($set);

        $this->assertInstanceOf('Lunr\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that set_data() populates the data array.
     *
     * @covers  Lunr\Core\Verification::set_data
     */
    public function testSetDataSetsData()
    {
        $set = array('test' => 'value');

        $this->verification->set_data($set);

        $property = $this->verification_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $this->assertSame($set, $property->getValue($this->verification));
    }

    /**
     * Test that set_data() sets the data array as empty when an invalid value is passed.
     *
     * @param mixed $value Dataset for population
     *
     * @dataProvider invalidDatasetProvider
     * @covers       Lunr\Core\Verification::set_data
     */
    public function testSetDataSetsEmptyArrayAsDataIfDatasetIsInvalid($value)
    {
        $this->logger->expects($this->once())
                     ->method('error');

        $property = $this->verification_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $property->setValue($this->verification, array('test' => 'value'));

        $this->verification->set_data($value);

        $data = $property->getValue($this->verification);

        $this->assertInternalType('array', $data);
        $this->assertEmpty($data);
    }

    /**
     * Test that set_data resets the verification state.
     *
     * @covers Lunr\Core\Verification::set_data
     */
    public function testSetDataResetsVerificationState()
    {
        $props      = $this->verification_reflection->getProperties();
        $properties = array();

        foreach ($props as &$value)
        {
            $value->setAccessible(TRUE);
            $properties[$value->getName()] = $value;
        }

        unset($value);

        $properties['check_remaining']->setValue($this->verification, FALSE);
        $properties['check_superfluous']->setValue($this->verification, TRUE);
        $properties['superfluous']->setValue($this->verification, array('test'));
        $properties['result']->setValue($this->verification, array('test'));
        $properties['pointer']->setValue($this->verification, 'test');
        $properties['identifier']->setValue($this->verification, 'Testing');

        $set = array('1');
        $this->verification->set_data($set);


        $this->assertTrue($properties['check_remaining']->getValue($this->verification));
        $this->assertFalse($properties['check_superfluous']->getValue($this->verification));
        $this->assertNull($properties['pointer']->getValue($this->verification));

        $superfluous = $properties['superfluous']->getValue($this->verification);
        $result      = $properties['result']->getValue($this->verification);
        $identifier  = $properties['identifier']->getValue($this->verification);

        $this->assertInternalType('array', $superfluous);
        $this->assertInternalType('array', $result);
        $this->assertInternalType('string', $identifier);

        $this->assertEmpty($superfluous);
        $this->assertEmpty($result);
        $this->assertEmpty($identifier);
    }

    /**
     * Test setting an identifier.
     *
     * @covers Lunr\Core\Verification::set_identifier
     */
    public function testSetIdentifierSetsIdentifier()
    {
        $property = $this->verification_reflection->getProperty('identifier');
        $property->setAccessible(TRUE);

        $id = 'Test Verification';

        $this->verification->set_identifier($id);

        $this->assertEquals($id, $property->getValue($this->verification));
    }

    /**
     * Test the fluid interface of set_identifier.
     *
     * @covers Lunr\Core\Verification::set_identifier
     */
    public function testSetIdentifierReturnsSelfReference()
    {
        $id = 'Test Verification';

        $value = $this->verification->set_identifier($id);

        $this->assertInstanceOf('Lunr\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that ignore_unchecked_indexes() sets check_remaining to FALSE.
     *
     * @covers Lunr\Core\Verification::ignore_unchecked_indexes
     */
    public function testIgnoreUncheckedIndexesSetsCheckRemainingFalse()
    {
        $property = $this->verification_reflection->getProperty('check_remaining');
        $property->setAccessible(TRUE);

        $this->verification->ignore_unchecked_indexes();

        $this->assertFalse($property->getValue($this->verification));
    }

    /**
     * Test the fluid interface of ignore_unchecked_indexes.
     *
     * @covers Lunr\Core\Verification::ignore_unchecked_indexes
     */
    public function testIgnoreUncheckedIndexesReturnsSelfReference()
    {
        $value = $this->verification->ignore_unchecked_indexes();

        $this->assertInstanceOf('Lunr\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that check_superfluous_checks() sets check_superfluous to TRUE.
     *
     * @covers Lunr\Core\Verification::ignore_unchecked_indexes
     */
    public function testCheckSuperfluousChecksSetsCheckSuperfluousTrue()
    {
        $property = $this->verification_reflection->getProperty('check_superfluous');
        $property->setAccessible(TRUE);

        $this->verification->check_superfluous_checks();

        $this->assertTrue($property->getValue($this->verification));
    }

    /**
     * Test the fluid interface of check_superfluous_checks.
     *
     * @covers Lunr\Core\Verification::check_superfluous_checks
     */
    public function testCheckSuperfluousChecksReturnsSelfReference()
    {
        $value = $this->verification->check_superfluous_checks();

        $this->assertInstanceOf('Lunr\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test the fluid interface of inspect().
     *
     * @covers Lunr\Core\Verification::inspect
     */
    public function testInspectReturnsSelfReference()
    {
        $value = $this->verification->inspect('test');

        $this->assertInstanceOf('Lunr\Core\Verification', $value);
        $this->assertSame($this->verification, $value);
    }

    /**
     * Test that inspect() sets the pointer if the passed index exists.
     *
     * @covers Lunr\Core\Verification::inspect
     */
    public function testInspectSetsPointerIfIndexExists()
    {
        $test = array('test' => 'value');

        $data = $this->verification_reflection->getProperty('data');
        $data->setAccessible(TRUE);
        $data->setValue($this->verification, $test);

        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $this->verification->inspect('test');

        $this->assertEquals('test', $property->getValue($this->verification));
    }

    /**
     * Test that inspect() sets the pointer NULL if the passed index does not exist.
     *
     * @covers Lunr\Core\Verification::inspect
     */
    public function testInspectSetsPointerNullIfIndexDoesNotExist()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $this->verification->inspect('test');

        $this->assertNull($property->getValue($this->verification));
    }

    /**
     * Test that inspect() adds the passed index to superfluous if it does not exist.
     *
     * @covers Lunr\Core\Verification::inspect
     */
    public function testInspectAddsIndexToSuperfluousIfItDoesNotExist()
    {
        $property = $this->verification_reflection->getProperty('superfluous');
        $property->setAccessible(TRUE);

        $this->verification->inspect('test');

        $value = $property->getValue($this->verification);

        $this->assertInternalType('array', $value);
        $this->assertContains('test', $value);
    }

}

?>
