<?php

/**
 * This file contains the RequestGetEnumValueTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2024 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

use Lunr\Corona\RequestEnumValueParserInterface;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use Lunr\Corona\Tests\Helpers\MockRequestValueEnum;
use RuntimeException;

/**
 * Tests for getAsEnumting request values.
 *
 * @covers Lunr\Corona\Request
 */
class RequestGetEnumValueTest extends RequestTestCase
{

    /**
     * Check that getAsEnum() throws an exception for a value with an unregistered parser.
     *
     * @covers Lunr\Corona\Request::getAsEnum
     */
    public function testGetWithUncachedValueAndUnregisteredParserThrowsException(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('No parser registered for requested value ("foo")!');

        $this->class->getAsEnum(MockRequestValue::Foo);
    }

    /**
     * Check that getAsEnum() throws an exception is the registered parser can't parse enums.
     *
     * @covers Lunr\Corona\Request::getAsEnum
     */
    public function testGetWithNormalParserThrowsException(): void
    {
        $parser = $this->getMockBuilder(RequestValueParserInterface::class)
                       ->getMock();

        $parsers = [
            MockRequestValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage(MockRequestValue::class . ' is not a valid parser for enum request values!');

        $this->class->getAsEnum(MockRequestValue::Foo);
    }

    /**
     * Check that getAsEnum() returns uncached values.
     *
     * @covers Lunr\Corona\Request::getAsEnum
     */
    public function testGetWithUncachedValue(): void
    {
        $parser = $this->getMockBuilder(RequestEnumValueParserInterface::class)
                       ->getMock();

        $parsers = [
            MockRequestValue::class => $parser,
        ];

        $this->setReflectionPropertyValue('parsers', $parsers);

        $parser->expects($this->once())
               ->method('getAsEnum')
               ->with(MockRequestValue::Foo)
               ->willReturn(MockRequestValueEnum::Bar);

        $value = $this->class->getAsEnum(MockRequestValue::Foo);

        $this->assertEquals(MockRequestValueEnum::Bar, $value);
    }

}

?>
