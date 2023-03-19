<?php

/**
 * This file contains the ResponseGetTest class.
 *
 * SPDX-FileCopyrightText: Copyright 2011 M2mobi B.V., Amsterdam, The Netherlands
 * SPDX-FileCopyrightText: Copyright 2022 Move Agency Group B.V., Zwolle, The Netherlands
 * SPDX-License-Identifier: MIT
 */

namespace Lunr\Corona\Tests;

/**
 * This class contains test methods for the Response class.
 *
 * @covers     Lunr\Corona\Response
 */
class ResponseGetTest extends ResponseTest
{

    /**
     * Test getting existing attributes via __get.
     *
     * @param string $attr  Attribute name
     * @param mixed  $value Expected attribute value
     *
     * @dataProvider validResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingExistingAttributes($attr, $value): void
    {
        $this->assertEquals($value, $this->class->$attr);
    }

    /**
     * Test getting existing attributes via __get.
     *
     * @param string $attr Attribute name
     *
     * @dataProvider invalidResponseAttributesProvider
     * @covers       Lunr\Corona\Response::__get
     */
    public function testGettingInaccessibleAttributes($attr): void
    {
        $this->assertNull($this->class->$attr);
    }

    /**
     * Test getting existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithExistingKey(): void
    {
        $data = [ 'key' => 'value' ];

        $this->set_reflection_property_value('data', $data);

        $this->assertEquals('value', $this->class->get_response_data('key'));
    }

    /**
     * Test getting non-existing response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithNonExistingKey(): void
    {
        $this->assertNull($this->class->get_response_data('non-existing'));
    }

    /**
     * Test getting all the response data.
     *
     * @covers Lunr\Corona\Response::get_response_data
     */
    public function testGetResponseDataWithoutKey(): void
    {
        $data = [ 'key1' => 'value1', 'key2' => 'value2' ];

        $this->set_reflection_property_value('data', $data);

        $this->assertEquals($data, $this->class->get_response_data());
    }

    /**
     * Test getting existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetExistingErrorMessage(): void
    {
        $data = [ 'controller/method' => 'error message' ];

        $this->set_reflection_property_value('errmsg', $data);

        $this->assertEquals('error message', $this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting non-existing error message.
     *
     * @covers Lunr\Corona\Response::get_error_message
     */
    public function testGetNonExistantErrorMessage(): void
    {
        $this->assertNull($this->class->get_error_message('controller/method'));
    }

    /**
     * Test getting existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetExistingErrorInfo(): void
    {
        $data = [ 'controller/method' => 'error info' ];

        $this->set_reflection_property_value('errinfo', $data);

        $this->assertEquals('error info', $this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting non-existing error information.
     *
     * @covers Lunr\Corona\Response::get_error_info
     */
    public function testGetNonExistantErrorInfo(): void
    {
        $this->assertNull($this->class->get_error_info('controller/method'));
    }

    /**
     * Test getting return code without identifier with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithoutIdentifierWithEmptyCodes(): void
    {
        $this->set_reflection_property_value('return_code', []);

        $this->assertNull($this->class->get_return_code());
    }

    /**
     * Test getting return code with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithEmptyCodes(): void
    {
        $this->set_reflection_property_value('return_code', []);

        $this->assertNull($this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetExistingReturnCode(): void
    {
        $data = [ 'controller/method' => 200 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame(200, $this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting non-existing return code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetNonExistantReturnCode(): void
    {
        $this->assertNull($this->class->get_return_code('controller/method'));
    }

    /**
     * Test getting return code with highest error code.
     *
     * @covers Lunr\Corona\Response::get_return_code
     */
    public function testGetReturnCodeWithoutIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame(500, $this->class->get_return_code());
    }

    /**
     * Test getting identifier of the highest return code with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetMaximumReturnCodeIdentifiersWithEmptyCodes(): void
    {
        $this->set_reflection_property_value('return_code', []);

        $this->assertArrayEmpty($this->class->get_return_code_identifiers());
    }

    /**
     * Test getting all return code identifiers with no code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetReturnCodeIdentifiersWithEmptyCodes(): void
    {
        $this->set_reflection_property_value('return_code', []);

        $this->assertArrayEmpty($this->class->get_return_code_identifiers(TRUE));
    }

    /**
     * Test getting identifier of the highest return code.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetMaximumReturnCodeIdentifier(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertEquals('ID3', $this->class->get_return_code_identifiers(TRUE));
    }

    /**
     * Test getting all return code identifiers.
     *
     * @covers Lunr\Corona\Response::get_return_code_identifiers
     */
    public function testGetAllReturnCodeIdentifiers(): void
    {
        $data = [ 'controller/method' => 200, 'ID' => 300, 'ID3' => 500 ];

        $this->set_reflection_property_value('return_code', $data);

        $this->assertSame([ 'controller/method', 'ID', 'ID3' ], $this->class->get_return_code_identifiers());
    }

}

?>
