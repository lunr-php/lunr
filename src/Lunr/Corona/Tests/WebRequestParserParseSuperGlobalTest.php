<?php

/**
 * This file contains the WebRequestParserParseSuperGlobalTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014-2018, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseSuperGlobalTest extends WebRequestParserTest
{

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed   $var   Invalid super global values
    * @param boolean $reset Whether or not to reset the super global afterwards.
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_super_global
    */
    public function testParseInvalidSuperGlobalValuesResetsSuperGlobal($var, $reset)
    {
        $_VAR = $var;

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $method->invokeArgs($this->class, [ & $_VAR, $reset]);
        if($reset)
        {
            $this->assertArrayEmpty($_VAR);
        }else{
            $this->assertEquals($var, $_VAR);
        }
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testParseValidSuperGlobalValues()
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';
        $cache         = $_VAR;

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $result = $method->invokeArgs($this->class, [ & $_VAR ]);

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testSuperGlobalEmptyAfterParse()
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $method->invokeArgs($this->class, [ & $_VAR ]);

        $this->assertArrayEmpty($_VAR);
    }

    /**
     * Test that super global is not empty after storing with reset is FALSE.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testSuperGlobalNotEmptyAfterParse()
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $_VAR_REF = $_VAR;

        $method = $this->get_accessible_reflection_method('parse_super_global');
        $method->invokeArgs($this->class, [ & $_VAR_REF, FALSE]);

        $this->assertEquals($_VAR, $_VAR_REF);
    }

}

?>
