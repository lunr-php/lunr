<?php

/**
 * This file contains the RequestGetValueTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestValueParserInterface;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * Tests for getting request values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestGetValueTest extends RequestTest
{

    /**
     * Check that get() returns cached values.
     *
     * @covers Lunr\Corona\Request::get
     */
    public function testGetWithCachedValue(): void
    {
        $cache = [
            'foo' => 'bar',
        ];

        $this->set_reflection_property_value('request', $cache);

        $value = $this->class->get(MockRequestValue::Foo);

        $this->assertEquals('bar', $value);
    }

    /**
     * Check that get() returns mocked values.
     *
     * @covers Lunr\Corona\Request::get
     */
    public function testGetWithMockedValue(): void
    {
        $cache = [
            'foo' => 'bar',
        ];

        $mock = [
            'foo' => 'baz',
        ];

        $this->set_reflection_property_value('request', $cache);
        $this->set_reflection_property_value('mock', $mock);

        $value = $this->class->get(MockRequestValue::Foo);

        $this->assertEquals('baz', $value);
    }

    /**
     * Check that get() throws an exception for a value with an unregistered parser.
     *
     * @covers Lunr\Corona\Request::get
     */
    public function testGetWithUncachedValueAndUnregisteredParserThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No parser registered for requested value ("foo")!');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Check that get() returns uncached values.
     *
     * @covers Lunr\Corona\Request::get
     */
    public function testGetWithUncachedValue(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            MockRequestValue::class => $parser,
        ];

        $this->set_reflection_property_value('parsers', $parsers);

        $parser->expects($this->once())
               ->method('get')
               ->with(MockRequestValue::Foo)
               ->willReturn('bar');

        $value = $this->class->get(MockRequestValue::Foo);

        $this->assertEquals('bar', $value);
    }

}

?>
