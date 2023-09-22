<?php

/**
 * This file contains the RequestGetDataFromWrappersTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * Tests for getting stored superglobal values.
 *
 * @covers     Lunr\Corona\Request
 */
class RequestGetDataFromWrappersTest extends RequestTest
{

    /**
     * Test getting GET data returns get value if no mock value.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetData(): void
    {
        $this->assertEquals('get_value', $this->class->get_get_data('get_key'));
    }

    /**
     * Test getting GET data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetDataNoKey(): void
    {
        $this->assertEquals([ 'get_key' => 'get_value', 'get_second_key' => 'get_value' ], $this->class->get_get_data());
    }

    /**
     * Test getting GET data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetDataWithMockValue(): void
    {
        $this->set_reflection_property_value('mock', [ 'get' => [ 'get_key' => 'get_mock_value' ] ]);

        $this->assertEquals('get_mock_value', $this->class->get_get_data('get_key'));
    }

    /**
     * Test getting GET data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetDataWithMockValueNoKey(): void
    {
        $this->set_reflection_property_value('mock', [ 'get' => [ 'get_key' => 'get_mock_value', 'mock_key' => 'get_mock_value' ] ]);

        $expects = [
            'get_key'        => 'get_mock_value',
            'get_second_key' => 'get_value',
            'mock_key'       => 'get_mock_value',
        ];
        $this->assertEquals($expects, $this->class->get_get_data());
    }

    /**
     * Test getting GET data returns get value if empty mock value.
     *
     * @covers Lunr\Corona\Request::get_get_data
     */
    public function testGetGetDataWithInvalidMockValue(): void
    {
        $this->set_reflection_property_value('mock', [ 'get' => [] ]);

        $this->assertEquals('get_value', $this->class->get_get_data('get_key'));
    }

    /**
     * Test getting POST data returns post value if no mock value.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostData(): void
    {
        $this->assertEquals('post_value', $this->class->get_post_data('post_key'));
    }

    /**
     * Test getting POST data returns get values if no mock values.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostDataNoKey(): void
    {
        $this->assertEquals([ 'post_key' => 'post_value', 'post_second_key' => 'post_value' ], $this->class->get_post_data());
    }

    /**
     * Test getting POST data returns mock value if present.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostDataWithMockValue(): void
    {
        $this->set_reflection_property_value('mock', [ 'post' => [ 'post_key' => 'post_mock_value' ] ]);

        $this->assertEquals('post_mock_value', $this->class->get_post_data('post_key'));
    }

    /**
     * Test getting POST data returns mock values if present.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostDataWithMockValueNoKey(): void
    {
        $this->set_reflection_property_value('mock', [ 'post' => [ 'post_key' => 'post_mock_value', 'mock_key' => 'post_mock_value' ] ]);

        $expects = [
            'post_key'        => 'post_mock_value',
            'post_second_key' => 'post_value',
            'mock_key'        => 'post_mock_value',
        ];
        $this->assertEquals($expects, $this->class->get_post_data());
    }

    /**
     * Test getting POST data returns post value if empty mock value.
     *
     * @covers Lunr\Corona\Request::get_post_data
     */
    public function testGetPostDataWithInvalidMockValue(): void
    {
        $this->set_reflection_property_value('mock', [ 'post' => [] ]);

        $this->assertEquals('post_value', $this->class->get_post_data('post_key'));
    }

    /**
     * Test getting SERVER data.
     *
     * @covers Lunr\Corona\Request::get_server_data
     */
    public function testGetServerData(): void
    {
        $this->assertEquals('server_value', $this->class->get_server_data('server_key'));
    }

    /**
     * Test getting HTTP Header data.
     *
     * @covers Lunr\Corona\Request::get_http_header_data
     */
    public function testGetHeaderData(): void
    {
        $this->assertEquals('HTTP_SERVER_VALUE', $this->class->get_http_header_data('server_key'));
    }

    /**
     * Test getting FILES data.
     *
     * @covers Lunr\Corona\Request::get_files_data
     */
    public function testGetFileData(): void
    {
        $this->assertEquals($this->files['image'], $this->class->get_files_data('image'));
    }

    /**
     * Test getting COOKIE data.
     *
     * @covers Lunr\Corona\Request::get_cookie_data
     */
    public function testGetCookieData(): void
    {
        $this->assertEquals('cookie_value', $this->class->get_cookie_data('cookie_key'));
    }

    /**
     * Tests that get_all_options() returns the ast property.
     *
     * @param array $keys The array of keys to test
     *
     * @dataProvider cliArgsKeyProvider
     * @covers       Lunr\Corona\Request::get_all_options
     */
    public function testGetAllOptionsReturnsArray($keys): void
    {
        $values = [];
        for ($i = 0; $i < count($keys); $i++)
        {
            $values[] = 'value';
        }

        $class = $this->reflection->newInstanceWithoutConstructor();

        $this->reflection->getProperty('cli_args')
                         ->setValue($class, array_combine($keys, $values));

        $return = $class->get_all_options();

        $this->assertEquals($keys, $return);
    }

    /**
     * Tests that get_option_data() returns a value for a proper key.
     *
     * @param array $value The expected value to test
     *
     * @dataProvider validCliArgsValueProvider
     * @covers       Lunr\Corona\Request::get_option_data
     */
    public function testGetOptionDataReturnsValueForValidKey($value): void
    {
        $class = $this->reflection->newInstanceWithoutConstructor();

        $this->reflection->getProperty('cli_args')
                         ->setValue($class, [ 'a' => $value ]);

        $result = $class->get_option_data('a');

        $this->assertEquals($value, $result);
    }

    /**
     * Tests that get_option_data() returns NULL for invalid key.
     *
     * @covers Lunr\Corona\Request::get_option_data
     */
    public function testGetOptionDataReturnsNullForInvalidKey(): void
    {
        $ast = $this->get_reflection_property_value('cli_args');

        $this->assertArrayNotHasKey('foo', $ast);
        $this->assertNull($this->class->get_option_data('foo'));
    }

    /**
     * Test that get_raw_data() returns raw request data.
     *
     * @covers Lunr\Corona\Request::get_raw_data
     */
    public function testGetRawDataReturnsRawRequestData(): void
    {
        $this->parser->expects($this->once())
                     ->method('parse_raw_data')
                     ->willReturn('raw');

        $this->assertEquals('raw', $this->class->get_raw_data());
    }

    /**
     * Test that get_raw_data() returns cached raw request data if parsing it is FALSE.
     *
     * @covers Lunr\Corona\Request::get_raw_data
     */
    public function testGetRawDataReturnsCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', FALSE);

        $this->assertEquals('raw', $this->class->get_raw_data());
        $this->assertEquals('raw', $this->class->get_raw_data());
        $this->assertEquals('raw', $this->get_reflection_property_value('raw_data'));
    }

    /**
     * Test that get_raw_data() returns no cached raw request data if parsing it is not empty.
     *
     * @covers Lunr\Corona\Request::get_raw_data
     */
    public function testGetRawDataReturnsUnCachedRawRequestData(): void
    {
        $this->parser->expects($this->exactly(2))
                     ->method('parse_raw_data')
                     ->willReturnOnConsecutiveCalls('raw', 'hello');

        $this->assertEquals('raw', $this->class->get_raw_data());
        $this->assertEquals('raw', $this->get_reflection_property_value('raw_data'));
        $this->assertEquals('hello', $this->class->get_raw_data());
        $this->assertEquals('hello', $this->get_reflection_property_value('raw_data'));
    }

}

?>
