<?php

/**
 * This file contains the WebRequestParserParseCookieTest class.
 *
 * @package    Lunr\Corona
 * @author     Heinz Wiesinger <heinz@m2mobi.com>
 * @author     Leonidas Diamantis <leonidas@m2mobi.com>
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
class WebRequestParserParseCookieTest extends WebRequestParserTest
{

    /**
     * Test storing invalid super global values.
     *
     * @param mixed $cookie Invalid super global values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\WebRequestParser::parse_cookie
     */
    public function testParseInvalidCookieValuesReturnsEmptyArray($cookie)
    {
        $_COOKIE = $cookie;

        $result = $this->class->parse_cookie();

        $this->assertArrayEmpty($result);
    }

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $cookie Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_cookie
    */
    public function testParseInvalidCookieValuesResetsCookie($cookie)
    {
        $_COOKIE = $cookie;

        $this->class->parse_cookie();

        $this->assertArrayEmpty($_COOKIE);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_cookie
     */
    public function testParseValidCookieValues()
    {
        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';
        $cache            = $_COOKIE;

        $result = $this->class->parse_cookie();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_cookie
     */
    public function testCookieEmptyAfterParse()
    {
        $_COOKIE['test1'] = 'value1';
        $_COOKIE['test2'] = 'value2';

        $this->class->parse_cookie();

        $this->assertArrayEmpty($_COOKIE);
    }

    /**
     * Test that $_COOKIE has only PHPSESSID after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_cookie
     */
    public function testSuperglobalCookieWithPHPSESSIDSet()
    {
        $_COOKIE['test1']     = 'value1';
        $_COOKIE['test2']     = 'value2';
        $_COOKIE['PHPSESSID'] = 'value3';

        $this->class->parse_cookie();

        $this->assertCount(1, $_COOKIE);
        $this->assertArrayHasKey('PHPSESSID', $_COOKIE);
    }

}

?>
