<?php

/**
 * This file contains the VerificationBaseTest class.
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
 * This class contains tests for the constructor of the Verification class.
 *
 * @category   Libraries
 * @package    Core
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Core\Verification
 */
class VerificationBaseTest extends VerificationTest
{

    /**
     * Test that the logger object is passed.
     */
    public function testLoggerPassed()
    {
        $property = $this->verification_reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->verification);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that the data array is empty by default.
     */
    public function testDataIsEmptyByDefault()
    {
        $property = $this->verification_reflection->getProperty('data');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->verification);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the result array is empty by default.
     */
    public function testResultIsEmptyByDefault()
    {
        $property = $this->verification_reflection->getProperty('result');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->verification);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the pointer is NULL by default.
     */
    public function testPointerIsNullByDefault()
    {
        $property = $this->verification_reflection->getProperty('pointer');
        $property->setAccessible(TRUE);

        $this->assertNull($property->getValue($this->verification));
    }

    /**
     * Test that the superfluous array is empty by default.
     */
    public function testSuperfluousIsEmptyByDefault()
    {
        $property = $this->verification_reflection->getProperty('superfluous');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->verification);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the identifier is an empty string by default.
     */
    public function testIdentifierIsEmptyStringByDefault()
    {
        $property = $this->verification_reflection->getProperty('identifier');
        $property->setAccessible(TRUE);

        $this->assertEquals('', $property->getValue($this->verification));
    }

    /**
     * Test that check_remaining is TRUE by default.
     */
    public function testCheckRemainingIsTrueByDefault()
    {
        $property = $this->verification_reflection->getProperty('check_remaining');
        $property->setAccessible(TRUE);

        $this->assertTrue($property->getValue($this->verification));
    }

    /**
     * Test that check_superfluous is FALSE by default.
     */
    public function testCheckSuperfluousIsFalseByDefault()
    {
        $property = $this->verification_reflection->getProperty('check_superfluous');
        $property->setAccessible(TRUE);

        $this->assertFalse($property->getValue($this->verification));
    }

}

?>
