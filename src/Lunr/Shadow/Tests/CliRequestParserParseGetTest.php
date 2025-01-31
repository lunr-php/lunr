<?php

/**
 * This file contains the CliRequestParserParseGetTest class.
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
class CliRequestParserParseGetTest extends CliRequestParserTestCase
{

    /**
     * Test storing empty super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_get
     */
    public function testParseEmptySuperGlobalValues(): void
    {
        $result = $this->class->parse_get();

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_get
     */
    public function testParseValidGetValues(): void
    {
        $property = $this->getReflectionProperty('ast');
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
    public function testGetEmptyAfterParse(): void
    {
        $property = $this->getReflectionProperty('ast');
        $ast      = $property->getValue($this->class);

        $ast['get'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $this->class->parse_get();

        $after = $property->getValue($this->class);

        $this->assertIsArray($after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('get', $after);
    }

}

?>
