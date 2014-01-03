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
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @copyright  2013-2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

use Lunr\Halo\PsrLoggerTestTrait;

/**
 * This class contains base test methods for the LunrCliParser class.
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Andrea Nigido <andrea@m2mobi.com>
 * @covers     Lunr\Shadow\LunrCliParser
 */
class LunrCliParserBaseTest extends LunrCliParserTest
{

    /**
     * Test that the Console class is passed correctly.
     */
    public function testConsoleIsPassedCorrectly()
    {
        $this->assertPropertySame('console', $this->console);
    }

    /**
     * Test that the short options string is passed correctly.
     */
    public function testShortOptsIsPassedCorrectly()
    {
        $this->assertPropertyEquals('short', 'ab:c;d:;e::');
    }

    /**
     * Test that the long options string is passed correctly.
     */
    public function testLongOptsIsPassedCorrectly()
    {
        $this->assertPropertyEquals('long', array('first', 'second:', 'third;', 'fourth:;', 'fifth::'));
    }

    /**
     * Test that the argument array is empty by default.
     */
    public function testArgsIsEmptyArrayByDefault()
    {
        $value = $this->get_reflection_property_value('args');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the checked array is empty by default.
     */
    public function testCheckedIsEmptyArrayByDefault()
    {
        $value = $this->get_reflection_property_value('checked');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that the AST array is empty by default.
     */
    public function testASTisEmptyArrayByDefault()
    {
        $value = $this->get_reflection_property_value('ast');

        $this->assertArrayEmpty($value);
    }

    /**
     * Test that error is set to FALSE by default.
     */
    public function testErrorIsFalseByDefault()
    {
        $this->assertFalse($this->get_reflection_property_value('error'));
    }

    /**
     * Test that is_invalid_commandline() returns the value of error.
     *
     * @covers Lunr\Shadow\LunrCliParser::is_invalid_commandline
     */
    public function testIsInvalidCommandLineReturnsError()
    {
        $value = $this->get_reflection_property_value('error');

        $this->assertEquals($value, $this->class->is_invalid_commandline());
    }

}

?>
