<?php

/**
 * This file contains the RequestGetValueTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Lunr\Corona\RequestValueParserInterface;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * Tests for getting request values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestGetValueTest extends RequestTestCase
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

        $this->setReflectionPropertyValue('request', $cache);

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

        $this->setReflectionPropertyValue('request', $cache);
        $this->setReflectionPropertyValue('mock', [ $mock ]);

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

        $this->setReflectionPropertyValue('parsers', $parsers);

        $parser->expects($this->once())
               ->method('get')
               ->with(MockRequestValue::Foo)
               ->willReturn('bar');

        $value = $this->class->get(MockRequestValue::Foo);

        $this->assertEquals('bar', $value);
    }

    /**
     * Check that getTraceId() returns cached values.
     *
     * @covers Lunr\Corona\Request::getTraceId
     */
    public function testGetTraceIdWithCachedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::TraceID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);

        $value = $this->class->getTraceId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getTraceId() returns mocked values.
     *
     * @covers Lunr\Corona\Request::getTraceId
     */
    public function testGetTraceIdWithMockedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::TraceID->value => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6',
        ];

        $mock = [
            TracingInfoValue::TraceID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);
        $this->setReflectionPropertyValue('mock', [ $mock ]);

        $value = $this->class->getTraceId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getTraceId() returns uncached values.
     *
     * @covers Lunr\Corona\Request::getTraceId
     */
    public function testGetTraceIdWithUncachedValue(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::TraceID)
               ->willReturn($id);

        $value = $this->class->getTraceId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getSpanId() returns cached values.
     *
     * @covers Lunr\Corona\Request::getSpanId
     */
    public function testGetSpanIdWithCachedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::SpanID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);

        $value = $this->class->getSpanId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getSpanId() returns mocked values.
     *
     * @covers Lunr\Corona\Request::getSpanId
     */
    public function testGetSpanIdWithMockedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::SpanID->value => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6',
        ];

        $mock = [
            TracingInfoValue::SpanID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);
        $this->setReflectionPropertyValue('mock', [ $mock ]);

        $value = $this->class->getSpanId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getSpanId() returns uncached values.
     *
     * @covers Lunr\Corona\Request::getSpanId
     */
    public function testGetSpanIdWithUncachedValue(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::SpanID)
               ->willReturn($id);

        $value = $this->class->getSpanId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getParentSpanId() returns cached values.
     *
     * @covers Lunr\Corona\Request::getParentSpanId
     */
    public function testGetParentSpanIdWithCachedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::ParentSpanID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);

        $value = $this->class->getParentSpanId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getParentSpanId() returns mocked values.
     *
     * @covers Lunr\Corona\Request::getParentSpanId
     */
    public function testGetParentSpanIdWithMockedValue(): void
    {
        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $cache = [
            TracingInfoValue::ParentSpanID->value => '200c5938-cbe1-4b58-ad36-022ab5c6bcc6',
        ];

        $mock = [
            TracingInfoValue::ParentSpanID->value => $id,
        ];

        $this->setReflectionPropertyValue('request', $cache);
        $this->setReflectionPropertyValue('mock', [ $mock ]);

        $value = $this->class->getParentSpanId();

        $this->assertEquals($id, $value);
    }

    /**
     * Check that getParentSpanId() returns uncached values.
     *
     * @covers Lunr\Corona\Request::getParentSpanId
     */
    public function testGetParentSpanIdWithUncachedValue(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            TracingInfoValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $id = '1bee74f0-5f21-4b7f-9fff-62e7320e9aa5';

        $parser->expects($this->once())
               ->method('get')
               ->with(TracingInfoValue::ParentSpanID)
               ->willReturn($id);

        $value = $this->class->getParentSpanId();

        $this->assertEquals($id, $value);
    }

}

?>
