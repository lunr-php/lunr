<?php

/**
 * This file contains the CliRequestParserParseCookieTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2014 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Shadow\Tests;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers        Lunr\Shadow\CliRequestParser
 * @backupGlobals enabled
 */
class CliRequestParserParseCookieTest extends CliRequestParserTest
{

    /**
     * Test storing empty super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_cookie
     */
    public function testParseEmptySuperGlobalValues(): void
    {
        $result = $this->class->parse_cookie();

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_cookie
     */
    public function testParseValidCookieValues(): void
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['cookie'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_cookie();

        $this->assertEquals($_VAR, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_cookie
     */
    public function testCookieEmptyAfterParse(): void
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['cookie'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_cookie();

        $after = $property->getValue($this->class);

        $this->assertIsArray($after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('cookie', $after);
    }

    /**
     * Test that $_COOKIE has only PHPSESSID after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_cookie
     */
    public function testSuperglobalCookieWithPHPSESSIDSet(): void
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['cookie'] = [ 'test1=value1&test2=value2&PHPSESSID=value3' ];

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_cookie();

        $this->assertCount(1, $_COOKIE);
        $this->assertArrayHasKey('PHPSESSID', $_COOKIE);
        $this->assertArrayNotHasKey('PHPSESSID', $result);
    }

}

?>
