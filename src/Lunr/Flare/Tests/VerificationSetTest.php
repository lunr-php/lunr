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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;

/**
 * This class contains the tests for the setters of the verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
class VerificationSetTest extends VerificationTest
{

    /**
     * Test the fluid interface of set_data().
     *
     * @covers Lunr\Flare\Verification::set_data
     */
    public function testSetDataReturnsSelfReference()
    {
        $set   = array('1');
        $value = $this->class->set_data($set);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that set_data() populates the data array.
     *
     * @covers Lunr\Flare\Verification::set_data
     */
    public function testSetDataSetsData()
    {
        $set = array('test' => 'value');

        $this->class->set_data($set);
        $this->assertPropertySame('data', $set);
    }

    /**
     * Test that set_data() sets the data array as empty when an invalid value is passed.
     *
     * @param mixed $value Dataset for population
     *
     * @dataProvider invalidDatasetProvider
     * @covers       Lunr\Flare\Verification::set_data
     */
    public function testSetDataSetsEmptyArrayAsDataIfDatasetIsInvalid($value)
    {
        $this->logger->expects($this->once())
                     ->method('error');

        $this->set_reflection_property_value('data', array('test' => 'value'));

        $this->class->set_data($value);

        $data = $this->get_reflection_property_value('data');

        $this->assertArrayEmpty($data);
    }

    /**
     * Test that set_data resets the verification state.
     *
     * @covers Lunr\Flare\Verification::set_data
     */
    public function testSetDataResetsVerificationState()
    {
        $props      = $this->reflection->getProperties();
        $properties = array();

        foreach ($props as &$value)
        {
            $value->setAccessible(TRUE);
            $properties[$value->getName()] = $value;
        }

        unset($value);

        $properties['check_remaining']->setValue($this->class, FALSE);
        $properties['check_superfluous']->setValue($this->class, TRUE);
        $properties['superfluous']->setValue($this->class, array('test'));
        $properties['result']->setValue($this->class, array('test'));
        $properties['pointer']->setValue($this->class, 'test');
        $properties['identifier']->setValue($this->class, 'Testing');

        $set = array('1');
        $this->class->set_data($set);


        $this->assertTrue($properties['check_remaining']->getValue($this->class));
        $this->assertFalse($properties['check_superfluous']->getValue($this->class));
        $this->assertNull($properties['pointer']->getValue($this->class));

        $superfluous = $properties['superfluous']->getValue($this->class);
        $result      = $properties['result']->getValue($this->class);
        $identifier  = $properties['identifier']->getValue($this->class);

        $this->assertInternalType('string', $identifier);

        $this->assertArrayEmpty($superfluous);
        $this->assertArrayEmpty($result);
        $this->assertEmpty($identifier);
    }

    /**
     * Test setting an identifier.
     *
     * @covers Lunr\Flare\Verification::set_identifier
     */
    public function testSetIdentifierSetsIdentifier()
    {
        $id = 'Test Verification';

        $this->class->set_identifier($id);

        $this->assertPropertyEquals('identifier', $id);
    }

    /**
     * Test the fluid interface of set_identifier.
     *
     * @covers Lunr\Flare\Verification::set_identifier
     */
    public function testSetIdentifierReturnsSelfReference()
    {
        $id = 'Test Verification';

        $value = $this->class->set_identifier($id);

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that ignore_unchecked_indexes() sets check_remaining to FALSE.
     *
     * @covers Lunr\Flare\Verification::ignore_unchecked_indexes
     */
    public function testIgnoreUncheckedIndexesSetsCheckRemainingFalse()
    {
        $this->class->ignore_unchecked_indexes();

        $this->assertFalse($this->get_reflection_property_value('check_remaining'));
    }

    /**
     * Test the fluid interface of ignore_unchecked_indexes.
     *
     * @covers Lunr\Flare\Verification::ignore_unchecked_indexes
     */
    public function testIgnoreUncheckedIndexesReturnsSelfReference()
    {
        $value = $this->class->ignore_unchecked_indexes();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that check_superfluous_checks() sets check_superfluous to TRUE.
     *
     * @covers Lunr\Flare\Verification::ignore_unchecked_indexes
     */
    public function testCheckSuperfluousChecksSetsCheckSuperfluousTrue()
    {
        $this->class->check_superfluous_checks();

        $this->assertTrue($this->get_reflection_property_value('check_superfluous'));
    }

    /**
     * Test the fluid interface of check_superfluous_checks.
     *
     * @covers Lunr\Flare\Verification::check_superfluous_checks
     */
    public function testCheckSuperfluousChecksReturnsSelfReference()
    {
        $value = $this->class->check_superfluous_checks();

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test the fluid interface of inspect().
     *
     * @covers Lunr\Flare\Verification::inspect
     */
    public function testInspectReturnsSelfReference()
    {
        $value = $this->class->inspect('test');

        $this->assertInstanceOf('Lunr\Flare\Verification', $value);
        $this->assertSame($this->class, $value);
    }

    /**
     * Test that inspect() sets the pointer if the passed index exists.
     *
     * @covers Lunr\Flare\Verification::inspect
     */
    public function testInspectSetsPointerIfIndexExists()
    {
        $test = array('test' => 'value');

        $data = $this->set_reflection_property_value('data', $test);

        $this->class->inspect('test');

        $this->assertPropertyEquals('pointer', 'test');
    }

    /**
     * Test that inspect() sets the pointer NULL if the passed index does not exist.
     *
     * @covers Lunr\Flare\Verification::inspect
     */
    public function testInspectSetsPointerNullIfIndexDoesNotExist()
    {
        $this->class->inspect('test');

        $this->assertNull($this->get_reflection_property_value('pointer'));
    }

    /**
     * Test that inspect() adds the passed index to superfluous if it does not exist.
     *
     * @covers Lunr\Flare\Verification::inspect
     */
    public function testInspectAddsIndexToSuperfluousIfItDoesNotExist()
    {
        $this->class->inspect('test');

        $value = $this->get_reflection_property_value('superfluous');

        $this->assertInternalType('array', $value);
        $this->assertContains('test', $value);
    }

}

?>
