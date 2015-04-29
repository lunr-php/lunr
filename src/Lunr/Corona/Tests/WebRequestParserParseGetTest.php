<?php

/**
 * This file contains the WebRequestParserParseGetTest class.
 *
 * PHP Version 5.4
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @copyright  2014, M2Mobi BV, Amsterdam, The Netherlands
 * @license    http://lunr.nl/LICENSE MIT License
 */

namespace Lunr\Corona\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Corona\WebRequestParser
 * @backupGlobals enabled
 */
class WebRequestParserParseGetTest extends WebRequestParserTest
{

    /**
     * Test storing invalid super global values.
     *
     * @param mixed $get Invalid super global values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\WebRequestParser::parse_get
     */
    public function testParseInvalidGetValuesReturnsEmptyArray($get)
    {
        $_GET = $get;

        $result = $this->class->parse_get();

        $this->assertArrayEmpty($result);
    }

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $get Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_get
    */
    public function testParseInvalidGetValuesResetsGet($get)
    {
        $_GET = $get;

        $this->class->parse_get();

        $this->assertArrayEmpty($_GET);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_get
     */
    public function testParseValidGetValues()
    {
        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';
        $cache         = $_GET;

        $result = $this->class->parse_get();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_get
     */
    public function testGetEmptyAfterParse()
    {
        $_GET['test1'] = 'value1';
        $_GET['test2'] = 'value2';

        $this->class->parse_get();

        $this->assertArrayEmpty($_GET);
    }

}

?>
