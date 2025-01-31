<?php

/**
 * This file contains the RequestBaseTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestValueParserInterface;

/**
 * Basic tests for the case of empty superglobals.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestBaseTest extends RequestTestCase
{

    /**
     * Check that post values are set correctly.
     */
    public function testPost(): void
    {
        $this->assertEquals([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ], $this->getReflectionPropertyValue('post'));
    }

    /**
     * Check that server values are set correctly.
     */
    public function testServer(): void
    {
        $server = [
            'server_key'      => 'server_value',
            'HTTP_SERVER_KEY' => 'HTTP_SERVER_VALUE',
        ];

        $this->assertEquals($server, $this->getReflectionPropertyValue('server'));
    }

    /**
     * Check that get values are set correctly.
     */
    public function testGet(): void
    {
        $this->assertEquals([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ], $this->getReflectionPropertyValue('get'));
    }

    /**
     * Check that files values are set correctly.
     */
    public function testFiles(): void
    {
        $this->assertEquals($this->files, $this->getReflectionPropertyValue('files'));
    }

    /**
     * Check that cookie values are set correctly.
     */
    public function testCookie(): void
    {
        $this->assertEquals([ 'cookie_key' => 'cookie_value' ], $this->getReflectionPropertyValue('cookie'));
    }

    /**
     * Check that cli argument values are set correctly.
     */
    public function testCliArgs(): void
    {
        $this->assertArrayEmpty($this->getReflectionPropertyValue('cli_args'));
    }

    /**
     * Check that raw data is set correctly.
     */
    public function testRawData(): void
    {
        $this->assertSame('', $this->getReflectionPropertyValue('raw_data'));
    }

    /**
     * Check that request is filled with sane default values.
     *
     * @param string $key   Key for a request value
     * @param mixed  $value Value of a request value
     *
     * @dataProvider requestValueProvider
     */
    public function testRequestDefaultValues($key, $value): void
    {
        $request = $this->getReflectionPropertyValue('request');

        $this->assertArrayHasKey($key, $request);
        $this->assertEquals($value, $request[$key]);
    }

    /**
     * Test that register_parser() registers a parser.
     *
     * @covers Lunr\Corona\Request::register_parser
     */
    public function testRegisterParser(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parser->expects($this->once())
               ->method('get_request_value_type')
               ->willReturn('Lunr\Corona\Parser\Foo\Foo');

        $this->class->register_parser($parser);

        $parsers = $this->getReflectionPropertyValue('parsers');

        $this->assertCount(1, $parsers);
        $this->assertArrayHasKey('Lunr\Corona\Parser\Foo\Foo', $parsers);
        $this->assertEquals($parser, $parsers['Lunr\Corona\Parser\Foo\Foo']);
    }

}

?>
