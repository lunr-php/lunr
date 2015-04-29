<?php

/**
 * This file contains the WebRequestParserParsePostTest class.
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
class WebRequestParserParsePostTest extends WebRequestParserTest
{

    /**
     * Test storing invalid super global values.
     *
     * @param mixed $post Invalid super global values
     *
     * @dataProvider invalidSuperglobalValueProvider
     * @covers       Lunr\Corona\WebRequestParser::parse_post
     */
    public function testParseInvalidPostValuesReturnsEmptyArray($post)
    {
        $_POST = $post;

        $result = $this->class->parse_post();

        $this->assertArrayEmpty($result);
    }

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $post Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_post
    */
    public function testParseInvalidPostValuesResetsPost($post)
    {
        $_POST = $post;

        $this->class->parse_post();

        $this->assertArrayEmpty($_POST);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_post
     */
    public function testParseValidPostValues()
    {
        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';
        $cache          = $_POST;

        $result = $this->class->parse_post();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_post
     */
    public function testPostEmptyAfterParse()
    {
        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';

        $this->class->parse_post();

        $this->assertArrayEmpty($_POST);
    }

}

?>
