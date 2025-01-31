<?php

/**
 * This file contains the CliRequestParserParseSuperGlobalTest class.
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
class CliRequestParserParseSuperGlobalTest extends CliRequestParserTestCase
{

    /**
     * Test storing invalid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testParseInvalidSuperGlobalValues(): void
    {
        $method = $this->getReflectionMethod('parse_super_global');
        $result = $method->invokeArgs($this->class, [ 'var' ]);

        $this->assertArrayEmpty($result);
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testParseValidSuperGlobalValues(): void
    {
        $property = $this->getReflectionProperty('ast');
        $ast      = $property->getValue($this->class);

        $ast['var'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $method = $this->getReflectionMethod('parse_super_global');
        $result = $method->invokeArgs($this->class, [ 'var' ]);

        $this->assertEquals($_VAR, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Shadow\CliRequestParser::parse_super_global
     */
    public function testSuperGlobalEmptyAfterParse(): void
    {
        $property = $this->getReflectionProperty('ast');
        $ast      = $property->getValue($this->class);

        $ast['var'] = [ 'test1=value1&test2=value2' ];

        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $property->setValue($this->class, $ast);

        $method = $this->getReflectionMethod('parse_super_global');
        $method->invokeArgs($this->class, [ 'var' ]);

        $after = $property->getValue($this->class);

        $this->assertIsArray($after);
        $this->assertNotCount(0, $after);
        $this->assertArrayNotHasKey('var', $after);
    }

}

?>
