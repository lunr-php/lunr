<?php

/**
 * This file contains the CliRequestParserParseSuperGlobalTest class.
 *
 * PHP Version 5.4
 *
 * @category   Libraries
 * @package    Shadow
 * @subpackage Tests
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @category      Libraries
 * @package       Shadow
 * @subpackage    Tests
 * @author        Heinz Wiesinger <heinz@m2mobi.com>
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseSuperGlobalTest extends CliRequestParserTest
{

    /**
     * Test storing invalid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testParseInvalidSuperGlobalValues()
    {
        $method = $this->get_accessible_reflection_method('parse_super_global');
        $result = $method->invokeArgs($this->class, [ 'var' ]);

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testParseValidSuperGlobalValues()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['var'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $result = $method->invokeArgs($this->class, [ 'var' ]);

        $this->assertEquals($_VAR, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testSuperGlobalEmptyAfterParse()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['var'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $method->invokeArgs($this->class, [ 'var' ]);

        $after = $property->getValue($this->class);

        $this->assertInternalType('array', $after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('var', $after);
    }

}

?>
