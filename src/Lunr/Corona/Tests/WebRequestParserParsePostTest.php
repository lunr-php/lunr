<?php

/**
 * This file contains the WebRequestParserParsePostTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
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
    public function testParseInvalidPostValuesReturnsEmptyArray($post): void
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
    public function testParseInvalidPostValuesResetsPost($post): void
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
    public function testParseValidPostValues(): void
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
    public function testPostEmptyAfterParse(): void
    {
        $_POST['test1'] = 'value1';
        $_POST['test2'] = 'value2';

        $this->class->parse_post();

        $this->assertArrayEmpty($_POST);
    }

}

?>
