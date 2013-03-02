<?php

/**
 * This file contains the LunrCliParserBaseTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2013, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * This class contains base test methods for the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserBaseTest extends LunrCliParserTest
{

    /**
     * Test that the Logger class is passed correctly.
     */
    public function testLoggerIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('logger');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInstanceOf('Psr\Log\LoggerInterface', $value);
        $this->assertSame($this->logger, $value);
    }

    /**
     * Test that the short options string is passed correctly.
     */
    public function testShortOptsIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('short');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals('ab:c;d:;e::', $value);
    }

    /**
     * Test that the long options string is passed correctly.
     */
    public function testLongOptsIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('long');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals(array('first', 'second:', 'third;', 'fourth:;', 'fifth::'), $value);
    }

    /**
     * Test that the argument array is empty by default.
     */
    public function testArgsIsEmptyArrayByDefault()
    {
        $property = $this->reflection->getProperty('args');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the checked array is empty by default.
     */
    public function testCheckedIsEmptyArrayByDefault()
    {
        $property = $this->reflection->getProperty('checked');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that the AST array is empty by default.
     */
    public function testASTisEmptyArrayByDefault()
    {
        $property = $this->reflection->getProperty('ast');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertInternalType('array', $value);
        $this->assertEmpty($value);
    }

    /**
     * Test that error is set to FALSE by default.
     */
    public function testErrorIsFalseByDefault()
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertFalse($value);
    }

    /**
     * Test that is_invalid_commandline() returns the value of error.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_invalid_commandline
     */
    public function testIsInvalidCommandLineReturnsError()
    {
        $property = $this->reflection->getProperty('error');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals($value, $this->class->is_invalid_commandline());
    }

}

?>
