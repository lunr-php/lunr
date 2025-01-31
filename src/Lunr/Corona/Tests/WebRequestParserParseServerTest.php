<?php

/**
 * This file contains the WebRequestParserParseServerTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2015 M2mobi B.V., Amsterdam, The Netherlands
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
class WebRequestParserParseServerTest extends WebRequestParserTestCase
{

    /**
    * Test storing invalid super global values.
    *
    * Checks whether the super global is not reset to being empty after
    * passing invalid super global values in it.
    *
    * @param mixed $server Invalid super global values
    *
    * @dataProvider invalidSuperglobalValueProvider
    * @covers       Lunr\Corona\WebRequestParser::parse_server
    */
    public function testParseInvalidServerValuesIntactServer($server): void
    {
        $backup = $_SERVER;

        $_SERVER = $server;

        $this->class->parse_server();

        $this->assertEquals($_SERVER, $server);

        $_SERVER = $backup;
    }

    /**
     * Test storing valid super global values.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_server
     */
    public function testParseValidServerValues(): void
    {
        $_SERVER['test1'] = 'value1';
        $_SERVER['test2'] = 'value2';
        $cache            = $_SERVER;

        $result = $this->class->parse_server();

        $this->assertEquals($cache, $result);
    }

    /**
     * Test that super global is intact after storing.
     *
     * @covers Lunr\Corona\WebRequestParser::parse_server
     */
    public function testServerIntactAfterParse(): void
    {
        $_SERVER['test1'] = 'value1';
        $_SERVER['test2'] = 'value2';

        $server = $_SERVER;

        $this->class->parse_server();

        $this->assertEquals($_SERVER, $server);
    }

}

?>
