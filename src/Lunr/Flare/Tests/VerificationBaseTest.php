<?php

/**
 * This file contains the VerificationBaseTest class.
 *
 * PHP Version 5.3
 *
 * @category   Libraries
 * @package    Flare
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2012-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Flare\Tests;

use Lunr\Flare\Verification;

/**
 * This class contains tests for the constructor of the Verification class.
 *
 * @category   Libraries
 * @package    Flare
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Flare\Verification
 */
class VerificationBaseTest extends VerificationTest
{

    /**
     * Test that the logger object is passed.
     */
    public function testLoggerPassed()
    {
        $this->assertPropertySame('logger', $this->logger);
    }

    /**
     * Test that the data array is empty by default.
     */
    public function testDataIsEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('data');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the result array is empty by default.
     */
    public function testResultIsEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('result');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the pointer is NULL by default.
     */
    public function testPointerIsNullByDefault()
    {
        $this->assertNull($this->get_reflection_property_value('pointer'));
    }

    /**
     * Test that the superfluous array is empty by default.
     */
    public function testSuperfluousIsEmptyByDefault()
    {
        $value = $this->get_reflection_property_value('superfluous');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the identifier is an empty string by default.
     */
    public function testIdentifierIsEmptyStringByDefault()
    {
        $this->assertPropertyEquals('identifier', '');
    }

    /**
     * Test that check_remaining is TRUE by default.
     */
    public function testCheckRemainingIsTrueByDefault()
    {
        $this->assertTrue($this->get_reflection_property_value('check_remaining'));
    }

    /**
     * Test that check_superfluous is FALSE by default.
     */
    public function testCheckSuperfluousIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('check_superfluous'));
    }

}

?>
