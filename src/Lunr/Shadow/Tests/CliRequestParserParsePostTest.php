<?php

/**
 * This file contains the CliRequestParserParsePostTest class.
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
class CliRequestParserParsePostTest extends CliRequestParserTest
{

    /**
     * Test storing empty super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_post
     */
    public function testParseEmptySuperGlobalValues(): void
    {
        $result = $this->class->parse_post();

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_post
     */
    public function testParseValidPostValues(): void
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['post'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_post();

        $this->assertEquals($_VAR, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_post
     */
    public function testPostEmptyAfterParse(): void
    {
        $property = $this->get_accessible_reflection_property('ast');
        $ast      = $property->getValue($this->class);

        $ast['post'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $result = $this->class->parse_post();

        $after = $property->getValue($this->class);

        $this->assertIsArray($after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('post', $after);
    }

}

?>
