<?php

/**
 * This file contains the TracingInfoParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\TracingInfo\Tests;

use Lunr\Corona\Parsers\TracingInfo\TracingInfoParser;
use Lunr\Corona\Parsers\TracingInfo\TracingInfoValue;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the TracingInfoParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\TracingInfo\TracingInfoParser
 */
class TracingInfoParserGetTest extends TracingInfoParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(TracingInfoValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed trace ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetParsedTraceID()
    {
        $traceID = '2cdfe3157e8649319704b5c6af3d0e80';

        $this->setReflectionPropertyValue('traceID', $traceID);

        $value = $this->class->get(TracingInfoValue::TraceID);

        $this->assertEquals($traceID, $value);
    }

    /**
     * Test getting a trace ID from the REQUEST_ID HTTP header.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetTraceIDFromHttpHeader()
    {
        $traceID = '2cdfe3157e8649319704b5c6af3d0e80';

        $_SERVER['REQUEST_ID'] = $traceID;

        $value = $this->class->get(TracingInfoValue::TraceID);

        $this->assertEquals($traceID, $value);
        $this->assertPropertySame('traceID', $traceID);
    }

    /**
     * Test getting a trace ID generates a new ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetTraceIDGeneratesNewID()
    {
        $traceID = '49f58d6f02244946acf9efcd63896263';

        $this->mockFunction('uuid_create', fn() => '49f58d6f-0224-4946-acf9-efcd63896263');

        $value = $this->class->get(TracingInfoValue::TraceID);

        $this->assertEquals($traceID, $value);
        $this->assertPropertySame('traceID', $traceID);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a trace ID generates a new UUID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetTraceIDGeneratesNewUUID()
    {
        $traceID = '49f58d6f-0224-4946-acf9-efcd63896263';

        $this->mockFunction('uuid_create', fn() => $traceID);

        $class = new TracingInfoParser(uuidAsHexString: FALSE);

        $value = $class->get(TracingInfoValue::TraceID);

        $this->assertEquals($traceID, $value);

        $property = $this->getReflectionProperty('traceID');
        $this->assertEquals($traceID, $property->getValue($class));

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a parsed request ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetParsedRequestID()
    {
        $traceID = '2cdfe3157e8649319704b5c6af3d0e80';

        $this->setReflectionPropertyValue('traceID', $traceID);

        $value = $this->class->get(TracingInfoValue::RequestID);

        $this->assertEquals($traceID, $value);
    }

    /**
     * Test getting a request ID from the REQUEST_ID HTTP header.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetRequestIDFromHttpHeader()
    {
        $traceID = '2cdfe3157e8649319704b5c6af3d0e80';

        $_SERVER['REQUEST_ID'] = $traceID;

        $value = $this->class->get(TracingInfoValue::RequestID);

        $this->assertEquals($traceID, $value);
        $this->assertPropertySame('traceID', $traceID);
    }

    /**
     * Test getting a request ID generates a new ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetRequestIDGeneratesNewID()
    {
        $traceID = '49f58d6f02244946acf9efcd63896263';

        $this->mockFunction('uuid_create', fn() => '49f58d6f-0224-4946-acf9-efcd63896263');

        $value = $this->class->get(TracingInfoValue::RequestID);

        $this->assertEquals($traceID, $value);
        $this->assertPropertySame('traceID', $traceID);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a request ID generates a new UUID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetRequestIDGeneratesNewUUID()
    {
        $traceID = '49f58d6f-0224-4946-acf9-efcd63896263';

        $this->mockFunction('uuid_create', fn() => $traceID);

        $class = new TracingInfoParser(uuidAsHexString: FALSE);

        $value = $class->get(TracingInfoValue::RequestID);

        $this->assertEquals($traceID, $value);

        $property = $this->getReflectionProperty('traceID');
        $this->assertEquals($traceID, $property->getValue($class));

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a parsed span ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetParsedSpanID()
    {
        $spanID = '9b00922000f349e6bd688349d2dc2b38';

        $this->setReflectionPropertyValue('spanID', $spanID);

        $value = $this->class->get(TracingInfoValue::SpanID);

        $this->assertEquals($spanID, $value);
    }

    /**
     * Test getting a span ID generates a new ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetSpanIDGeneratesNewID()
    {
        $spanID = '49f58d6f02244946acf9efcd63896263';

        $this->mockFunction('uuid_create', fn() => '49f58d6f-0224-4946-acf9-efcd63896263');

        $value = $this->class->get(TracingInfoValue::SpanID);

        $this->assertEquals($spanID, $value);
        $this->assertPropertySame('spanID', $spanID);

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a span ID generates a new UUID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetSpanIDGeneratesNewUUID()
    {
        $spanID = '49f58d6f-0224-4946-acf9-efcd63896263';

        $this->mockFunction('uuid_create', fn() => $spanID);

        $class = new TracingInfoParser(uuidAsHexString: FALSE);

        $value = $class->get(TracingInfoValue::SpanID);

        $this->assertEquals($spanID, $value);

        $property = $this->getReflectionProperty('spanID');
        $this->assertEquals($spanID, $property->getValue($class));

        $this->unmockFunction('uuid_create');
    }

    /**
     * Test getting a parent span ID.
     *
     * @covers Lunr\Corona\Parsers\TracingInfo\TracingInfoParser::get
     */
    public function testGetParentSpanID()
    {
        $value = $this->class->get(TracingInfoValue::ParentSpanID);

        $this->assertNull($value);
    }

}

?>
