<?php

/**
 * This file contains the ApiVersionHttpHeaderParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Framna Netherlands B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Parsers\ApiVersion\Tests;

use Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser;
use Lunr\Corona\Parsers\ApiVersion\ApiVersionValue;
use Lunr\Corona\Parsers\ApiVersion\Tests\Helpers\MockApiVersionEnum;
use Lunr\Corona\Tests\Helpers\MockRequestValue;
use RuntimeException;

/**
 * This class contains test methods for the ApiVersionHttpHeaderParser class.
 *
 * @backupGlobals enabled
 * @covers        Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser
 */
class ApiVersionHttpHeaderParserGetTest extends ApiVersionHttpHeaderParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(ApiVersionValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::get
     */
    public function testGetParsedApiVersion()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $this->setReflectionPropertyValue('apiVersion', $version);

        $value = $this->class->get(ApiVersionValue::ApiVersion);

        $this->assertEquals($version->value, $value);
    }

    /**
     * Test getting a API version when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::get
     */
    public function testGetApiVersionWithMissingHeader()
    {
        $value = $this->class->get(ApiVersionValue::ApiVersion);

        $this->assertNull($value);
        $this->assertPropertySame('apiVersion', NULL);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::get
     */
    public function testGetApiVersion()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $_SERVER['HTTP_API_VERSION'] = '1';

        $value = $this->class->get(ApiVersionValue::ApiVersion);

        $this->assertEquals($version->value, $value);
        $this->assertPropertySame('apiVersion', $version);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::get
     */
    public function testGetApiVersionFromCustomHeader()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $_SERVER['HTTP_X_API_VERSION'] = '1';

        $class = new ApiVersionHttpHeaderParser(MockApiVersionEnum::class, 'X-Api-Version');

        $value = $class->get(ApiVersionValue::ApiVersion);

        $this->assertEquals($version->value, $value);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::getAsEnum
     */
    public function testGetParsedApiVersionAsEnum()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $this->setReflectionPropertyValue('apiVersion', $version);

        $value = $this->class->getAsEnum(ApiVersionValue::ApiVersion);

        $this->assertEquals($version, $value);
    }

    /**
     * Test getting a API version when it's missing in the header.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::getAsEnum
     */
    public function testGetApiVersionWithMissingHeaderAsEnum()
    {
        $value = $this->class->getAsEnum(ApiVersionValue::ApiVersion);

        $this->assertNull($value);
        $this->assertPropertySame('apiVersion', NULL);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::getAsEnum
     */
    public function testGetApiVersionAsEnum()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $_SERVER['HTTP_API_VERSION'] = '1';

        $value = $this->class->getAsEnum(ApiVersionValue::ApiVersion);

        $this->assertEquals($version, $value);
        $this->assertPropertySame('apiVersion', $version);
    }

    /**
     * Test getting a parsed API version.
     *
     * @covers Lunr\Corona\Parsers\ApiVersion\ApiVersionHttpHeaderParser::getAsEnum
     */
    public function testGetApiVersionFromCustomHeaderAsEnum()
    {
        $version = MockApiVersionEnum::MOCK_1;

        $_SERVER['HTTP_X_API_VERSION'] = '1';

        $class = new ApiVersionHttpHeaderParser(MockApiVersionEnum::class, 'X-Api-Version');

        $value = $class->getAsEnum(ApiVersionValue::ApiVersion);

        $this->assertEquals($version, $value);
    }

}

?>
