<?php

/**
 * This file contains the CliRequestParserParseGetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Shadow
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseGetTest extends CliRequestParserTest
{

    /**
     * Test storing empty super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_get
     */
    public function testParseEmptySuperGlobalValues()
    {
        $result = $this->class->parse_get();

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_get
     */
    public function testParseValidGetValues()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['get'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_get();

        $this->assertEquals($_VAR, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_get
     */
    public function testGetEmptyAfterParse()
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['get'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_get();

        $after = $property->getValue($this->class);

        $this->assertInternalType('array', $after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('get', $after);
    }

}

?>
