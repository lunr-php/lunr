<?php

/**
 * This file contains the WebRequestParserParseSuperGlobalTest class.
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
class WebRequestParserParseSuperGlobalTest extends WebRequestParserTestCase
{

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the superglobal super global is reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $var   Invalid super global values
    * @param bool  $reset Whether or not to reset the super global afterwards.
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_super_global
    */
    public function testParseInvalidSuperGlobalValuesResetsSuperGlobal($var, $reset): void
    {
        $_VAR = $var;

        $method = $this->getReflectionMethod('parse_super_global');
        $method->invokeArgs($this->class, [ & $_VAR, $reset ]);
        if ($reset)
        {
            $this->assertArrayEmpty($_VAR);
        }
        else
        {
            $this->assertEquals($var, $_VAR);
        }
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testParseValidSuperGlobalValues(): void
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';
        $cache         = $_VAR;

        $method = $this->getReflectionMethod('parse_super_global');
        $result = $method->invokeArgs($this->class, [ & $_VAR ]);

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is empty after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testSuperGlobalEmptyAfterParse(): void
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $method = $this->getReflectionMethod('parse_super_global');
        $method->invokeArgs($this->class, [ & $_VAR ]);

        $this->assertArrayEmpty($_VAR);
    }

    /**
     * Test that super global is not empty after storing with reset is FALSE.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_super_global
     */
    public function testSuperGlobalNotEmptyAfterParse(): void
    {
        $_VAR['test1'] = 'value1';
        $_VAR['test2'] = 'value2';

        $_EXP = $_VAR;

        $method = $this->getReflectionMethod('parse_super_global');
        $method->invokeArgs($this->class, [ & $_EXP, FALSE ]);

        $this->assertEquals($_VAR, $_EXP);
    }

}

?>
