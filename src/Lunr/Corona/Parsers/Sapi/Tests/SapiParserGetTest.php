<?php

/**
 * This file contains the SapiParserGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2025 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

 namespace Lunr\Corona\Parsers\Sapi\Tests;

 use Lunr\Corona\Parsers\Sapi\SapiValue;
 use Lunr\Corona\Tests\Helpers\MockRequestValue;
 use RuntimeException;

 /**
  * This class contains test methods for the SapiParser class.
  *
  * @covers Lunr\Corona\Parsers\Sapi\SapiParser
  */
class SapiParserGetTest extends SapiParserTestCase
{

    /**
     * Test that getRequestValueType() returns the correct type.
     *
     * @covers Lunr\Corona\Parsers\Sapi\SapiParser::getRequestValueType
     */
    public function testGetRequestValueType()
    {
        $this->assertEquals(SapiValue::class, $this->class->getRequestValueType());
    }

    /**
     * Test getting an unsupported value.
     *
     * @covers Lunr\Corona\Parsers\Sapi\SapiParser::get
     */
    public function testGetUnsupportedValue()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unsupported request value type "Lunr\Corona\Tests\Helpers\MockRequestValue"');

        $this->class->get(MockRequestValue::Foo);
    }

    /**
     * Test getting a parsed sapi
     */
    public function testGetSapi()
    {
        $key = SapiValue::Sapi;

        $value = $this->class->get($key);

        $this->assertEquals(PHP_SAPI, $value);
    }

}

?>
