<?php

/**
 * This file contains the GetoptCliParserBaseTest class.
 *
 * PHP Version 5.3
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
 * This class contains base test methods for the GetoptCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @covers     Lunr\Shadow\GetoptCliParser
 */
class GetoptCliParserBaseTest extends GetoptCliParserTest
{

    /**
     * Test that the short options string is passed correctly.
     */
    public function testShortOptsIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('short');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals('ab:c::', $value);
    }

    /**
     * Test that the long options string is passed correctly.
     */
    public function testLongOptsIsPassedCorrectly()
    {
        $property = $this->reflection->getProperty('long');
        $property->setAccessible(TRUE);

        $value = $property->getValue($this->class);

        $this->assertEquals(array('first', 'second:', 'third::'), $value);
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
     * @covers Lunr\Shadow\GetoptCliParser::is_invalid_commandline
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
